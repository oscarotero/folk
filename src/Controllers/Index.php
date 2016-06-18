<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Imagecow\Image;

class Index
{
    public function __invoke(Request $request, Response $response, Admin $app)
    {
        $query = $request->getQueryParams();

        if (isset($query['thumb'])) {
            return $this->thumb($query['thumb'], $request, $response, $app);
        }

        return $app['templates']->render('pages/index');
    }

    private function thumb($thumb, Request $request, Response $response, Admin $app)
    {
        $thumb = $app->getPath($thumb);

        if (!is_file($thumb)) {
            return $response->withStatus(404);
        }

        $image = Image::fromFile($thumb);
        $image->resize(0, 300);

        $response->getBody()->write($image->getString());

        return $response->withHeader('Content-Type', $image->getMimeType());
    }
}
