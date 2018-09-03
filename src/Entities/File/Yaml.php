<?php

namespace Folk\Entities\File;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

abstract class Yaml extends File
{
    protected $extension = 'yml';

    protected function stringify(array $data): string
    {
        return SymfonyYaml::dump($data);
    }

    protected function parse(string $source): array
    {
        return (array) SymfonyYaml::parse($source);
    }
}
