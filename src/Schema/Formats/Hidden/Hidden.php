<?php

namespace Folk\Schema\Formats\Hidden;

use FormManager\InputInterface;
use FormManager\Inputs\Hidden as InputHidden;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Hidden extends Format
{
    use RenderTrait;
    
    protected function buildInput(): InputHidden
    {
        return (new InputHidden($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
