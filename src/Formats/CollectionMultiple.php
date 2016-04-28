<?php

namespace Folk\Formats;

use FormManager\Containers;
use FormManager\Fields;
use FormManager\Builder;

class CollectionMultiple extends Containers\CollectionMultiple
{
    use Traits\ContainerTrait;
    use Traits\CollectionTrait;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', false);
        $this->class('format is-collection is-responsive is-large');
        $this->data('module', 'format-collectionmultiple');
    }

    protected function customRender($prepend = '', $append = '')
    {
        $html = $this->openHtml();
        $html .= $this->label() ? '<label>'.$this->label().'</label>' : '';
        $html .= '<div>';

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
        $html .= '</div>';
        $html .= $this->closeHtml();

        return $html;
    }
}
