<?php

namespace Demo\Entities;

use Folk\Entities\YamlEntity;
use FormManager\Builder;

class MoreItems extends YamlEntity
{
    protected function getBasePath()
    {
        return __DIR__.'/yaml';
    }

    public function getScheme(Builder $builder)
    {
        return $builder->group([
            'name' => $builder->text()->label('Name'),
            'text' => $builder->html()->label('Text'),
        ]);
    }

    public function getId(array $data)
    {
        return $data['name'];
    }
}
