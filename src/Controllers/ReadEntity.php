<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Folk\Entities\EntityInterface;

class ReadEntity extends Entity
{
    public function html(Request $request, Response $response, Admin $app, EntityInterface $entity)
    {
        $id = $request->getAttribute('id');

        $form = static::createForm($entity, $app, $id);
        $form['data']->val($entity->read($id));

        //Render template
        return $app['templates']->render('pages/read', [
            'entity' => $entity,
            'form' => $form,
            'id' => $id,
        ]);
    }
}
