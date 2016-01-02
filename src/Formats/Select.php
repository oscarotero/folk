<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Builder;

class Select extends Fields\Select
{
    use Traits\FieldTrait;

    public function __construct(Builder $builder, array $options = null)
    {
        parent::__construct($options);

        $this->class('button');

        $this->set([
            'list' => true,
            'class' => 'is-responsive',
        ]);
    }
}
