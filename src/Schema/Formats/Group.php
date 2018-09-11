<?php

namespace Folk\Schema\Formats;

use Folk\Schema\FormatInterface;
use ArrayAccess;
use FormManager\Groups\Group as InputGroup;

class Group implements FormatInterface
{
    const IS_BLOCK = true;

    private $title;
    private $children = [];
    private $group;

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

    public function addChild($name, FormatInterface $child)
    {
        $this->children[$name] = $child;

        return $this;
    }

    public function setValue(string $name, array $values): void
    {
        $val = $values[$name] ?? [];

        foreach ($this->children as $key => $child) {
            $child->setValue($key, $val);
        }
    }

    public function getValue(string $name, array &$values): void
    {
        $childValues = [];

        foreach ($this->children as $key => $child) {
            $child->getValue($key, $childValues);
        }

        $values[$name] = $childValues;
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

    public function isBlock(): bool
    {
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

    public function initInput(string $name, ArrayAccess $parent)
    {
        $this->group = new InputGroup();

        foreach ($this->children as $name => $child) {
            $child->initInput($name, $this->group);
        }

        $parent[$name] = $this->group;
    }

    public function renderInput(): string
    {
        $html = [];

        foreach ($this->children as $name => $child) {
            $html[] = $child->renderInput();
        }

        $html = implode("\n", $html);

        return <<<HTM
        <h3 class="editForm-head">{$this->getTitle()}</h3>
        <div class="editForm">
            {$html}
        </div>
HTM;
    }
}
