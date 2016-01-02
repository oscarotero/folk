<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Elements;
use FormManager\Builder;
use Folk\Entities\EntitiesInterface;

class Relation extends Fields\Field
{
    use Traits\FieldTrait;

    public $list = false;

    protected $module = 'entity-relation';
    protected $related;

    public function __construct(Builder $builder, EntitiesInterface $related)
    {
        $this->datalistAllowed = false;

        $this->input = new Elements\Select();
        $this->input->allowNewValues();

        parent::__construct();

        $this->data([
            'source' => "/{$related->name}/list",
            'relate' => $related->name,
        ]);

        $this->set([
            'list' => false,
            'module' => 'entity-relation',
            'class' => 'is-responsive',
        ]);
    }
}
