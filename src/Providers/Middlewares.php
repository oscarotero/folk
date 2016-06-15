<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use Psr7Middlewares\Middleware;
use Gettext\Translator;
use Gettext\Translations;

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

                Middleware::create(function () {
                    return class_exists('Whoops\\Run') ? Middleware::whoops() : false;
                }),

                Middleware::expires(),

                Middleware::basePath($app->getUrlPath()),

                Middleware::trailingSlash(),

                Middleware::formatNegotiator(),

                Middleware::languageNegotiator(['en', 'gl', 'es']),

                function ($request, $response, $next) use ($app) {
                    $language = Middleware\LanguageNegotiator::getLanguage($request);
                    $translator = new Translator();
                    $translator->loadTranslations(Translations::fromPoFile(dirname(dirname(__DIR__)).'/locales/'.$language.'.po'));
                    $prev = $translator->register();

                    $app['templates']->addData(['language' => $language]);

                    $response = $next($request, $response);

                    if ($prev) {
                        $prev->register();
                    }

                    return $response;
                },

                Middleware::methodOverride()
                    ->parameter('method-override'),

                Middleware::readResponse(dirname(dirname(__DIR__)).'/assets')
                    ->continueOnError(),

                Middleware::AuraRouter($app['router'])
                    ->arguments($app),
            ];
        };
    }
}
