<?php

namespace Folk\Formats;

class Code extends Textarea implements FormatInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->set('list', false);
        $this->data('module', 'format-code');
    }
}
