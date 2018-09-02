<?php

namespace Folk\Schema;

use FormManager\Inputs\Range as InputRange;

class Range extends Column
{
    protected function buildInput(): InputRange
    {
        return (new InputRange($this->title, $this->attributes))->setValue($this->value);
    }
}
