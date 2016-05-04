<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Builder;

class CollectionMultiple extends Fields\CollectionMultiple implements FormatInterface
{
    use Traits\LabelTrait;
    use Traits\ToolbarTrait;
    use Traits\CollectionValueTrait;
    use Traits\RenderContainerTrait;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', false);
        $this->class('format is-collection is-responsive is-large');
        $this->data('module', 'format-collectionmultiple');
    }

    public function html($html = null)
    {
        if ($html !== null) {
            return parent::html($html);
        }

        $templates = $this->getTemplate();

        $options = array_combine(array_keys($templates), array_keys($templates));
        array_unshift($options, 'Add...');

        $addBtn = (new Fields\Select())
            ->options($options)
            ->class('format-child-add button')
            ->toHtml();

        $addBtn = '<div class="button-separator">'.$addBtn.'</div>';
        $toolbar = $this->getToolbarButtons();

        foreach ($templates as $type => $tmpl) {
            $html .= '<script type="js-template" data-type="'.$type.'">'.$tmpl->toHtml("{$addBtn} <div class=\"button-toolbar\"><strong class=\"button-toolbar-label\">{$type}</strong> {$toolbar}</div>").'</script>';
        }

        foreach ($this as $child) {
            $type = $child['type']->val();

            $html .= $child->toHtml("{$addBtn} <div class=\"button-toolbar\"><strong class=\"button-toolbar-label\">{$type}</strong> {$toolbar}</div>");
        }

        $html .= "<div>{$addBtn}</div>";

        return $html;
    }
}
