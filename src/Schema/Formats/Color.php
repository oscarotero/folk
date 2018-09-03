<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Color as InputColor;

class Color extends Column
{
    protected function buildInput(): InputColor
    {
        return (new InputColor($this->title, $this->attributes))->setValue($this->value);
    }
}
