<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Psr7Middlewares\Middleware;

class Error
{
    public function __invoke(Request $request, Response $response, Admin $app)
    {
        $format = Middleware\FormatNegotiator::getFormat($request);
        $exception = Middleware\ErrorHandler::getException($request);

        if (!$exception) {
            return $response;
        }

        if ($format === 'json') {
            return json_encode([
                'error' => $exception->getMessage()
            ]);
        }

        return $exception->getMessage();
    }
}
