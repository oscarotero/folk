<?php

namespace Folk\Schema;

use FormManager\Factory as f;
use FormManager\InputInterface;

abstract class Column implements ColumnInterface
{
    protected $value;
    protected $label;
    protected $attributes;

    public function __construct(string $label, iterable $attributes = [])
    {
        $this->label = $label;
        $this->attributes = $attributes;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function renderHtml(): string
    {
        return (string) $this->value;
    }

    protected function buildInput(string $type): InputInterface
    {
        return f::$type()
            ->setLabel($this->label)
            ->setAttributes($this->attributes)
            ->setValue($this->value);
    }

    public function renderInput(InputInterface $input): string
    {
        return "<div>{$input}</div>";
    }
}