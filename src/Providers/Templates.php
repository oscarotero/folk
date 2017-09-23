<?php

namespace Folk\Providers;

use Fol\App;
use Interop\Container\ServiceProviderInterface;
use League\Plates\Engine;
use InlineSvg\Collection;

class Templates implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'templates' => function (App $app): Engine {
                $root = dirname(dirname(__DIR__));

                $templates = new Engine($root.'/templates');
                $icons = Collection::fromPath($root.'/assets/icons');

                $templates->addData(['app' => $app]);

                $templates->registerFunction('icon', function ($name) use ($icons) {
                    return $icons->get($name);
                });

                return $templates;
            }
        ];
    }

    public function getExtensions() {
        return [];
    }
}
