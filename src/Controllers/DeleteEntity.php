<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Zend\Diactoros\Response\RedirectResponse;

class DeleteEntity extends Entity
{
    public function html(Request $request, Response $response, Admin $app, $entityName)
    {
        $app->getEntity($entityName)->delete($request->getAttribute('id'));

        return new RedirectResponse($app->getRoute('search', [
            'entity' => $entityName,
        ]));
    }
}
