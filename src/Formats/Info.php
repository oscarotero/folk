<?php

namespace Folk\Formats;

use FormManager\{Fields, Elements};

class Info extends Fields\Field implements FormatInterface
{
    use Traits\HtmlValueTrait;

    public function __construct()
    {
        parent::__construct((new Elements\Input())->type('hidden'));

        $this->set('list', true);
        $this->wrapper->class('format is-responsive');
    }

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
    <p>{$this->input->val()}</p>
    {$this->input}
    {$append}
</div>
EOT;
    }
}
