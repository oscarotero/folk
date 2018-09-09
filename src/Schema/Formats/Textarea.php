<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Textarea as InputTextarea;
use FormManager\InputInterface;

class Textarea extends Format
{
    protected function buildInput(): InputTextarea
    {
        return (new InputTextarea($this->title, $this->attributes))->setValue($this->value);
    }

    public function renderInput(): string
    {
        return "<div class='editForm-input is-textarea'>{$this->input}</div>";
    }
}
