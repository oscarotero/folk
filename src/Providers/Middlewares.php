<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use Folk\FormatFactory;
use Psr7Middlewares\Middleware;

class Middlewares implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['middlewares'] = function ($app) {
            return [
                Middleware::create(function () use ($app) {
                    if ($app->has('users')) {
                        return Middleware::DigestAuthentication($app['users']);
                    }

                    return false;
                }),

                Middleware::trailingSlash()->basePath($app->getUrlPath()),

                Middleware::FormatNegotiator(),

                function ($request, $response, $next) {
                    $path = $request->getUri()->getPath();

                    $file = dirname(__DIR__).'/assets'.$path;

                    if (is_file($file)) {
                        $response->getBody()->write(file_get_contents($file));
                        return $response;
                    }

                    return $next($request, $response);
                },

                Middleware::AuraRouter($app['router'])->arguments($app),
            ];
        };
    }
}
