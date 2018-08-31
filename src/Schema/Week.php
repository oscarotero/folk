<?php

namespace Folk\Schema;

use FormManager\Inputs\Week as InputWeek;

class Week extends Column
{
    public function createInput(): InputWeek
    {
        return parent::buildInput('week');
    }
}