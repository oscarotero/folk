<?php

namespace Folk\Formats;

use FormManager\Fields;

class Hidden extends Fields\Hidden
{
    use Traits\CommonTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => false,
        ]);
    }
}
