<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;

class Index
{
    public function __invoke(Request $request, Response $response, Admin $app)
    {
        return $app['templates']->render('pages/index');
    }
}
