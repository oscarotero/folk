<?php

namespace Folk\Formats;

use FormManager\Fields;

class DatetimeLocal extends Fields\DatetimeLocal implements FormatInterface
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
