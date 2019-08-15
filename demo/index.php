<?php

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Uri;
use Middlewares\Emitter;
use Middleland\Dispatcher;

include dirname(__DIR__).'/vendor/autoload.php';

//php -S localhost:8888 demo/index.php


$dispatcher = new Dispatcher([
    new Emitter(),

    function ($request) {
        $admin = new Demo\Admin(__DIR__, new Uri('http://localhost:8888'));
        return $admin->handle($request);
    }
]);

$dispatcher->dispatch(ServerRequestFactory::fromGlobals());
