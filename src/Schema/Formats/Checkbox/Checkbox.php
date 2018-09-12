<?php

namespace Folk\Schema\Formats\Checkbox;

use FormManager\Inputs\Checkbox as InputCheckbox;
use FormManager\InputInterface;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Checkbox extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputCheckbox
    {
        return (new InputCheckbox($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
