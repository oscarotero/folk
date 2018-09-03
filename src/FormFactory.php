<?php

namespace Folk;

use FormManager\Factory as f;
use FormManager\Form;
use Folk\Schema\RowInterface;

abstract class FormFactory
{
    public static function insert(RowInterface $row, string $entityName = null): Form
    {
        return f::form([
            'entityName' => f::hidden($entityName),
            'method-override' => f::hidden('put'),
            'data' => $row->createInput(),
            '' => f::submit('Create')
        ], [
            'method' => 'post',
            'enctype' =>'multipart/form-data'
        ]);
    }

    public static function update(RowInterface $row, string $entityName = null, $id = null): Form
    {
        return f::form([
            'id' => f::hidden($id),
            'entityName' => f::hidden($entityName),
            'data' => $row->createInput(),
            'method-override' => f::submitGroup([
                'post' => f::submit('Save'),
                'put' => f::submit('Duplicate', ['class' => 'is-secondary']),
                'delete' => f::submit('Delete', ['class' => 'is-danger']),
            ])
        ], [
            'method' => 'post',
            'enctype' =>'multipart/form-data'
        ]);
    }
}
