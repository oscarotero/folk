<?php

namespace Folk\Schema\Formats;

use FormManager\InputInterface;
use FormManager\Inputs\Range as InputRange;

class Range extends Column
{
    protected function buildInput(): InputRange
    {
        return (new InputRange($this->title, $this->attributes))->setValue($this->value);
    }

    public function renderInput(InputInterface $input): string
    {
        return "<div class='editForm-input is-standard module-input-range'>{$input}<output></output></div>";
    }
}
