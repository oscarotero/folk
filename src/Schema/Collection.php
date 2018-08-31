<?php

namespace Folk\Schema;

use FormManager\Factory as f;

use FormManager\InputInterface;
use FormManager\Groups\Group;

class Collection implements ColumnInterface
{
    private $children = [];

    public function __construct($children = [])
    {
        foreach ($children as $name => $child) {
            $this->addChild($name, $child);
        }
    }

    public function __clone()
    {
        foreach ($this->children as $name => $child) {
            $this->children[$name] = clone $child;
        }
    }

    public function addChild($name, ColumnInterface $child)
    {
        $this->children[$name] = $child;

        return $this;
    }

    public function setValue($values): void
    {
        foreach ($this->children as $name => $child) {
            $child->setValue($values[$name] ?? null);
        }
    }

    public function getValue(): array
    {
        $values = [];

        foreach ($this->children as $name => $child) {
            $values[$name] = $child->getValue();
        }

        return $values;
    }

    public function renderHtml(): string
    {
        $html = [];

        foreach ($this->children as $child) {
            $html[] = "<li>{$child->renderHtml()}</li>";
        }

        $html = implode("\n", $html);

        return "<ul>{$html}</ul>";
    }

    public function createInput(): Group
    {
        $group = f::group();

        foreach ($this->children as $name => $child) {
            $group[$name] = $child->createInput();
        }

        return $group;
    }

    public function renderInput(InputInterface $group): string
    {
        $html = [];

        foreach ($this->children as $name => $child) {
            $input = $group[$name] = $child->createInput();
            $html[] = "<li>{$child->renderInput($input)}</li>";
        }

        $html = implode("\n", $html);

        return "<ul>{$html}</ul>";
    }
}