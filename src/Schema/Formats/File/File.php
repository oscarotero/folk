<?php

namespace Folk\Schema\Formats\File;

use FormManager\Groups\Group;
use FormManager\Inputs\Hidden;
use FormManager\Inputs\File as InputFile;
use Folk\Schema\Formats\Format;
use Folk\Schema\Traits\RenderTrait;

class File extends Format
{
    use RenderTrait;
    
	public function setValue(string $name, array $values): void
    {
        $this->value = $values[$name]['value'] ?? $values[$name]['default'];
    }

    protected function buildInput(): Group
    {
    	return new Group([
    		'default' => new Hidden(is_string($this->value) ? $this->value : null),
    		'value' => new InputFile($this->title, $this->attributes),
    	]);
    }

    public function render(string $template): string
    {
        return $this->renderFile(__DIR__, $template);
    }
}
