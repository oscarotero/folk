<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;

class InsertEntity extends Entity
{
    public function html(Request $request, Admin $app, string $entityName)
    {
        return $app['templates']->render('pages/insert', [
            'entityName' => $entityName,
            'form' => static::createForm($app, $entityName),
        ]);
    }
}
