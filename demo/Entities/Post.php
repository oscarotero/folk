<?php

namespace Demo\Entities;

use Folk\Entities\AbstractEntity;
use Folk\SearchQuery;
use FormManager\Builder;

class Post extends AbstractEntity
{
    public function search(SearchQuery $search = null)
    {
        return [
            1 => [
                'title' => 'Hello world'
            ]
        ];
    }

    public function create(array $data)
    {
        return 1;
    }

    public function read($id)
    {
        return [
            'title' => 'Hello world'
        ];
    }

    public function update($id, array $data)
    {
        return $this->read($id);
    }

    public function delete($id)
    {
    }

    public function getScheme(Builder $builder)
    {
        return $builder->group([
            'title' => $builder->text()->label('Title')
        ]);
    }
}