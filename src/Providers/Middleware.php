<?php

namespace Folk\Providers;

use Fol\App;
use Interop\Container\ServiceProvider;
use Middleland\Dispatcher;
use Middlewares;
use Gettext\{Translator, Translations};

class Middleware implements ServiceProvider
{
    public function getServices()
    {
        return [
            'middleware' => function (App $app): Dispatcher {
                $middleware = [];

                if ($app->has('users')) {
                    $middleware[] = new Middlewares\DigestAuthentication($app->get('users'));
                }

                $middleware[] = new Middlewares\Expires();
                $middleware[] = (new Middlewares\ErrorHandler())
                    ->catchExceptions(false)
                    ->statusCode(function ($code) {
                        return $code > 400 && $code < 600;
                    })
                    ->arguments($app);

                $middleware[] = new Middlewares\BasePath($app->getUri()->getPath());
                $middleware[] = new Middlewares\TrailingSlash();
                $middleware[] = new Middlewares\ContentType();
                $middleware[] = new Middlewares\ContentLanguage(['en', 'gl', 'es']);

                $middleware[] = function ($request, $next) use ($app) {
                    $language = $request->getHeaderLine('Accept-Language');
                    $translator = new Translator();
                    $translator->loadTranslations(Translations::fromPoFile(dirname(dirname(__DIR__)).'/locales/'.$language.'.po'));
                    $prev = $translator->register();

                    $app->get('templates')->addData(['language' => $language]);

                    $response = $next->process($request);

                    if ($prev) {
                        $prev->register();
                    }

                    return $response;
                };

                $middleware[] = (new Middlewares\MethodOverride())
                    ->parsedBodyParameter('method-override');

                $middleware[] = (new Middlewares\Reader(dirname(dirname(__DIR__)).'/assets'))
                    ->continueOnError();

                $middleware[] = (new Middlewares\AuraRouter($app->get('router')))
                    ->arguments($app);

                return new Dispatcher($middleware);
            }
        ];
    }
}
