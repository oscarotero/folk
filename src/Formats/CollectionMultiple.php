<?php

namespace Folk\Formats;

use FormManager\Containers;
use FormManager\Fields;
use FormManager\Builder;

class CollectionMultiple extends Containers\CollectionMultiple
{
    use Traits\ContainerTrait;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', false);
        $this->class('format is-collection is-responsive is-large');
        $this->data('module', 'entity-collectionmultiple');
    }

    protected function customRender($prepend = '', $append = '')
    {
        $html = $this->openHtml();
        $html .= '<label>'.$this->label().'</label>';
        $html .= '<div>';

        $templates = $this->getTemplate();

        $options = array_combine(array_keys($templates), array_keys($templates));
        array_unshift($options, 'Add...');

        $addBtn = (new Fields\Select())
            ->options($options)
            ->class('format-child-add button button-normal')
            ->toHtml();

        $addBtn = '<div class="button-separator">'.$addBtn.'</div>';
        $toolbar = '<div class="button-toolbar"><button title="Move to up" type="button" class="button format-child-up">&#8593;</button><button title="Move to down" type="button" class="button format-child-down">&#8595;</button><button title="Remove" type="button" class="button format-child-remove">&#215;</button></div>';

        foreach ($templates as $type => $tmpl) {
            $html .= '<script type="js-template" data-type="'.$type.'">'.$tmpl->toHtml("{$addBtn} <strong class=\"format-child-label\">{$type}</strong> {$toolbar}").'</script>';
        }

        foreach ($this as $child) {
            $type = $child['type']->val();

            $html .= $child->toHtml("{$addBtn} <strong class=\"format-child-label\">{$type}</strong> {$toolbar}");
        }

        $html .= "<div>{$addBtn}</div>";
        $html .= '</div>';
        $html .= $this->closeHtml();

        return $html;
    }
}
