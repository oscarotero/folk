<?php

namespace Folk\Formats;

use FormManager\Builder;

class FileUpload extends Loader implements FormatInterface
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder, [
            'loader' => $builder->file(),
            'field' => $builder->hidden(),
        ]);

        $this->data('module', 'format-upload');
    }
}
