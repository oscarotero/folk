<?php

namespace Folk\Schema;

use FormManager\Inputs\Text as InputText;

class Text extends Column
{
    public function createInput(): InputText
    {
        return parent::buildInput('text');
    }
}