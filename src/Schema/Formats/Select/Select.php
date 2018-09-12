<?php

namespace Folk\Schema\Formats\Select;

use FormManager\Inputs\Select as InputSelect;
use FormManager\InputInterface;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class Select extends Format
{
    use RenderTrait;
    
	private $options;

	public function __construct(string $title, iterable $options = [], iterable $attributes = [])
    {
        $this->options = $options;
        parent::__construct($title, $attributes);
    }

    protected function buildInput(): InputSelect
    {
        return (new InputSelect($this->title, $this->options, $this->attributes))->setValue($this->value);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
