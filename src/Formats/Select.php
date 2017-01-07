<?php

namespace Folk\Formats;

use FormManager\Fields;

class Select extends Fields\Select implements FormatInterface
{
    use Traits\HtmlValueTrait;
    use Traits\RenderTrait;

    public function __construct(FormatFactory $factory, array $options = null)
    {
        parent::__construct($options);

        $this->set('list', true);
        $this->input->class('button');
        $this->wrapper->class('format is-responsive');
    }
}
