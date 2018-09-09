<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\DatetimeLocal as InputDatetimeLocal;

class Datetime extends Format
{
    protected function buildInput(): InputDatetimeLocal
    {
        return (new InputDatetimeLocal($this->title, $this->attributes))->setValue($this->value);
    }
}
