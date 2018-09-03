<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Month as InputMonth;

class Month extends Column
{
    protected function buildInput(): InputMonth
    {
        return (new InputMonth($this->title, $this->attributes))->setValue($this->value);
    }
}
