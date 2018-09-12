<?php

namespace Folk\Schema;

use InvalidArgumentException;

abstract class Factory
{
    const SCHEMA_NAMESPACE = 'Folk\\Schema\\Formats\\';

    /**
     * Factory to create schema elements
     */
    public static function __callStatic(string $name, $arguments)
    {
        $name = ucfirst($name);
        $class = sprintf('%s%s\\%s', self::SCHEMA_NAMESPACE, $name, $name);

        if (class_exists($class)) {
            return new $class(...$arguments);
        }

        throw new InvalidArgumentException(
            sprintf('Schema element %s not found', $name)
        );
    }
}
