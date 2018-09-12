<?php

namespace Folk\Schema\Formats\Tel;

use FormManager\Inputs\Tel as InputTel;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Tel extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputTel
    {
        return (new InputTel($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
