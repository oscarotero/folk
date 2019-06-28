<?php

namespace Folk\Entities;

abstract class Json extends File
{
    protected $extension = 'json';

    /**
     * Transform the data to a string.
     * 
     * @param array $data
     * 
     * @return string
     */
    protected function stringify(array $data): string
    {
        return json_encode($data);
    }

    /**
     * Transform the string to an array.
     * 
     * @param string $source
     * 
     * @return array
     */
    protected function parse(string $source): array
    {
        return json_decode($source, true);
    }
}
