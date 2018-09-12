<?php

namespace Folk\Schema\Formats\Email;

use FormManager\Inputs\Email as InputEmail;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Email extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputEmail
    {
        return (new InputEmail($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
