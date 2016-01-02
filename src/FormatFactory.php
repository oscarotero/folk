<?php

namespace Folk;

use FormManager\FactoryInterface;
use FormManager\Factory;
use FormManager\Builder;

/**
 * Class to create instances of formats.
 */
class FormatFactory extends Factory implements FactoryInterface
{
    protected $builder;
    protected $namespaces = [
        'Folk\\Formats\\',
    ];

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get an instance of an DataElementInterface.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return null|DataElementInterface
     */
    public function get($name, array $arguments)
    {
        if (($class = $this->getClass($name)) !== false) {
            array_unshift($arguments, $this->builder);

            return $class->newInstanceArgs($arguments);
        }
    }
}
