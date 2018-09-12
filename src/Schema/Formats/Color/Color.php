<?php

namespace Folk\Schema\Formats\Color;

use FormManager\Inputs\Color as InputColor;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Color extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputColor
    {
        return (new InputColor($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
