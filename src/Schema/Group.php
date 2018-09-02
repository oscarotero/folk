<?php

namespace Folk\Schema;

use FormManager\InputInterface;
use FormManager\Groups\Group as InputGroup;

class Group implements ColumnInterface
{
    private $title;
    private $children = [];

    public function __construct(string $title, $children = [])
    {
        $this->title = $title;

        foreach ($children as $name => $child) {
            $this->addChild($name, $child);
        }
    }

    public function getTitle(): string
    {
        return $this->title;
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

    public function isValid(): bool
    {
        foreach ($this->children as $child) {
            if (!$child->isValid()) {
                return false;
            }
        }

        return true;
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

    public function createInput(): InputInterface
    {
        $group = new InputGroup();

        foreach ($this->children as $name => $child) {
            $group[$name] = $child->createInput();
        }

        return $group;
    }

    public function renderInput(InputInterface $group): string
    {
        $html = ["<legend>{$this->getTitle()}</legend>"];

        foreach ($this->children as $name => $child) {
            $input = $group[$name] = $child->createInput();
            $html[] = "<li>{$child->renderInput($input)}</li>";
        }

        $html = implode("\n", $html);

        return "<fieldset>{$html}</fieldset>";
    }
}
