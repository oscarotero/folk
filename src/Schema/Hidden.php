<?php

namespace Folk\Schema;

use FormManager\Inputs\Hidden as InputHidden;

class Hidden extends Column
{
    protected function buildInput(): InputHidden
    {
        return (new InputHidden($this->title, $this->attributes))->setValue($this->value);
    }
}
