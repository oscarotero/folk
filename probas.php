<?php

include 'vendor/autoload.php';

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;
use Zend\Diactoros\Response\SapiStreamEmitter;

//php -S localhost:8888 demo/index.php
$app = new Demo\Admin(__DIR__, new Uri('http://localhost:8888'));

$response = $app->handle(ServerRequestFactory::fromGlobals());

(new SapiStreamEmitter())->emit($response);



// use Folk\SchemaFactory as f;

// $row = f::row([
//     'valor1' => f::text('Valor 1'),
//     'valor2' => f::text('Valor 2'),
//     'valor3' => f::collection([
//         'valor3-1' => f::textarea('Valor 3'),
//         'valor3-2' => f::textarea('Valor 4'),
//         'valor3-3' => f::textarea('Valor 5'),
//     ]),
// ]);

// $row->setValue([
//     'valor1' => 'Ola',
//     'valor2' => 'Ola 2',
//     'valor3' => [
//         'valor3-1' => 'Subvalor 1',
//         'valor3-2' => 'Subvalor 2',
//     ],
// ]);

// echo $row->renderHtml();
// echo $row->renderForm();
