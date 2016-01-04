<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Elements;
use FormManager\Builder;
use Folk\Entities\EntityInterface;

class RelationOne extends Fields\Field
{
    use Traits\FieldTrait;

    public function __construct(Builder $builder, EntityInterface $related)
    {
        $this->datalistAllowed = false;

        $this->input = new Elements\Select();

        $this->input[''] = '';

        foreach ($related->search() as $id => $row) {
            $this->input[$id] = $related->getLabel($id, $row);
        }

        parent::__construct();

        $this->set([
            'list' => false,
            'class' => 'is-responsive',
        ]);
    }
}
