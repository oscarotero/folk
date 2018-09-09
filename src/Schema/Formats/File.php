<?php

namespace Folk\Schema\Formats;

use FormManager\Groups\Group;
use FormManager\Inputs\Hidden;
use FormManager\Inputs\File as InputFile;

class File extends Format
{
	public function setValue($value): void
    {
        $this->value = $value['value'] ?? $value['default'];
    }

    protected function buildInput(): Group
    {
    	return new Group([
    		'default' => new Hidden(is_string($this->value) ? $this->value : null),
    		'value' => new InputFile($this->title, $this->attributes),
    	]);
    }

    public function renderInput(): string
    {
        return "<div class='editForm-input is-standard'>{$this->input}</div>";
    }
}
