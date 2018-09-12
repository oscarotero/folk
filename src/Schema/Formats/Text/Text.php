<?php

namespace Folk\Schema\Formats\Text;

use FormManager\Inputs\Text as InputText;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Text extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputText
    {
        return (new InputText($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
