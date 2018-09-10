<?php

namespace Folk\Schema\Formats;

use ArrayAccess;
use Folk\Schema\FormatInterface;

abstract class Format implements FormatInterface
{
    protected $value;
    protected $title;
    protected $attributes;
    protected $input;

    public function __construct(string $title, iterable $attributes = [])
    {
        $this->title = $title;
        $this->attributes = $attributes;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setValue(string $name, array $values): void
    {
        $this->value = $values[$name];
    }

    public function getValue(string $name, array &$values): void
    {
        $values[$name] = $this->value;
    }

    public function renderHtml(): string
    {
        return (string) $this->value;
    }

    public function isValid(): bool
    {
        return $this->initInput()->isValid();
    }

    public function initInput(string $name, ArrayAccess $parent)
    {
        $this->input = $this->buildInput();
        $parent[$name] = $this->input;
    }

    abstract protected function buildInput();

    public function renderInput(): string
    {
        return "<div class='editForm-input is-standard'>{$this->input}</div>{$this->input->getError()}";
    }
}
