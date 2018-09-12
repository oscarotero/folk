<?php

namespace Folk\Schema\Formats\Number;

use FormManager\Inputs\Number as InputNumber;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Number extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputNumber
    {
        return (new InputNumber($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
