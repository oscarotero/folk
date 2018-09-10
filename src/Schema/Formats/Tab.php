<?php

namespace Folk\Schema\Formats;

use Folk\Schema\FormatInterface;
use ArrayAccess;
use FormManager\Groups\Group as InputGroup;

class Tab implements FormatInterface
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

    public function addChild($name, FormatInterface $child)
    {
        $this->children[$name] = $child;

        return $this;
    }

    public function setValue(string $name, array $values): void
    {
        foreach ($this->children as $key => $child) {
            $child->setValue($key, $values);
        }
    }

    public function getValue(string $name, array &$values): void
    {
        foreach ($this->children as $name => $child) {
            $child->getValue($name, $values);
        }
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
        foreach ($this->children as $name => $child) {
            $child->initInput($name, $parent);
        }
    }

    public function renderInput(): string
    {
        $html = [];

        foreach ($this->children as $name => $child) {
            $html[] = $child->renderInput();
        }

        $html = implode("\n", $html);

        return <<<HTM
        <h3 class="editForm-subhead">{$this->getTitle()}</h3>
        <div class="editForm-container">
            {$html}
        </div>
HTM;
    }
}
