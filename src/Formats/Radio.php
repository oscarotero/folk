<?php

namespace Folk\Formats;

use FormManager\Fields;

class Radio extends Fields\Radio
{
    use Traits\FieldTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-boolean',
        ]);
    }
}
