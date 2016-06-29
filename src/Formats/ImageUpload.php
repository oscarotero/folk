<?php

namespace Folk\Formats;

use FormManager\Builder;

class ImageUpload extends FileUpload implements FormatInterface
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

        $this['loader']->accept('image/*');
        $this->data('module', 'format-uploadimage');
    }
}
