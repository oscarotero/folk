<?php

namespace Folk\Formats;

use FormManager\Fields;

class Week extends Fields\Week
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
