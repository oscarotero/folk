<?php

namespace Folk\Formats;

use FormManager\Containers;
use FormManager\Builder;

class Collection extends Containers\Collection
{
    use Traits\ContainerTrait;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', false);
        $this->class('format is-collection is-responsive is-large');
        $this->data('module', 'entity-collection');
    }

    protected function customRender($prepend = '', $append = '')
    {
        $html = $this->openHtml();
        $html .= '<label>'.$this->label().'</label>';
        $html .= '<div>';

        $addBtn = '<div class="button-separator"><button type="button" class="format-child-add button button-normal">Add</button></div>';
        $toolbar = '<div class="button-toolbar"><button title="Move to up" type="button" class="button format-child-up">&#8593;</button><button title="Move to down" type="button" class="button format-child-down">&#8595;</button><button title="Remove" type="button" class="button format-child-remove">&#215;</button></div>';

        $html .= '<script type="js-template">'.$this->getTemplate()->toHtml($addBtn.'<strong class="format-child-label"></strong>'.$toolbar).'</script>';

        foreach ($this as $child) {
            $html .= $child->toHtml($addBtn.'<strong class="format-child-label"></strong>'.$toolbar);
        }

        $html .= "<div>{$addBtn}</div>";
        $html .= '</div>';
        $html .= $this->closeHtml();

        return $html;
    }
}
