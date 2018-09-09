<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\DatetimeLocal as InputDate;

class Date extends Format
{
    protected function buildInput(): InputDate
    {
        return (new InputDate($this->title, $this->attributes))->setValue($this->value);
    }
}
