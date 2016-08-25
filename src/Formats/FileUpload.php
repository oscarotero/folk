<?php

namespace Folk\Formats;

use FormManager\Builder;
use SplFileInfo;

class FileUpload extends Loader implements FormatInterface
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder, [
            'loader' => $builder->file(),
            'field' => $builder->hidden(),
        ]);

        $this->data([
            'module' => 'format-upload',
            'max-size' => self::getMaxSize(),
        ]);
    }

    private static function getMaxSize() {
        $size = ini_get('upload_max_filesize');

        switch (strtoupper(substr($size, -1))) {
            case 'M':
                return intval($size) * 1000000;

            default:
                return intval($size);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function val($value = null)
    {
        if ($value instanceof SplFileInfo) {
            $value = $value->getFileName();
        }

        return parent::val($value);
    }
}
