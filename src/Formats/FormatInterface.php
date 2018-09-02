<?php

namespace Folk\Formats;

use FormManager\FieldInterface;

interface FormatInterface extends FieldInterface
{
    /**
     * Set the format label.
     *
     * @param string|null $label
     *
     * @return mixed
     */
    public function label($label = null);

    /**
     * Returns the value as html.
     *
     * @return string
     */
    public function valToHtml();
}
