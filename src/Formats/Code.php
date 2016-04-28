<?php

namespace Folk\Formats;

class Code extends Textarea
{
    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => false,
            'module' => 'format-code',
        ]);
    }
}
