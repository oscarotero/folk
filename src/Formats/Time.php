<?php

namespace Folk\Formats;

use FormManager\Fields;

class Time extends Fields\Time implements FormatInterface
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
