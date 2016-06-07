<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Zend\Diactoros\Response\RedirectResponse;

class UpdateEntity extends Entity
{
    public function html(Request $request, Response $response, Admin $app, $entityName)
    {
        $id = $request->getAttribute('id');

        $form = static::createForm($app, $entityName, $id);
        $form->loadFromPsr7($request);

        if ($form->validate()) {
            $app->getEntity($entityName)->update($id, $form['data']->val());

            return new RedirectResponse($app->getRoute('read', [
                'entity' => $entityName,
                'id' => $id,
            ]));
        }

        $response->getBody()->write(
            $app['templates']->render('pages/read', [
                'entityName' => $entityName,
                'form' => $form,
                'id' => $id,
            ])
        );

        return $response->withStatus(400);
    }
}
