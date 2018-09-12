<?php

namespace Folk\Schema\Formats\Url;

use FormManager\Inputs\Url as InputUrl;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Url extends Format
{
    use RenderTrait;

    protected function buildInput(): InputUrl
    {
        return (new InputUrl($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
