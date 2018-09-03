<?php

namespace Folk\Schema\Formats;

use FormManager\Factory as f;
use FormManager\InputInterface;
use Folk\Schema\ColumnInterface;

abstract class Column implements ColumnInterface
{
    protected $value;
    protected $title;
    protected $attributes;

    public function __construct(string $title, iterable $attributes = [])
    {
        $this->title = $title;
        $this->attributes = $attributes;
    }

    public function getTitle(): string
    {
        return $this->title;
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

    public function isValid(): bool
    {
        return $this->createInput()->isValid();
    }

    public function createInput(): InputInterface
    {
        return $this->buildInput();
    }

    abstract protected function buildInput();

    public function renderInput(InputInterface $input): string
    {
        return "<div class='editForm-input is-standard'>{$input}</div>";
    }
}
