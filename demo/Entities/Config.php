<?php

namespace Demo\Entities;

use Folk\Entities\FlyCrud;
use Folk\Formats\Group;
use Folk\Formats\FormatFactory;
use FlyCrud\Directory;
use FlyCrud\Formats\Json;

class Config extends FlyCrud
{
    protected function getDirectory(): Directory
    {
        return Directory::make(dirname(__DIR__), new Json());
    }

    public function getScheme(FormatFactory $builder): Group
    {
        return $builder->group([
            'dev' => $builder->checkbox()->label('Dev mode')
        ]);
    }
}
