<?php

namespace Folk\Formats\Traits;

trait ContainerTrait
{
    use CommonTrait;

    protected $label;

    public function label($label = null)
    {
        if ($label === null) {
            return $this->label;
        }

        $this->label = $label;

        return $this;
    }
}
