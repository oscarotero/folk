<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;

class Read extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $entity = $this->app->getEntity($entityName);
        $id = $request->getAttribute('id');

        $row = $entity->getRow();
        $row->setValue($entity->read($id));

        return $this->app->get('templates')
            ->render('pages/read', compact('entityName', 'id', 'row'));
    }

    public function json(Request $request, string $entityName)
    {
        $id = $request->getAttribute('id');

        return json_encode($this->app->getEntity($entityName)->read($id));
    }
}
