<?php

namespace Folk\Schema;

use FormManager\Inputs\Email as InputEmail;

class Email extends Column
{
    public function createInput(): InputEmail
    {
        return (new InputEmail($this->title, $this->attributes))->setValue($this->value);
    }
}
