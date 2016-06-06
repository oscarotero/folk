<?php

namespace Folk\Formats;

use FormManager\Fields;

class Datetime extends Fields\Datetime implements FormatInterface
{
    use Traits\DatetimeValueTrait;
    use Traits\RenderTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set('list', true);
        $this->data('module', 'format-datetime');
        $this->wrapper->class('format is-responsive');
    }
}
