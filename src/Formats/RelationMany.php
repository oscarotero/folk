<?php

namespace Folk\Formats;

use Folk\Entities\EntityInterface;
use Folk\SearchQuery;

class RelationMany extends RelationOne implements FormatInterface
{
    public function __construct(FormatFactory $factory, EntityInterface $related, SearchQuery $search = null)
    {
        parent::__construct($factory, $related, $search);

        $this->input->multiple();
    }
}
