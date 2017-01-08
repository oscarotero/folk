<?php

namespace Folk\Providers;

use Fol\App;
use Interop\Container\ServiceProvider;
use Folk\Formats\FormatFactory;

class Formats implements ServiceProvider
{
    public function getServices()
    {
        return [
        	'builder' => function (App $app): FormatFactory {
            	return new FormatFactory($app);
        	}
        ];
    }
}
