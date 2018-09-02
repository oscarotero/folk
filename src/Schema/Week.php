<?php

namespace Folk\Schema;

use FormManager\Inputs\Week as InputWeek;

class Week extends Column
{
    public function createInput(): InputWeek
    {
        return (new InputWeek($this->title, $this->attributes))->setValue($this->value);
    }
}
