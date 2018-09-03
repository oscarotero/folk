<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Tel as InputTel;

class Tel extends Column
{
    protected function buildInput(): InputTel
    {
        return (new InputTel($this->title, $this->attributes))->setValue($this->value);
    }
}