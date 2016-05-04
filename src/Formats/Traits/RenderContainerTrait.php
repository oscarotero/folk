<?php

namespace Folk\Formats\Traits;

trait RenderContainerTrait
{
    /**
     * {@inheritdoc}
     */
    protected function defaultRender($prepend = '', $append = '')
    {
        if ($this->error()) {
            $this->addClass('has-error');
        }

        return <<<EOT
{$this->openHtml()}
    {$this->label}

    <div>
        {$prepend}
        {$this->html()}
        {$append}
    </div>
{$this->closeHtml()}
EOT;
    }
}
