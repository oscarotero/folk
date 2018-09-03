<?php

namespace Folk\Schema\Formats;

use FormManager\Groups\RadioGroup;
use FormManager\InputInterface;

class Radios extends Column
{
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

    public function renderInput(InputInterface $input): string
    {
        return "<div class='editForm-input is-check'>{$input}</div>";
    }
}
