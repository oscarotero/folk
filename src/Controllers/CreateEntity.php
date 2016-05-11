<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Zend\Diactoros\Response\RedirectResponse;

class CreateEntity extends Entity
{
    public function html(Request $request, Response $response, Admin $app, $entityName)
    {
        $entity = $app->getEntity($entityName);
        $form = static::createForm($app, $entityName);
        $form->loadFromPsr7($request);

        if ($form->isValid()) {
            return new RedirectResponse($app->getRoute('read', [
                'entity' => $entityName,
                'id' => $entity->create($form['data']->val()),
            ]));
        }

        return $app['templates']->render('pages/insert', [
            'entityName' => $entityName,
            'form' => $form,
        ]);
    }
}
