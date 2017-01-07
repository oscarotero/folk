<?php

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;
use Zend\Diactoros\Response\SapiStreamEmitter;

include dirname(__DIR__).'/vendor/autoload.php';

//php -S localhost:8888 demo/index.php
$app = new Demo\Admin(new Uri('http://localhost:8888'));

$response = $app(ServerRequestFactory::fromGlobals());

(new SapiStreamEmitter())->emit($response);
