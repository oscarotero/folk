<?php

namespace Folk\Formats;

use FormManager\Fields;

class Number extends Fields\Number implements FormatInterface
{
    use Traits\HtmlValueTrait;
    use Traits\RenderTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set('list', true);
        $this->wrapper->class('format is-responsive');
    }
}
