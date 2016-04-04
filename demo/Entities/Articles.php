<?php

namespace Demo\Entities;

use Folk\Entities\Yaml;
use FormManager\Builder;

class Articles extends Yaml
{
    protected function getBasePath()
    {
        return __DIR__.'/yaml';
    }

    public function getScheme(Builder $builder)
    {
        return $builder->group([
            'title' => $builder->text()
                ->label('Title'),

            'intro' => $builder->html()
                ->label('Introduction'),

            'category' => $builder->select()
                ->options([
                    'food' => 'Food',
                    'sports' => 'Sports',
                    'life' => 'Life',
                ])
                ->label('Category'),

            'actived' => $builder->checkbox()
                ->label('Actived'),
        ]);
    }
}
