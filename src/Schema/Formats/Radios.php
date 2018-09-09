<?php

namespace Folk\Schema\Formats;

use FormManager\Groups\RadioGroup;

class Radios extends Format
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

    public function renderInput(): string
    {
        return "<div class='editForm-input is-check'>{$this->input}</div>";
    }
}
