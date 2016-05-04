<?php

namespace Folk\Formats\Traits;

trait RenderTrait
{
    /**
     * {@inheritdoc}
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        if ($this->error()) {
            $this->wrapper->addClass('has-error');
        }

        return <<<EOT
{$this->label}

<div>
	{$this->errorLabel}
    {$prepend}
    {$this->input}
    {$append}
</div>
EOT;
    }
}
