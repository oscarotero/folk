<?php

namespace Folk\Schema;

use FormManager\Inputs\Hidden as InputHidden;

class Hidden extends Column
{
    public function createInput(): InputHidden
    {
        return parent::buildInput('hidden');
    }
}