<?php

namespace Folk\Formats\Traits;

trait CollectionValueTrait
{
    /**
     * Returns the value as html.
     *
     * @return string
     */
    public function valToHtml(): string
    {
        $html = '<ul>';

        foreach ($this as $field) {
            $html .= '<li>'.$field->valToHtml().'</li>';
        }

        $html .= '</ul>';

        return $html;
    }
}
