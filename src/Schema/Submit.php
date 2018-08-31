<?php

namespace Folk\Schema;

use FormManager\Inputs\Submit as InputSubmit;

class Submit extends Column
{
    public function createInput(): InputSubmit
    {
        return parent::buildInput('submit');
    }
}