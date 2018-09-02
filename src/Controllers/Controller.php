<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Middlewares\Utils\Factory;
use Folk\Admin;

abstract class Controller
{
    protected $app;

    public function __construct(Admin $app)
    {
        $this->app = $app;
    }

    protected static function isJSON(ServerRequestInterface $request)
    {
        return $request->getHeaderLine('Accept') === 'application/json';
    }

    protected static function notFoundResponse(): ResponseInterface
    {
        return Factory::createResponse(404);
    }

    protected static function badRequestResponse(): ResponseInterface
    {
        return Factory::createResponse(400);
    }

    protected static function redirectResponse(string $url): ResponseInterface
    {
        return Factory::createResponse(302)
                ->withHeader('location', $url);
    }
}
