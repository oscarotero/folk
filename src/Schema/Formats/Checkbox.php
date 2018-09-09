<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Checkbox as InputCheckbox;
use FormManager\InputInterface;

class Checkbox extends Format
{
    protected function buildInput(): InputCheckbox
    {
        return (new InputCheckbox($this->title, $this->attributes))->setValue($this->value);
    }

    public function renderInput(): string
    {
        return "<div class='editForm-input is-check'>{$this->input}</div>";
    }
}
