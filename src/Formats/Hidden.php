<?php

namespace Folk\Formats;

use FormManager\Fields;

class Hidden extends Fields\Hidden implements FormatInterface
{
    use Traits\HtmlValueTrait;
    
    public function __construct()
    {
        parent::__construct();

        $this->set('list', false);
    }
}
