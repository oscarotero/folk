<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Folk\FormFactory;
use Middlewares\Utils\Factory;

/**
 * Create a new row
 */
class Create extends Controller
{
    public function __invoke(ServerRequestInterface $request)
    {
        //JSON request
        if (self::isJSON($request)) {
            return self::notFoundResponse();
        }

        //HTML request
        $entityName = $request->getAttribute('entityName');

        if (!$this->app->hasEntity($entityName)) {
            return self::notFoundResponse();
        }

        $entity = $this->app->getEntity($entityName);
        $row = $entity->getScheme();

        $form = FormFactory::update($row);
        $form->loadFromServerRequest($request);
        $value = $form->getValue();

        if ($form->isValid()) {
            $id = $entity->create($value['data']);
            return self::redirectResponse($this->app->getRoute('read', compact('entityName', 'id')));
        }

        $row->setValue($value['data']);

        echo $this->app->get('templates')->render('pages/blank', compact('entityName', 'row'));

        return self::badRequestResponse();
    }
}
