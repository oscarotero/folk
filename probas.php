<?php

include 'vendor/autoload.php';

use Folk\Schema\Value;
use Folk\Schema\Collection;
use FormManager\Form;

$value = new Collection([
    'valor1' => new Value(),
    'valor2' => new Value(),
    'valor3' => new Collection([
        'valor3-1' => new Value(),
        'valor3-2' => new Value(),
        'valor3-3' => new Value(),
    ]),
]);

echo $value->renderHtml();

$value->buildForm()->setValue([
    'valor1' => 'Ola',
    'valor2' => 'Ola 2',
    'valor3' => [
        'valor3-1' => 'Subvalor 1',
        'valor3-2' => 'Subvalor 2',
    ],
]);

echo '<form>';
echo $value->renderForm();
echo '</form>';