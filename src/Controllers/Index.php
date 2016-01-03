<?php

namespace Folk\Controllers;

use Zend\Diactoros\Response\RedirectResponse;

class Index
{
    public function index($request, $response, $app)
    {
        return $app['templates']->render('pages/index');
    }

    public function entity($request, $response, $app)
    {
        $entity = $request->getAttribute('entity');

        return new RedirectResponse($app->getRouteUrl('list', [
            'entity' => $entity,
        ]));
    }
}
