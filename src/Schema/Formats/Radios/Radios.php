<?php

namespace Folk\Schema\Formats\Radios;

use FormManager\Groups\RadioGroup;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Radios extends Format
{
    use RenderTrait;
    
	private $options;

	public function __construct(string $title, iterable $options = [])
    {
        $this->title = $title;
        $this->options = $options;
    }

    protected function buildInput(): RadioGroup
    {
        return (new RadioGroup($this->options))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
