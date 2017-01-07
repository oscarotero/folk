<?php

namespace Folk\Formats;

use FormManager\Fields;

class Loader extends Fields\Loader implements FormatInterface
{
    use Traits\HtmlValueTrait;

    public $list = false;

    public function __construct(FormatFactory $factory, array $children = null)
    {
        parent::__construct($children);

        $this->class('format is-loader');
        $this->set('list', false);
    }

    public function label($html = null)
    {
        if ($html === null) {
            return $this['loader']->label->html();
        }

        $this['loader']->label($html);

        return $this;
    }
}
