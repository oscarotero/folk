<?php

namespace Demo\Entities;

use Folk\Entities\File\Yaml;
use Folk\Schema\Factory as f;
use Folk\Schema\RowInterface;

class Tags extends Yaml
{
    protected function getBasePath(): string
    {
        return __DIR__.'/json';
    }

    public function getScheme(): RowInterface
    {
        return f::row([
            'name' => f::text('Name')
        ]);
    }
}
