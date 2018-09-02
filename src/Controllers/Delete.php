<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Middlewares\Utils\Factory;

/**
 * Delete a row
 */
class Delete extends Controller
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

        $id = $request->getAttribute('id');

        $this->app->getEntity($entityName)->delete($id);

        return Factory::createResponse(302)
                ->withHeader('location', $this->app->getRoute('search', compact('entityName')));
    }
}
