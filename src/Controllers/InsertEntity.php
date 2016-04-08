<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Folk\Entities\EntityInterface;

class InsertEntity extends Entity
{
    public function html(Request $request, Response $response, Admin $app, EntityInterface $entity)
    {
        return $app['templates']->render('pages/insert', [
            'entity' => $entity,
            'form' => static::createForm($entity, $app),
        ]);
    }
}
