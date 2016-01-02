<?php

namespace Folk\Formats;

use FormManager\Fields;

class Number extends Fields\Number
{
    use Traits\FieldTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-responsive is-number',
        ]);
    }
}
