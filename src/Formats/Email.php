<?php

namespace Folk\Formats;

use FormManager\Fields;

class Email extends Fields\Email implements FormatInterface
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
