<?php

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;
use Zend\Diactoros\Response\SapiStreamEmitter;

include dirname(__DIR__).'/vendor/autoload.php';

//php -S localhost:8888 demo/index.php
$app = new Demo\Admin(__DIR__, new Uri('http://localhost:8888'));

$response = $app->handle(ServerRequestFactory::fromGlobals());

(new SapiStreamEmitter())->emit($response);
