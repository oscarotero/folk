<?php

namespace Folk\Schema;

use FormManager\Inputs\Time as InputTime;

class Time extends Column
{
    public function createInput(): InputTime
    {
        return parent::buildInput('time');
    }
}