<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Display a empty form to create a new row
 */
class Blank extends Controller
{
    public function __invoke(ServerRequestInterface $request)
    {
        //JSON request
        if (self::isJSON($request)) {
            return self::notFoundResponse();
        }

        //HTML request
        $entityName = $request->getAttribute('entityName');

        if (!$this->app->hasEntity($entityName)) {
            return self::notFoundResponse();
        }

        return $this->app->get('templates')->render('pages/blank', compact('entityName'));
    }
}
