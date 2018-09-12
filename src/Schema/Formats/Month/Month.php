<?php

namespace Folk\Schema\Formats\Month;

use FormManager\Inputs\Month as InputMonth;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Month extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputMonth
    {
        return (new InputMonth($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
