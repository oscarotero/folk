<?php

namespace Folk\Formats;

use FormManager\Fields;

class Date extends Fields\Date implements FormatInterface
{
    use Traits\DatetimeValueTrait;
    use Traits\RenderTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set('list', true);
        $this->wrapper->class('format is-responsive');
    }
}
