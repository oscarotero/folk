<?php

namespace Folk\Schema;

use FormManager\Factory as f;

class Value extends AbstractValue
{
    private $value;
    private $input;

    public function __construct($value = null)
    {
        $this->setValue($value);
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function buildForm()
    {
        return $this->input = f::text('');
    }

    public function renderHtml()
    {
        return "<strong>{$this->value}</strong>";
    }

    public function renderForm()
    {
        return "<div>{$this->input}</div>";
    }
}