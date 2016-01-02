<?php

namespace Folk\Controllers;

use Zend\Diactoros\Response\RedirectResponse;
use Psr7Middlewares\Middleware\ErrorHandler;

class Index
{
    public function index($request, $response, $app)
    {
        return $app['templates']->render('pages/index');
    }

    public function entity($request, $response, $app)
    {
        $entity = $request->getAttribute('entity');

        return new RedirectResponse($app['router']->getGenerator()->generate('list', [
            'entity' => $entity,
        ]));
    }
}
