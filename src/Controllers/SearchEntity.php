<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Folk\Entities\EntityInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Folk\SearchQuery;

class SearchEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $entity = $this->app->getEntity($entityName);
        $search = new SearchQuery($request->getQueryParams());
        $items = $this->search($entity, $search);

        //Redirect to edit element if it's only one result
        if (count($items) === 1 && !empty($search->buildQuery())) {
            return new RedirectResponse($this->app->getRoute('read', [
                'entity' => $entityName,
                'id' => key($items),
            ]));
        }

        //Load the values
        $row = $entity->getScheme($this->app->get('builder'));

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
        return $this->app->get('templates')->render('pages/search', [
            'rows' => $rows,
            'entityName' => $entityName,
            'search' => $search,
        ]);
    }

    public function json(Request $request, string $entityName)
    {
        $entity = $this->app->getEntity($entityName);

        $search = new SearchQuery($request->getQueryParams());

        $json = [];

        foreach ($this->search($entity, $search) as $id => $item) {
            $json[$id] = $entity->getLabel($id, $item);
        }

        return json_encode($json);
    }

    /**
     * Execute the search in the entity.
     * 
     * @param EntityInterface $entity
     * @param SearchQuery     $search
     * 
     * @return array
     */
    private function search(EntityInterface $entity, SearchQuery $search)
    {
        if ($search->getPage() === null) {
            $search->setPage(1);
        }

        return $entity->search($search);
    }
}
