<?php

namespace Folk\Schema;

use FormManager\Inputs\DatetimeLocal as InputDate;

class Date extends Column
{
    public function createInput(): InputDate
    {
        return (new InputDate($this->title, $this->attributes))->setValue($this->value);
    }
}
