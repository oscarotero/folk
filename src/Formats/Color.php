<?php

namespace Folk\Formats;

use FormManager\Fields;

class Color extends Fields\Color
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
