<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Textarea as InputTextarea;
use FormManager\InputInterface;

class Textarea extends Column
{
    protected function buildInput(): InputTextarea
    {
        return (new InputTextarea($this->title, $this->attributes))->setValue($this->value);
    }

    public function renderInput(InputInterface $input): string
    {
        return "<div class='editForm-input is-textarea'>{$input}</div>";
    }
}
