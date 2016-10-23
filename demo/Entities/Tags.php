<?php

namespace Demo\Entities;

use Folk\Entities\Yaml;
use FormManager\Builder;
use FormManager\InvalidValueException;

class Tags extends Yaml
{
    protected function getBasePath()
    {
        return __DIR__.'/json';
    }

    public function getScheme(Builder $builder)
    {
        return $builder->group([
            'name' => $builder->text()
                ->label('Name')
        ]);
    }
}
