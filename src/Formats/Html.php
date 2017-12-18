<?php

namespace Folk\Formats;

class Html extends Textarea implements FormatInterface
{
    public function __construct(FormatFactory $factory)
    {
        parent::__construct($factory);

        $this->data('module', 'format-html');
    }

    /**
     * {@inheritdoc}
     */
    public function valToHtml(): string
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
