<?php

namespace Folk\Schema;

use FormManager\Inputs\Textarea as InputTextarea;

class Textarea extends Column
{
    public function createInput(): InputTextarea
    {
        return (new InputTextarea($this->title, $this->attributes))->setValue($this->value);
    }
}
