<?php

namespace Folk\Schema;

use FormManager\Factory as f;

class Collection extends AbstractValue
{
    private $name;
    private $children = [];

    public function __construct($children = [])
    {
        foreach ($children as $key => $child) {
            $this->addChild($key, $child);
        }
    }

    public function addChild($name, $child)
    {
        if ($name === null) {
            $this->children[] = $child->setParent($this);
        } else {
            $this->children[$name] = $child->setParent($this);
        }

        return $this;
    }

    public function setValue(?array $values): self
    {
        foreach ($this->children as $name => $child) {
            $child->setValue($values[$name] ?? null);
        }

        return $this;
    }

    public function getValue(): array
    {
        $values = [];

        foreach ($this->children as $name => $child) {
            $values[$name] = $child->getValue();
        }

        return $values;
    }

    public function buildForm()
    {
        $children = [];

        foreach ($this->children as $name => $child) {
            $children[$name] = $child->buildForm();
        }

        return f::group($children);
    }

    public function renderHtml()
    {
        $html = [];

        foreach ($this->children as $child) {
            $html[] = "<li>{$child->renderHtml()}</li>";
        }

        $html = implode("\n", $html);

        return "<ul>{$html}</ul>";
    }

    public function renderForm()
    {
        $html = [];

        foreach ($this->children as $child) {
            $html[] = "<li>{$child->renderForm()}</li>";
        }

        $html = implode("\n", $html);

        return "<ul>{$html}</ul>";
    }
}