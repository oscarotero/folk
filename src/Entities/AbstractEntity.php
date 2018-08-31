<?php

namespace Folk\Entities;

use Folk\Admin;

/**
 * Base class extended by all entities.
 */
abstract class AbstractEntity implements EntityInterface
{
    protected $name;
    protected $admin;

    public $icon;
    public $title;
    public $description;

    public function __construct(string $name, Admin $admin)
    {
        $this->name = $name;
        $this->admin = $admin;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLabel($id, array $data): string
    {
        return current($data);
    }

    public function getActions($id): array
    {
        return [];
    }
}
