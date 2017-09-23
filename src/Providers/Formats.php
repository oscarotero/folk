<?php

namespace Folk\Providers;

use Fol\App;
use Interop\Container\ServiceProviderInterface;
use Folk\Formats\FormatFactory;

class Formats implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
        	'builder' => function (App $app): FormatFactory {
            	return new FormatFactory($app);
        	}
        ];
    }

    public function getExtensions() {
    	return [];
    }
}
