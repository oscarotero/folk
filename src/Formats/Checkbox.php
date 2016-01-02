<?php

namespace Folk\Formats;

use FormManager\Fields;

class Checkbox extends Fields\Checkbox
{
    use Traits\FieldTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set([
            'list' => true,
            'class' => 'is-boolean',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function valToHtml()
    {
        return $this->val() ? '&#9679;' : '&#9675;';
    }
}
