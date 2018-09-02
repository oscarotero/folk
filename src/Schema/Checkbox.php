<?php

namespace Folk\Schema;

use FormManager\Inputs\Checkbox as InputCheckbox;

class Checkbox extends Column
{
    public function buildInput(): InputCheckbox
    {
        return (new InputCheckbox($this->title, $this->attributes))->setValue($this->value);
    }
}
