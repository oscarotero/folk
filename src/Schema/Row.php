<?php

namespace Folk\Schema;

use IteratorAggregate;
use ArrayIterator;
use FormManager\Factory as f;

class Row implements RowInterface, IteratorAggregate
{
    private $columns = [];
    private $form;
    private $id;

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

    public function addColumn($name, ColumnInterface $column)
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

    public function renderHtml(): string
    {
        $html = [];

        foreach ($this->columns as $column) {
            $html[] = "<li>{$column->renderHtml()}</li>";
        }

        $html = implode("\n", $html);

        return "<ul>{$html}</ul>";
    }

    public function renderForm(string $entityName, $id = null): string
    {
        $form = f::form(
            [
                'id' => f::hidden($id),
                'entity' => f::hidden($entityName),
            ],[
                'method' => 'post',
                'enctype' =>'multipart/form-data'
            ]
        );

        $group = $form['data'] = f::group();

        $html = [];
        $html[] = $form->getOpeningTag();

        foreach ($this->columns as $name => $column) {
            $html[] = $column->renderInput($group[$name] = $column->createInput());
        }

        $html[] = f::submit('Save');
        $html[] = f::submit('Duplicate', ['name' => 'method-override', 'value' => 'put']);
        $html[] = f::submit('Delete', ['name' => 'method-override', 'value' => 'delete']);
        $html[] = $form->getClosingTag();

        $html = implode("\n", $html);

        return (string) $html;
    }
}