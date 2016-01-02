<?php

namespace Folk\Formats\Traits;

trait CommonTrait
{
    /**
     * Returns the value as html.
     *
     * @return string
     */
    public function valToHtml()
    {
        return $this->val();
    }

    /**
     * Returns the value as plain text.
     *
     * @return string
     */
    public function valToText()
    {
        return strip_tags($this->val());
    }
}
