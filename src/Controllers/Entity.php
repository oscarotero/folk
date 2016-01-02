<?php

namespace Folk\Controllers;

use Psr7Middlewares\Middleware\FormatNegotiator;
use Zend\Diactoros\Response\RedirectResponse;
use FormManager\Builder as F;
use Folk\SearchQuery;

class Entity
{
    protected $entity;

    /**
     * GET: List/search items.
     */
    public function listItems($request, $response, $app)
    {
        $entity = $app->getEntity($request->getAttribute('entity'));
        $search = new SearchQuery($request->getQueryParams());

        //Check whether the query is an id
        if (($id = $search->getId())) {
            if ($items = $entity->read($id)) {
                $items = [$id => $items];
            } else {
                $items = [];
            }
        } else {
            $items = $entity->search($search);
        }

        //Return as json (for ajax calls)
        if (FormatNegotiator::getFormat($request) === 'json') {
            $json = [];

            foreach ($items as $id => $item) {
                $json[$id] = $entity->getLabel($id, $item);
            }

            return json_encode($json);
        }

        //Redirect to edit element if it's only one result
        if (!empty($search->getQuery()) && count($items) === 1) {
            return new RedirectResponse($app['router']->getGenerator()->generate('edit', [
                'entity' => $entity->name,
                'id' => key($items),
            ]));
        }

        //Load the values
        $row = $entity->getScheme($app['builder']);

        //Remove non-listable elements
        $removedKeys = [];

        foreach ($row as $key => $value) {
            if ($value->get('list') === false) {
                $removedKeys[] = $key;
            }
        }

        foreach ($removedKeys as $key) {
            unset($row[$key]);
        }

        //populate the data
        $rows = [];

        foreach ($items as $id => &$item) {
            $rows[$id] = clone $row;
            $rows[$id]->val($item);
        }

        //List all results
        return $app['templates']->render('pages/list', [
            'rows' => $rows,
            'entity' => $entity,
            'search' => $search,
        ]);
    }

    /**
     * POST: Create a new element
     * GET:  Display the form.
     */
    public function createItem($request, $response, $app)
    {
        $entity = $app->getEntity($request->getAttribute('entity'));

        //Create form
        $form = F::form()
            ->method('post')
            ->enctype('multipart/form-data');

        $form->add([
            'entity' => F::hidden()->val($entity->name)->class('field-data-entity'),
            'data' => $entity->getScheme($app['builder']),
        ]);

        //Save
        if ($request->getMethod() === 'POST') {
            //Load data
            $form->loadFromPsr7($request);

            if ($form->isValid()) {
                return new RedirectResponse($app['router']->getGenerator()->generate('edit', [
                    'entity' => $entity->name,
                    'id' => $entity->create($form['data']->val()),
                ]));
            }
        }

        return $app['templates']->render('pages/create', [
            'entity' => $entity,
            'form' => $form,
        ]);
    }

    /**
     * POST: Edit an element
     * GET:  Display the form.
     */
    public function editItem($request, $response, $app)
    {
        $entity = $app->getEntity($request->getAttribute('entity'));
        $id = $request->getAttribute('id');

        //Create form
        $form = F::form()
            ->method('post')
            ->enctype('multipart/form-data');

        $form->add([
            'id' => F::hidden()->val($id)->class('field-data-id'),
            'entity' => F::hidden()->val($entity->name)->class('field-data-entity'),
            'data' => $entity->getScheme($app['builder']),
        ]);

        //Save
        if ($request->getMethod() === 'POST') {
            //Load data
            $form->loadFromPsr7($request);

            if ($form->isValid()) {
                $entity->update($id, $form['data']->val());

                return new RedirectResponse($app['router']->getGenerator()->generate('edit', [
                    'entity' => $entity->name,
                    'id' => $id,
                ]));
            }
        } else {
            //View
            $data = $entity->read($id);

            $form['data']->val($data);
        }

        //Actions
        $actions = [];

        /*
        foreach ($entity->getActions() as $name => $action) {
            if (empty($action[1]) || call_user_func($action[1], $data)) {
                $actions[] = $name;
            }
        }
        */

        //Render template
        return $app['templates']->render('pages/edit', [
            'entity' => $entity,
            'actions' => $actions,
            'form' => $form,
            'id' => $id,
        ]);
    }

    /**
     * POST: Delete the element.
     */
    public function deleteItem($request, $response, $app)
    {
        $entity = $app->getEntity($request->getAttribute('entity'));

        $entity->delete($request->getAttribute('id'));

        return new RedirectResponse($app['router']->getGenerator()->generate('list', [
            'entity' => $entity->name,
        ]));
    }

    /**
     * POST: Execute an item action.
     */
    public function actionItem($request, $response, $app)
    {
        $entity = $app->getEntity($request->getAttribute('entity'));

        $data = $entity->read($request->getAttribute('id'));
        $actions = $entity->getActions();
        $name = $request->getParsedBody()['action'];

        if (empty($actions[$name])) {
            throw new \Exception("The action '{$name}' does not exists");
        }

        if (!empty($actions[$name][1]) && !call_user_func($actions[$name][1], $data)) {
            throw new \Exception("The action '{$name}' cannot be executed with this row");
        }

        call_user_func($actions[$name][0], $data);

        return new RedirectResponse($app['router']->getGenerator()->generate('edit', [
            'entity' => $entity->name,
            'id' => $request->attributes['id'],
        ]));
    }
}
