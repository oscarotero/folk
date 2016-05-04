<?php

namespace Folk\Formats;

use FormManager\Builder;

class Html extends Textarea implements FormatInterface
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

        $this->data('module', 'format-html');
    }
}
