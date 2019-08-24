<?php

namespace Demo\Entities;

use Folk\Entities\Yaml;
use Folk\Formats\FormatFactory;
use Folk\Formats\Group;

class Tags extends Yaml
{
    protected function getBasePath(): string
    {
        return __DIR__.'/json';
    }

    public function getScheme(FormatFactory $builder): Group
    {
        return $builder->group([
            'name' => $builder->text()
                ->label('Name'),
        ]);
    }
}
