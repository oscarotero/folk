<?php

namespace Folk\Schema\Formats\Date;

use FormManager\Inputs\DatetimeLocal as InputDate;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Date extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputDate
    {
        return (new InputDate($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
