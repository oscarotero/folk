<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use FormManager\Builder as FormBuilder;
use Folk\FormatFactory;

class Builder implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['builder'] = function ($app) {
            $builder = new FormBuilder();
            $builder->add(new FormatFactory($builder));

            return $builder;
        };
    }
}
