<?php

namespace Folk\Schema;

use IteratorAggregate;
use ArrayIterator;
use ArrayAccess;
use FormManager\Factory as f;
use Folk\Schema\FormatInterface;

class Schema implements IteratorAggregate
{
    private $columns = [];
    private $group;

    public function __construct($columns = [])
    {
        foreach ($columns as $name => $column) {
            $this->addColumn($name, $column);
        }
    }

    public function __clone()
    {
        foreach ($this->columns as $name => $column) {
            $this->columns[$name] = clone $column;
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->columns);
    }

    public function addColumn($name, FormatInterface $column)
    {
        $this->columns[$name] = $column;

        return $this;
    }

    public function setValue(iterable $value): void
    {
        foreach ($this->columns as $name => $column) {
            $column->setValue($value[$name] ?? null);
        }
    }

    public function getValue(): array
    {
        $values = [];

        foreach ($this->columns as $name => $column) {
            $values[$name] = $column->getValue();
        }

        return $values;
    }

    public function isValid(): bool
    {
        foreach ($this->columns as $name => $column) {
            if (!$column->isValid()) {
                return false;
            }
        }

        return true;
    }

    public function renderHtml(): string
    {
        $html = [];

        foreach ($this->columns as $column) {
            $html[] = "<li>{$column->renderHtml()}</li>";
        }

        $html = implode("\n", $html);

        return "<ul>{$html}</ul>";
    }

    public function initInput(string $name, ArrayAccess $parent)
    {
        $this->group = f::group();

        foreach ($this->columns as $columnName => $column) {
            $column->initInput($columnName, $this->group);
        }

        $parent[$name] = $this->group;
    }

    public function renderInput(): string
    {
        $html = [];

        foreach ($this->columns as $name => $column) {
            $html[] = $column->renderInput();
        }

        return implode("\n", $html);
    }
}
