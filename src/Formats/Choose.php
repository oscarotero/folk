<?php

namespace Folk\Formats;

use FormManager\Fields;

class Choose extends Fields\Choose implements FormatInterface
{
    use Traits\LabelTrait;
    use Traits\HtmlValueTrait;

    public function __construct(FormatFactory $factory, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', true);
        $this->class('format is-choose');
    }
}
