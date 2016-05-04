<?php

namespace Folk\Formats;

use FormManager\Fields;

class Checkbox extends Fields\Checkbox implements FormatInterface
{
    public function __construct()
    {
        parent::__construct();

        $this->set('list', true);
        $this->wrapper->class('format is-boolean');
    }

    /**
     * {@inheritdoc}
     */
    public function valToHtml()
    {
        return $this->val() ? '&#9679;' : '&#9675;';
    }
}
