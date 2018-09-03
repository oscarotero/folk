<?php

namespace Folk\Schema\Formats;

use FormManager\InputInterface;
use FormManager\Inputs\Hidden as InputHidden;

class Hidden extends Column
{
    protected function buildInput(): InputHidden
    {
        return (new InputHidden($this->title, $this->attributes))->setValue($this->value);
    }

    public function renderInput(InputInterface $input): string
    {
        return (string) $input;
    }
}
