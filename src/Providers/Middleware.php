<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use Middlewares;
use mindplay\middleman\Dispatcher;
use Gettext\Translator;
use Gettext\Translations;

class Middleware implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['middleware'] = function ($app) {
            $middleware = [];

            if ($app->has('users')) {
                $middleware[] = new Middlewares\DigestAuthentication($app['users']);
            }

            $middleware[] = new Middlewares\Expires();
            $middleware[] = (new Middlewares\ErrorHandler())
                ->catchExceptions()
                ->statusCode(function ($code) {
                    return $code > 400 && $code < 600;
                })
                ->arguments($app);

            $middleware[] = new Middlewares\BasePath($app->getUrlPath());
            $middleware[] = new Middlewares\TrailingSlash();
            $middleware[] = new Middlewares\ContentType();
            $middleware[] = new Middlewares\ContentLanguage(['en', 'gl', 'es']);

            $middleware[] = function ($request, $next) use ($app) {
                $language = $request->getHeaderLine('Accept-Language');
                $translator = new Translator();
                $translator->loadTranslations(Translations::fromPoFile(dirname(dirname(__DIR__)).'/locales/'.$language.'.po'));
                $prev = $translator->register();

                $app['templates']->addData(['language' => $language]);

                $response = $next($request);

                if ($prev) {
                    $prev->register();
                }

                return $response;
            };

            $middleware[] = (new Middlewares\MethodOverride())
                ->parsedBodyParameter('method-override');

            $middleware[] = (new Middlewares\Reader(dirname(dirname(__DIR__)).'/assets'))
                ->continueOnError();

            $middleware[] = (new Middlewares\AuraRouter($app['router']))
                ->arguments($app);

            return new Dispatcher($middleware);
        };
    }
}
