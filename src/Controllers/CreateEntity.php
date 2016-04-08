<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Folk\Entities\EntityInterface;
use Zend\Diactoros\Response\RedirectResponse;

class CreateEntity extends Entity
{
    public function html(Request $request, Response $response, Admin $app, EntityInterface $entity)
    {
        $form = static::createForm($entity, $app);
        $form->loadFromPsr7($request);

        if ($form->isValid()) {
            return new RedirectResponse($app->getRoute('read', [
                'entity' => $entity->getName(),
                'id' => $entity->create($form['data']->val()),
            ]));
        }

        return $app['templates']->render('pages/create', [
            'entity' => $entity,
            'form' => $form,
        ]);
    }
}
