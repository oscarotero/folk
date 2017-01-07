<?php

namespace Folk\Formats;

use Folk\Admin;
use InvalidArgumentException;

/**
 * Class to create instances of formats.
 */
class FormatFactory
{
    private $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Returns a format instance
     *
     * @param string $name
     * @param array  $arguments
     */
    public function __call($name, $arguments)
    {
        return $this->get($name, $arguments);
    }

    /**
     * Returns the admin instance
     *
     * @return Admin
     */
    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    /**
     * Returns a format instance.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return FormatInterface
     */
    private function get($name, array $arguments): FormatInterface
    {
        $class = 'Folk\\Formats\\'.ucfirst($name);

        if (!class_exists($class)) {
            throw new InvalidArgumentException("The format {$name} does not exists");
        }

        return new $class($this, ...$arguments);
    }
}
