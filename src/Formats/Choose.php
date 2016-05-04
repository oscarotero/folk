<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Builder;

class Choose extends Fields\Choose implements FormatInterface
{
    use Traits\LabelTrait;
    use Traits\HtmlValueTrait;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', true);
        $this->class('format is-choose');
    }
}
