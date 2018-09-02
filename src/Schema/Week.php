<?php

namespace Folk\Schema;

use FormManager\Inputs\Week as InputWeek;

class Week extends Column
{
    protected function buildInput(): InputWeek
    {
        return (new InputWeek($this->title, $this->attributes))->setValue($this->value);
    }
}
