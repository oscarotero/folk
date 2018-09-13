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

    public function setValue(iterable $values): void
    {
        foreach ($this->columns as $name => $column) {
            $column->setValue($name, $values);
        }
    }

    public function getValue(): array
    {
        $values = [];

        foreach ($this->columns as $name => $column) {
            $column->getValue($name, $values);
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
        $autoBlock = false;
        $html = [];

        foreach ($this->columns as $name => $column) {
            if (!$column->isBlock()) {
                if (!$autoBlock) {
                    $html[] = '<div class="editForm-container is-raised">';
                    $autoBlock = true;
                }
            } elseif ($autoBlock) {
                $html[] = '</div>';
                $autoBlock = false;
            }

            $html[] = $column->render('form');
        }

        if ($autoBlock) {
            $html[] = '</div>';
        }

        return implode("\n", $html);
    }
}
