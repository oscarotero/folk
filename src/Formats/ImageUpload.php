<?php

namespace Folk\Formats;

use FormManager\Builder;

class ImageUpload extends FileUpload
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

        $this['loader']->accept('image/*');

        $this->set('module', 'entity-image');
    }
}
