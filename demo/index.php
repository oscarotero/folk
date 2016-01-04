<?php

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

include dirname(__DIR__).'/vendor/autoload.php';

$app = new Demo\Admin('http://localhost/folk/demo');

$response = $app(ServerRequestFactory::fromGlobals());

(new SapiEmitter())->emit($response);
