<?php

namespace Folk\Schema;

use FormManager\Inputs\Month as InputMonth;

class Month extends Column
{
    public function createInput(): InputMonth
    {
        return parent::buildInput('month');
    }
}