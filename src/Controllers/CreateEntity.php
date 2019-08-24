<?php

namespace Folk\Controllers;

use Middlewares\Utils\Factory;
use Psr\Http\Message\ServerRequestInterface as Request;

class CreateEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $entity = $this->app->getEntity($entityName);
        $form = $this->createForm($entityName);
        $form->loadFromPsr7($request);

        if ($form->validate()) {
            return Factory::createResponse(302)
                ->withHeader('Location', $this->app->getRoute('read', [
                    'entity' => $entityName,
                    'id' => $entity->create($form['data']->val()),
                ]));
        }

        echo $this->app->get('templates')->render('pages/insert', [
                'entityName' => $entityName,
                'form' => $form,
            ]);

        return Factory::createResponse(400);
    }
}
