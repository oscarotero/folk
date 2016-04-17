<?php

namespace Folk\Entities;

use Folk\Admin;

/**
 * Base class extended by all entities.
 */
abstract class AbstractEntity implements EntityInterface
{
    protected $admin;

    public $icon;
    public $title;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel($id, array $data)
    {
        return current($data);
    }
}
