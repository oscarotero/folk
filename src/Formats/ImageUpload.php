<?php

namespace Folk\Formats;

class ImageUpload extends FileUpload implements FormatInterface
{
    public function __construct(FormatFactory $factory)
    {
        parent::__construct($factory);

        $this['loader']->accept('image/*');
        $this->data('module', 'format-uploadimage');
    }
}
