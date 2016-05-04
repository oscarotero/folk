<?php

namespace Folk\Formats;

use FormManager\Builder;
use Folk\Entities\EntityInterface;

class RelationMany extends RelationOne implements FormatInterface
{
    public function __construct(Builder $builder, EntityInterface $related)
    {
        parent::__construct($builder, $related);

        $this->input->multiple();
    }
}
