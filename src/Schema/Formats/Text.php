<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Text as InputText;

class Text extends Column
{
    protected function buildInput(): InputText
    {
        return (new InputText($this->title, $this->attributes))->setValue($this->value);
    }
}
