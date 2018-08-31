<?php

namespace Folk\Schema;

use FormManager\Inputs\Tel as InputTel;

class Tel extends Column
{
    public function createInput(): InputTel
    {
    	return parent::buildInput('tel');
    }
}