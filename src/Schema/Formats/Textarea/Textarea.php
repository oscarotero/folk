<?php

namespace Folk\Schema\Formats\Textarea;

use FormManager\Inputs\Textarea as InputTextarea;
use FormManager\InputInterface;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Textarea extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputTextarea
    {
        return (new InputTextarea($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
