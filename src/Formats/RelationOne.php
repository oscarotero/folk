<?php

namespace Folk\Formats;

use Folk\Entities\EntityInterface;
use Folk\SearchQuery;
use FormManager\Fields;

class RelationOne extends Fields\Select implements FormatInterface
{
    use Traits\HtmlValueTrait;
    use Traits\RenderTrait;

    public function __construct(FormatFactory $factory, EntityInterface $related, SearchQuery $search = null)
    {
        parent::__construct();

        $this->input[''] = '';

        foreach ($related->search($search ?: new SearchQuery()) as $id => $row) {
            $this->input[$id] = $related->getLabel($id, $row);
        }

        $this->set('list', false);
        $this->wrapper->class('format is-responsive');
        $this->data([
            'module' => 'format-select',
            'related' => $related->getName(),
        ]);
    }
}
