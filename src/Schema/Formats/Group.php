<?php

namespace Folk\Schema\Formats;

use Folk\Schema\FormatInterface;
use ArrayAccess;
use FormManager\Groups\Group as InputGroup;

class Group implements FormatInterface
{
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
        <details class="editForm-input is-group">
            <summary class="editForm-subhead">{$this->getTitle()}</summary>
            <div>
                {$html}
            </div>
        </details>
HTM;
    }
}
