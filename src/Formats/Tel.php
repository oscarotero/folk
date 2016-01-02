<?php

namespace Folk\Formats;

use FormManager\Fields;

class Tel extends Fields\Tel
{
    use Traits\FieldTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-responsive',
        ]);
    }
}
