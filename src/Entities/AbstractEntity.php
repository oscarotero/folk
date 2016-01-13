<?php

namespace Folk\Entities;

use Folk\Admin;

/**
 * Base class extended by all entities.
 */
abstract class AbstractEntity implements EntityInterface
{
    public $admin;
    public $name;
    public $title;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function getLabel($id, array $data)
    {
        return current($data);
    }
}
