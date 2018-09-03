<?php

namespace Folk\Entities;

/**
 * Base class extended by all entities.
 */
abstract class Entity implements EntityInterface
{
    protected $title;
    protected $description;
    protected $icon;

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
