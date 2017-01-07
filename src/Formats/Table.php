<?php

namespace Folk\Formats;

class Table extends Textarea implements FormatInterface
{
    public function __construct(FormatFactory $factory)
    {
        parent::__construct($factory);

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
