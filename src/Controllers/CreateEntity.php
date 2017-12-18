<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Middlewares\Utils\Factory;
use Zend\Diactoros\Response\RedirectResponse;

class CreateEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $entity = $this->app->getEntity($entityName);
        $form = $this->createForm($entityName);
        $form->loadFromPsr7($request);

        if ($form->validate()) {
            return new RedirectResponse($this->app->getRoute('read', [
                'entity' => $entityName,
                'id' => $entity->create($form['data']->val()),
            ]));
        }

        echo $this->app->get('templates')->render('pages/insert', [
                'entityName' => $entityName,
                'form' => $form
            ]);

        return Factory::createResponse(400);
    }
}
