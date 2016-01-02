<?php

namespace Folk\Formats;

use FormManager\Fields;

class Textarea extends Fields\Textarea
{
    use Traits\FieldTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-responsive is-large',
        ]);
    }
}
