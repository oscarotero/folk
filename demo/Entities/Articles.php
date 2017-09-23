<?php

namespace Demo\Entities;

use Folk\Entities\Yaml;
use Folk\Formats\Group;
use Folk\Formats\FormatFactory;

class Articles extends Yaml
{
    protected function getBasePath(): string
    {
        return __DIR__.'/yaml';
    }

    public function getScheme(FormatFactory $builder): Group
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

    public function getActions($id): array
    {
        return [
            [
                'label' => 'Reload',
                'target' => '_blank',
                'icon' => 'reload',
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
