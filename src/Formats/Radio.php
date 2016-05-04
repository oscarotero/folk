<?php

namespace Folk\Formats;

use FormManager\Fields;

class Radio extends Fields\Radio implements FormatInterface
{
    use Traits\HtmlValueTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set('list', true);
        $this->wrapper->class('format is-boolean');
    }
}
