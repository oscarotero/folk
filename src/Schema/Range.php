<?php

namespace Folk\Schema;

use FormManager\Inputs\Range as InputRange;

class Range extends Column
{
    public function createInput(): InputRange
    {
        return parent::buildInput('range');
    }
}