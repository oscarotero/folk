<?php

namespace Folk\Schema;

use FormManager\Inputs\Url as InputUrl;

class Url extends Column
{
    protected function buildInput(): InputUrl
    {
        return (new InputUrl($this->title, $this->attributes))->setValue($this->value);
    }
}
