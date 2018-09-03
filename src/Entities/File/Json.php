<?php

namespace Folk\Entities\File;

abstract class Json extends File
{
    protected $extension = 'json';

    protected function stringify(array $data): string
    {
        return json_encode($data);
    }

    protected function parse(string $source): array
    {
        return json_decode($source, true);
    }
}
