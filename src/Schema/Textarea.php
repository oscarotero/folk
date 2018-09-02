<?php

namespace Folk\Schema;

use FormManager\Inputs\Textarea as InputTextarea;

class Textarea extends Column
{
    protected function buildInput(): InputTextarea
    {
        return (new InputTextarea($this->title, $this->attributes))->setValue($this->value);
    }
}
