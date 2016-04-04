<?php

namespace Folk\Entities;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

abstract class Yaml extends File implements EntityInterface
{
    protected $extension = 'yml';

    /**
     * Transform the data to a string.
     * 
     * @param array $data
     * 
     * @return string
     */
    protected function stringify(array $data)
    {
        return SymfonyYaml::dump($data);
    }

    /**
     * Transform the string to an array.
     * 
     * @param string $source
     * 
     * @return array
     */
    protected function parse($source)
    {
        return (array) SymfonyYaml::parse($source);
    }
}
