<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Elements;
use FormManager\Builder;
use Folk\Entities\EntityInterface;

class Relation extends Fields\Field implements FormatInterface
{
    use Traits\HtmlValueTrait;
    use Traits\RenderTrait;

    protected $related;

    public function __construct(Builder $builder, EntityInterface $related)
    {
        $this->datalistAllowed = false;

        $this->input = new Elements\Select();
        $this->input->allowNewValues();

        parent::__construct();

        $name = $related->getName();

        $this->data([
            'source' => "/{$name}/list",
            'relate' => $name,
        ]);

        $this->set([
            'list' => false,
            'module' => 'format-relation',
            'class' => 'is-responsive',
        ]);
    }
}
