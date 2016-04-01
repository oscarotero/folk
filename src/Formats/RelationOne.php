<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Elements;
use FormManager\Builder;
use Folk\Entities\EntityInterface;
use Folk\SearchQuery;

class RelationOne extends Fields\Field
{
    use Traits\FieldTrait;

    public function __construct(Builder $builder, EntityInterface $related, SearchQuery $search = null)
    {
        $this->datalistAllowed = false;

        $this->input = new Elements\Select();

        $this->input[''] = '';

        if ($search === null) {
            $search = new SearchQuery();
        }

        foreach ($related->search($search) as $id => $row) {
            $this->input[$id] = $related->getLabel($id, $row);
        }

        parent::__construct();

        $this->set([
            'list' => false,
            'class' => 'is-responsive',
            'module' => 'entity-select',
        ]);
    }
}
