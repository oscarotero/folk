<?php

namespace Folk\Formats;

use FormManager\Fields;

class File extends Fields\File implements FormatInterface
{
    use Traits\HtmlValueTrait;
    use Traits\RenderTrait;

    public function __construct()
    {
        parent::__construct();

        $this->set('list', false);
        $this->wrapper->class('format is-responsive is-large');
    }
}
