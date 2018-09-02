<?php

namespace Folk\Providers;

use Fol\App;
use Interop\Container\ServiceProviderInterface;
use League\Plates\Engine;

class Templates implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'templates' => function (App $app): Engine {
                $root = dirname(dirname(__DIR__));

                $templates = new Engine($root.'/templates');
                $templates->addData(['app' => $app]);

                return $templates;
            }
        ];
    }

    public function getExtensions()
    {
        return [];
    }
}
