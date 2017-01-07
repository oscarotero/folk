<?php

namespace Folk\Providers;

use Fol\{App, ServiceProviderInterface};
use League\Plates\Engine;
use Folk\MaterialDesignIcons;
use InlineSvg\Collection;

class Templates implements ServiceProviderInterface
{
    public function register(App $app)
    {
        $app['templates'] = function (App $app): Engine {
            $root = dirname(dirname(__DIR__));

            $templates = new Engine($root.'/templates');
            $icons = new Collection(new MaterialDesignIcons($root.'/assets/icons'));

            $templates->addData(['app' => $app]);

            $templates->registerFunction('icon', function ($name) use ($icons) {
                return $icons->get($name);
            });

            return $templates;
        };
    }
}
