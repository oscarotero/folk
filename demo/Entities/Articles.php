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
                ->data('config', [
                    'extraPlugins' => 'autogrow,wordcount,notification'
                ])
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

    public function getActions($id)
    {
        return [
            [
                'label' => 'Reload',
                'target' => '_blank',
                'icon' => 'editor/insert_drive_file',
                'url' => $this->admin->getRoute('read', ['entity' => $this->name, 'id' => $id])
            ],[
                'label' => 'Insert new article',
                'target' => '_blank',
                'method' => 'post',
                'url' => $this->admin->getRoute('create', ['entity' => $this->name]),
                'data' => [
                    'method-override' => 'PUT',
                    'entity' => $this->name,
                    'data[title]' => 'New article'
                ]
            ]
        ];
    }
}
