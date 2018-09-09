<?php

namespace Folk;

use FormManager\Factory as f;
use FormManager\Form;
use Folk\Schema\Schema;

abstract class FormFactory
{
    public static function insert(Schema $row, string $entityName = null): Form
    {
        $form = f::form([
            'entityName' => f::hidden($entityName),
            'method-override' => f::hidden('put'),
            '' => f::submit('Create')
        ], [
            'method' => 'post',
            'enctype' =>'multipart/form-data'
        ]);

        $row->initInput('data', $form);

        return $form;
    }

    public static function update(Schema $row, string $entityName = null, $id = null): Form
    {
        $form = f::form([
            'id' => f::hidden($id),
            'entityName' => f::hidden($entityName),
            'method-override' => f::submitGroup([
                'post' => f::submit('Save'),
                'put' => f::submit('Duplicate', ['class' => 'is-secondary']),
                'delete' => f::submit('Delete', ['class' => 'is-danger']),
            ])
        ], [
            'method' => 'post',
            'enctype' =>'multipart/form-data'
        ]);

        $row->initInput('data', $form);

        return $form;
    }
}
