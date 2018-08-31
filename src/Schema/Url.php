<?php

namespace Folk\Schema;

use FormManager\Inputs\Url as InputUrl;

class Url extends Column
{
    public function createInput(): InputUrl
    {
        return parent::buildInput('url');
    }
}