<?php

namespace Demo\Entities;

use Folk\Entities\Yaml;
use FormManager\Builder;
use FormManager\InvalidValueException;

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

            'tags' => $builder->relationMany($this->admin->getEntity('tags'))
                ->allowNewValues()
                ->data('config', [
                    'create' => 'name'
                ])
                ->label('Tags'),

            'category' => $builder->select()
                ->options([
                    'food' => 'Food',
                    'sports' => 'Sports',
                    'life' => 'Life',
                ])
                ->label('Category'),

            'actived' => $builder->checkbox()
                ->set('editable', true)
                ->label('Actived'),
        ]);
    }
}
