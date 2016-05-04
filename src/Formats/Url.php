<?php

namespace Folk\Formats;

use FormManager\Fields;

class Url extends Fields\Url implements FormatInterface
{
    use Traits\RenderTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set('list', true);
        $this->wrapper->class('format is-responsive');
    }

    /**
     * {@inheritdoc}
     */
    public function valToHtml()
    {
        $val = $this->val();

        if ($val) {
            return '<a href="'.$val.'" target="_blank">'.$val.'</a>';
        }
    }
}
