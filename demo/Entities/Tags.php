<?php

namespace Demo\Entities;

use Folk\Entities\Yaml;
use Folk\Formats\Group;
use Folk\Formats\FormatFactory;
use Folk\SchemaFactory as f;
use Folk\Schema\RowInterface;

class Tags extends Yaml
{
    protected function getBasePath(): string
    {
        return __DIR__.'/json';
    }

    public function getRow(): RowInterface
    {
        return f::row([
            'name' => f::text('Name')
        ]);
    }
}
