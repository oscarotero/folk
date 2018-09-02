<?php

namespace Folk\Formats;

use SplFileInfo;

class FileUpload extends Loader implements FormatInterface
{
    public function __construct(FormatFactory $factory)
    {
        parent::__construct($factory, [
            'loader' => $factory->file(),
            'field' => $factory->hidden(),
        ]);

        $this->data([
            'module' => 'format-upload',
            'max-size' => self::getMaxSize(),
        ]);
    }

    private static function getMaxSize()
    {
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
