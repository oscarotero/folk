<?php

namespace Folk\Formats;

use FormManager\Builder;

class FileUpload extends Loader
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder, [
            'loader' => $builder->file()->set('class', 'is-responsive is-large'),
            'field' => $builder->hidden(),
        ]);

        $this->set('module', 'format-upload');
    }
}
