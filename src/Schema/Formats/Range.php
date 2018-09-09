<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Range as InputRange;

class Range extends Format
{
    protected function buildInput(): InputRange
    {
        return (new InputRange($this->title, $this->attributes))->setValue($this->value);
    }

    public function renderInput(): string
    {
        return "<div class='editForm-input is-standard module-input-range'>{$this->input}<output></output></div>";
    }
}
