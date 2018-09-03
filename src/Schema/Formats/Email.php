<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Email as InputEmail;

class Email extends Column
{
    protected function buildInput(): InputEmail
    {
        return (new InputEmail($this->title, $this->attributes))->setValue($this->value);
    }
}
