<?php

include dirname(__DIR__).'/vendor/autoload.php';

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;
use Zend\Diactoros\Response\SapiStreamEmitter;

$app = new Demo\Admin(dirname(__DIR__), new Uri('http://localhost:8888'));

$response = $app->handle(ServerRequestFactory::fromGlobals());

(new SapiStreamEmitter())->emit($response);
