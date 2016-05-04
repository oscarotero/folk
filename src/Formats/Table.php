<?php

namespace Folk\Formats;

use FormManager\Builder;

class Table extends Textarea implements FormatInterface
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

        $this->set('list', false);
        $this->data('module', 'format-table');
    }

    public function val($value = null)
    {
        if (is_array($value)) {
            $value = json_encode($value);
        }

        return parent::val($value);
    }
}
