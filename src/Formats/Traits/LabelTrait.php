<?php

namespace Folk\Formats\Traits;

use FormManager\Elements\Label;

trait LabelTrait
{
    protected $label;

    public function label($label = null)
    {
        if ($label === null) {
            return $this->label;
        }

        if (empty($this->label)) {
            $this->label = new Label();
        }

        $this->label->html($label);

        return $this;
    }
}
