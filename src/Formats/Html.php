<?php

namespace Folk\Formats;

use FormManager\Builder;

class Html extends Textarea implements FormatInterface
{
    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

        $this->data('module', 'format-html');
    }

    /**
     * {@inheritdoc}
     */
    public function valToHtml()
    {
        $html = strip_tags(parent::valToHtml(), '<strong><em>');

        if (empty($html)) {
            return '';
        }

        if (strlen($html) > 200) {
            $html = substr($html, 0, 200).'...';
        }

        return "<p>{$html}</p>";
    }
}
