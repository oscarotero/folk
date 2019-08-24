<?php

namespace Folk\Providers;

use Fol\App;
use Folk\Formats\FormatFactory;
use Interop\Container\ServiceProviderInterface;

class Formats implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'builder' => function (App $app): FormatFactory {
                return new FormatFactory($app);
            },
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
