<?php

namespace Folk\Formats\Traits;

use Datetime;

trait DatetimeValueTrait
{
    /**
     * Returns the value as html.
     *
     * @return string
     */
    public function valToHtml()
    {
        $val = $this->val();

        if ($val) {
            return '<time datetime="'.((new Datetime($val))->format(DATE_ISO8601)).'">'.$val.'</time>';
        }

        return $this->val();
    }
}
