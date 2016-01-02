<?php

namespace Folk\Formats;

use FormManager\Fields;

class Url extends Fields\Url
{
    use Traits\FieldTrait;

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

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-responsive',
        ]);
    }
}
