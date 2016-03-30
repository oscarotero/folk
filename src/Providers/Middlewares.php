<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
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

                Middleware::create(function () use ($app) {
                    if ($app->has('cache')) {
                        return Middleware::cache($app['cache']);
                    }

                    return false;
                }),

                Middleware::basePath($app->getUrlPath()),

                Middleware::trailingSlash(),

                Middleware::formatNegotiator(),

                Middleware::readResponse(dirname(dirname(__DIR__)).'/assets')
                    ->continueOnError(),

                Middleware::AuraRouter($app['router'])
                    ->arguments($app),
            ];
        };
    }
}
