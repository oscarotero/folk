<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use League\Plates\Engine;
use Folk\MaterialDesignIcons;
use InlineSvg\Collection;

class Templates implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['templates'] = function ($app) {
            $templates = new Engine(dirname(__DIR__).'/templates');

            $templates->registerFunction('icona', function ($name) {
                return '<svg viewBox="0 0 12 12" class="ia-12 ia-'.$name.'" width="24"><line x1="0" x2="10" y1="0" y2="0"/><line x1="0" x2="10" y1="0" y2="0"/><line x1="0" x2="10" y1="0" y2="0"/><circle cx="5" cy="5" r="4"/></svg>';
            });

            $source = new MaterialDesignIcons(dirname(__DIR__).'/../assets/vendor/material-design-icons');
            $icons = new Collection($source);

            $templates->addData(['app' => $app]);

            $templates->registerFunction('icon', function ($name) use ($icons) {
                return $icons->get($name);
            });

            return $templates;
        };
    }
}
