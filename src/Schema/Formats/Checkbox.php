<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Checkbox as InputCheckbox;
use FormManager\InputInterface;

class Checkbox extends Column
{
    protected function buildInput(): InputCheckbox
    {
        return (new InputCheckbox($this->title, $this->attributes))->setValue($this->value);
    }

    public function renderInput(InputInterface $input): string
    {
        return "<div class='editForm-input is-check'>{$input}</div>";
    }
}
