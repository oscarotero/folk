<?php

namespace Demo\Entities;

use Folk\Entities\File\Yaml;
use Folk\Schema\Factory as f;

class Tags extends Yaml
{
    protected function getBasePath(): string
    {
        return __DIR__.'/json';
    }

    public function getScheme(): array
    {
        return [
            'checkbox' => f::checkbox('Checkbox'),
            'color' => f::color('Color'),
            'date' => f::date('Date'),
            'datetime' => f::datetime('Datetime'),
            'email' => f::email('Email'),
            'file' => f::file('File'),
            'group' => f::group('Group', [
                'title' => f::text('Title'),
                'body' => f::textarea('Body'),
            ]),
            'radios' => f::radios('Colors', [
                'red' => 'Red',
                'blue' => 'Blue',
                'green' => 'Green',
            ]),
            'select' => f::select('Select', [
                'red' => 'Red',
                'blue' => 'Blue',
                'green' => 'Green',
            ]),
            'hidden' => f::hidden('foo'),
            'month' => f::month('Month'),
            'number' => f::number('Number'),
            'range' => f::range('Range'),
            'tel' => f::tel('Tel'),
            'time' => f::time('Time'),
            'url' => f::url('Url'),
            'week' => f::week('Week'),
        ];
    }
}
