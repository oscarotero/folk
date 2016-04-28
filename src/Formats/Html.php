<?php

namespace Folk\Formats;

use FormManager\Builder;

class Html extends Textarea
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

        $this->set('module', 'format-html');
    }
}
