<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Folk\Entities\EntityInterface;

class ReadEntity extends Entity
{
    public function html(Request $request, Response $response, Admin $app, $entityName)
    {
        $id = $request->getAttribute('id');

        $form = static::createForm($app, $entityName, $id);
        $form['data']->val($app->getEntity($entityName)->read($id));

        //Render template
        return $app['templates']->render('pages/read', [
            'entityName' => $entityName,
            'form' => $form,
            'id' => $id,
        ]);
    }
}
