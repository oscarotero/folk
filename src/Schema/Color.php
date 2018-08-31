<?php

namespace Folk\Schema;

use FormManager\Inputs\Color as InputColor;

class Color extends Column
{
    public function createInput(): InputColor
    {
        return parent::buildInput('color');
    }
}