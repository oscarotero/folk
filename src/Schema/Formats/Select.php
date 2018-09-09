<?php

namespace Folk\Schema\Formats;

use FormManager\Inputs\Select as InputSelect;
use FormManager\InputInterface;

class Select extends Format
{
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
}
