<?php

namespace Folk\Entities;

use Symfony\Component\Yaml\Yaml;

abstract class YamlEntity extends FileEntity implements EntityInterface
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
        return Yaml::dump($data);
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
        return Yaml::parse($source);
    }
}
