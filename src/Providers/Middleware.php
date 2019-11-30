<?php

namespace Folk\Providers;

use Fol\App;
use Gettext\Translations;
use Gettext\Translator;
use Gettext\TranslatorFunctions;
use Interop\Container\ServiceProviderInterface;
use Middleland\Dispatcher;
use Middlewares;

class Middleware implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'middleware' => function (App $app): Dispatcher {
                $middleware = [];

                $middleware[] = new Middlewares\BasePath($app->getUri()->getPath());
                $middleware[] = new Middlewares\TrailingSlash();
                $middleware[] = new Middlewares\ContentType();
                $middleware[] = new Middlewares\ContentLanguage(['en', 'gl', 'es']);

                $middleware[] = function ($request, $next) use ($app) {
                    $language = $request->getHeaderLine('Accept-Language');
                    $translator = (new Translator())->loadTranslations(dirname(dirname(__DIR__)).'/locales/'.$language.'.php');
                    $prev = TranslatorFunctions::register($translator);

                    $app->get('templates')->addData(['language' => $language]);

                    $response = $next->handle($request);

                    if ($prev) {
                        TranslatorFunctions::register($prev);
                    }

                    return $response;
                };

                $middleware[] = (new Middlewares\MethodOverride())
                    ->parsedBodyParameter('method-override');

                $middleware[] = Middlewares\Reader::createFromDirectory(dirname(dirname(__DIR__)).'/assets')
                    ->continueOnError();

                $middleware[] = new Middlewares\AuraRouter($app->get('router'));

                $container = new Middlewares\Utils\RequestHandlerContainer([$app]);
                $middleware[] = new Middlewares\RequestHandler($container);

                return new Dispatcher($middleware);
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
