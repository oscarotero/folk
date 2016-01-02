<?php

namespace Folk\Formats;

use FormManager\Containers;
use FormManager\Builder;

class Choose extends Containers\Choose
{
    use Traits\ContainerTrait;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->set([
            'list' => true,
            'class' => 'is-responsive',
        ]);
    }
}
