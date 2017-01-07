<?php

namespace Folk\Formats;

use FormManager\Fields;

class Collection extends Fields\Collection implements FormatInterface
{
    use Traits\LabelTrait;
    use Traits\ToolbarTrait;
    use Traits\CollectionValueTrait;
    use Traits\RenderContainerTrait;

    public function __construct(FormatFactory $factory, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', false);
        $this->class('format is-collection is-responsive is-large');
        $this->data('module', 'format-collection');
    }

    public function html($html = null)
    {
        if ($html !== null) {
            return parent::html($html);
        }

        $addBtn = '<div class="button-separator"><button type="button" class="format-child-add button">Add</button></div>';
        $toolbar = sprintf('<div class="button-toolbar"><div>%s</div></div>', $this->getToolbarButtons());
        $html = '<script type="js-template">'.$this->getTemplate()->toHtml("{$addBtn} {$toolbar}").'</script>';

        foreach ($this as $child) {
            $html .= $child->toHtml("{$addBtn} {$toolbar}");
        }

        $html .= "<div>{$addBtn}</div>";

        return $html;
    }
}
