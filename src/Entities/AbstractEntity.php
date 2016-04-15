<?php

namespace Folk\Entities;

use Folk\Admin;

/**
 * Base class extended by all entities.
 */
abstract class AbstractEntity implements EntityInterface
{
    protected $admin;
    protected $name;

    public $icon;
    public $title;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function __construct($name, Admin $admin)
    {
        $this->admin = $admin;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel($id, array $data)
    {
        return current($data);
    }
}
