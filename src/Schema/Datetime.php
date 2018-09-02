<?php

namespace Folk\Schema;

use FormManager\Inputs\DatetimeLocal as InputDatetimeLocal;

class Datetime extends Column
{
    public function createInput(): InputDatetimeLocal
    {
        return (new InputDatetimeLocal($this->title, $this->attributes))->setValue($this->value);
    }
}
