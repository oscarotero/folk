<?php

namespace Folk\Formats;

use FormManager\Containers;
use FormManager\Builder;

class Loader extends Containers\Loader
{
    use Traits\CommonTrait;

    public $list = false;

    public function __construct(Builder $builder, array $children = null)
    {
        parent::__construct($children);

        $this->class('format is-loader');

        $this->set([
            'list' => false,
        ]);
    }

    public function label($html = null)
    {
        if ($html === null) {
            return $this['loader']->label->html();
        }

        $this['loader']->label($html);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function customRender($prepend = '', $append = '')
    {
        //Set class
        $class = $this->get('class');

        //Set module
        $this->data([
            'module' => $this->get('module'),
            'config' => $this->get('config') ? json_encode($this->get('config')) : null,
        ]);

        if ($this->error()) {
            $this->addClass('has-error');
        }

        return $this->toHtml($prepend, $append);
    }
}
