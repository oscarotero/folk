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

    public $title;
    public $description;
    public $icon;

    public function __construct(string $title, string $description = '', string $icon = '')
    {
        $this->title = $title;
        $this->description = $description;
        $this->icon = $icon;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getIcon(): string
    {
        return $this->icon;
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
