<?php

namespace Folk\Formats;

use FormManager\Fields;

class Color extends Fields\Color implements FormatInterface
{
    use Traits\RenderTrait;
    use Traits\HtmlValueTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set('list', true);
        $this->wrapper->class('format is-responsive');
    }
}
