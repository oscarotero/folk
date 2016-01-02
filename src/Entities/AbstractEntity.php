<?php

namespace Folk\Entities;

use Folk\Admin;

/**
 * Base class extended by all entities.
 */
abstract class AbstractEntity implements EntitiesInterface
{
    protected $manager;

    public $name;
    public $title;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function setAdmin($name, Admin $admin)
    {
        $this->admin = $admin;
        $this->name = $name;

        if (empty($this->title)) {
            $this->title = ucfirst($name);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel($id, array $data)
    {
        return current($data);
    }
}
