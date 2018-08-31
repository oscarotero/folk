<?php

namespace Folk\Schema;

abstract class AbstractValue
{
    protected $parent;

    public function setParent(AbstractValue $parent)
    {
        $this->parent = $parent;

        return $this;
    }
}