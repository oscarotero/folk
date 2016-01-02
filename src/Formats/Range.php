<?php

namespace Folk\Formats;

use FormManager\Fields;

class Range extends Fields\Range
{
    use Traits\FieldTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-responsive is-range is-number',
        ]);
    }
}
