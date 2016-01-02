<?php

namespace Folk\Formats;

use FormManager\Containers;
use FormManager\Builder;

class Group extends Containers\Group
{
    use Traits\ContainerTrait;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->set('list', false);
        $this->class('format is-responsive is-group is-large');
    }

    /**
     * {@inheritdoc}
     */
    protected function customRender($prepend = '', $append = '')
    {
        $html = $this->openHtml();

        if (isset($this->label)) {
            $html .= '<label>'.$this->label.'</label>';
        }

        $html .= '<div>';
        $html .= $prepend;
        $html .= $this->html();
        $html .= $append;
        $html .= '</div>';
        $html .= $this->closeHtml();

        return $html;
    }
}
