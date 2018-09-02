<?php

namespace Folk\Schema;

use FormManager\Inputs\Time as InputTime;

class Time extends Column
{
    public function createInput(): InputTime
    {
        return (new InputTime($this->title, $this->attributes))->setValue($this->value);
    }
}
