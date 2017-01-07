<?php

namespace Folk\Providers;

use Fol\{App, ServiceProviderInterface};
use Folk\Formats\FormatFactory;

class Formats implements ServiceProviderInterface
{
    public function register(App $app)
    {
        $app['builder'] = function (App $app): FormatFactory {
            return new FormatFactory($app);
        };
    }
}
