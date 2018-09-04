<?php

namespace Folk\Schema\Formats;

use FormManager\Groups\Group;
use FormManager\Inputs\Hidden;
use FormManager\Inputs\File as InputFile;

class File extends Column
{
	public function setValue($value): void
    {
        $this->value = $value['value'] ?? $value['default'];
    }

    protected function buildInput(): Group
    {
    	return new Group([
    		'default' => new Hidden($this->value),
    		'value' => new InputFile($this->title, $this->attributes),
    	]);
    }
}
