<?php

namespace Folk\Formats;

use FormManager\Fields;

class Password extends Fields\Password
{
    use Traits\FieldTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => false,
            'class' => 'is-responsive',
        ]);
    }
}
