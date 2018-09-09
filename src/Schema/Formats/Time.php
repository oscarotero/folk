<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Time as InputTime;

class Time extends Format
{
    protected function buildInput(): InputTime
    {
        return (new InputTime($this->title, $this->attributes))->setValue($this->value);
    }
}
