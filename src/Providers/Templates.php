<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use League\Plates\Engine;

class Templates implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['templates'] = function ($app) {
            $templates = new Engine(dirname(__DIR__).'/templates');

            $templates->registerFunction('asset', function ($path = '') use ($app) {
                return call_user_func_array([$app, 'getUrl'], func_get_args());
            });

            $templates->registerFunction('url', function ($name, array $data = array(), array $query = null) use ($app) {
                return $app['router']->getGenerator()->generate($name, $data).($query ? '?'.http_build_query($query) : '');
            });

            $templates->registerFunction('icon', function ($name) {
                return '<svg viewBox="0 0 12 12" class="ia-12 ia-'.$name.'" width="24"><line x1="0" x2="10" y1="0" y2="0"/><line x1="0" x2="10" y1="0" y2="0"/><line x1="0" x2="10" y1="0" y2="0"/><circle cx="5" cy="5" r="4"/></svg>';
            });

            $templates->addData(['app' => $app]);

            return $templates;
        };
    }
}
