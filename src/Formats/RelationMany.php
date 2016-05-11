<?php

namespace Folk\Formats;

use FormManager\Builder;
use Folk\Entities\EntityInterface;
use Folk\SearchQuery;

class RelationMany extends RelationOne implements FormatInterface
{
    public function __construct(Builder $builder, EntityInterface $related, SearchQuery $search = null)
    {
        parent::__construct($builder, $related, $search);

        $this->input->multiple();
    }
}
