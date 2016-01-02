<?php

namespace Folk\Formats;

use FormManager\Fields;
use FormManager\Elements;

class Info extends Fields\Field
{
    use Traits\CommonTrait;

    public function __construct()
    {
        $this->labelPosition = static::LABEL_BEFORE;
        $this->datalistAllowed = false;

        $this->input = (new Elements\Input())->type('hidden');

        parent::__construct();

        $this->set('list', true);
    }

    /**
     * {@inheritdoc}
     */
    protected function customRender($prepend = '', $append = '')
    {
        $class = 'format is-responsive';

        if ($this->error()) {
            $class .= ' has-error';
        }

        return <<<EOT
<div class="{$class}">
	{$this->label}

	<div>
		{$this->errorLabel}
        <p>{$this->val()}</p>
        {$this->input}
	</div>
</div>
EOT;
    }
}
