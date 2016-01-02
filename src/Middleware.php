<?php

namespace Folk;

use Relay\RelayBuilder;
use Psr7Middlewares\Middleware as M;

class Middleware
{
    private $basePath = '/admin';
    private $app;

    public function __construct(Admin $app)
    {
        $this->app = $app;
    }

    public function __invoke($request, $response, $next)
    {
        $path = $request->getUri()->getPath();

        if (strpos($path, $this->basePath) !== 0) {
            return $next($request, $response);
        }

        $middlewares = $this->app['middlewares'];

        $dispatcher = (new RelayBuilder())->newInstance($middlewares);

        return $dispatcher($request, $response);
    }
}
