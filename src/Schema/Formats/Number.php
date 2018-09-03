<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Number as InputNumber;

class Number extends Column
{
    protected function buildInput(): InputNumber
    {
        return (new InputNumber($this->title, $this->attributes))->setValue($this->value);
    }
}
