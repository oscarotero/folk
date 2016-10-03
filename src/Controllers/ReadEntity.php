<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;

class ReadEntity extends Entity
{
    public function html(Request $request, Admin $app, $entityName)
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

    public function json(Request $request, Admin $app, $entityName)
    {
        $id = $request->getAttribute('id');

        return json_encode($app->getEntity($entityName)->read($id));
    }
}
