<?php

namespace Folk\Schema;

use FormManager\Inputs\Range as InputRange;

class Range extends Column
{
    public function createInput(): InputRange
    {
        return (new InputRange($this->title, $this->attributes))->setValue($this->value);
    }
}
