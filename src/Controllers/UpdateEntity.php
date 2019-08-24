<?php

namespace Folk\Controllers;

use Middlewares\Utils\Factory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;

class UpdateEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $id = $request->getAttribute('id');

        $form = $this->createForm($entityName, $id);
        $form->loadFromPsr7($request);

        if ($form->validate()) {
            $this->app->getEntity($entityName)->update($id, $form['data']->val());

            return new RedirectResponse($this->app->getRoute('read', [
                'entity' => $entityName,
                'id' => $id,
            ]));
        }

        echo $this->app->get('templates')->render('pages/read', [
            'entityName' => $entityName,
            'form' => $form,
            'id' => $id,
        ]);

        return Factory::createResponse(400);
    }
}
