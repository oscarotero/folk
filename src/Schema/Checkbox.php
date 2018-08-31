<?php

namespace Folk\Schema;

use FormManager\Inputs\Checkbox as InputCheckbox;

class Checkbox extends Column
{
    public function createInput(): InputCheckbox
    {
        return parent::buildInput('checkbox');
    }
}