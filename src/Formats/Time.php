<?php

namespace Folk\Formats;

use FormManager\Fields;

class Time extends Fields\Time
{
    use Traits\DatetimeTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-responsive',
        ]);
    }
}
