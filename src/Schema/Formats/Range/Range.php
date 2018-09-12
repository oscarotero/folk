<?php

namespace Folk\Schema\Formats\Range;

use FormManager\Inputs\Range as InputRange;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Range extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputRange
    {
        return (new InputRange($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
