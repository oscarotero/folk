<?php

namespace Folk\Schema\Formats\Datetime;

use FormManager\Inputs\DatetimeLocal as InputDatetimeLocal;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Datetime extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputDatetimeLocal
    {
        return (new InputDatetimeLocal($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
