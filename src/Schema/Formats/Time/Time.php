<?php

namespace Folk\Schema\Formats\Time;

use FormManager\Inputs\Time as InputTime;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Time extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputTime
    {
        return (new InputTime($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
