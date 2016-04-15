<?php

namespace Folk;

use InlineSvg\Sources\FileSystem;

class MaterialDesignIcons extends FileSystem
{
    /**
     * {@inheritdoc}
     */
    protected function getPath($name)
    {
        if (strpos($name, '/') === false) {
            return;
        }

        list($category, $name) = explode('/', $name, 2);

        $name = "{$category}/svg/production/ic_{$name}_24px";

        return parent::getPath($name);
    }
}
