<?php

namespace Folk\Formats\Traits;

trait FieldTrait
{
    use CommonTrait;

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

        if (strpos($this->get('class'), 'is-responsive') === false) {
            return <<<EOT
<div class="{$class}"{$module}{$config}>
    {$this}
</div>
EOT;
        }

        return <<<EOT
<div class="{$class}"{$module}{$config}>
	{$this->label}

	<div>
		{$this->errorLabel}
        {$prepend}
        {$this->input}
        {$append}
	</div>
</div>
EOT;
    }
}
