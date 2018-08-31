<?php

namespace Folk\Schema;

use FormManager\Inputs\DatetimeLocal as InputDatetimeLocal;

class Datetime extends Column
{
    public function createInput(): InputDatetimeLocal
    {
        return parent::buildInput('datetimeLocal');
    }
}