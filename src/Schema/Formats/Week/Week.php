<?php

namespace Folk\Schema\Formats\Week;

use FormManager\Inputs\Week as InputWeek;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Week extends Format
{
    use RenderTrait;

    protected function buildInput(): InputWeek
    {
        return (new InputWeek($this->title, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
