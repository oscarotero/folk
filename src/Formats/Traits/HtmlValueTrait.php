<?php

namespace Folk\Formats\Traits;

trait HtmlValueTrait
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
}
