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
        $class = 'format '.$this->get('class');

        //Set module
        $module = $this->get('module') ? ' data-module="'.$this->get('module').'"' : '';

        //Set module configuration
        $config = $this->get('config') ? ' data-config="'.htmlspecialchars(json_encode($this->get('config')), ENT_QUOTES, 'UTF-8').'"' : '';

        if ($this->error()) {
            $class .= ' has-error';
        }

        return <<<EOT
<div class="{$class}"{$module}{$config}>
    {$prepend}
    {$this}
    {$append}
</div>
EOT;
    }
}
