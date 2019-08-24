<?php

namespace Folk\Controllers;

use Middlewares\Utils\Factory;
use Psr\Http\Message\ServerRequestInterface as Request;

class DeleteEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $this->app->getEntity($entityName)->delete($request->getAttribute('id'));

        return Factory::createResponse(302)
                ->withHeader('Location', $this->app->getRoute('search', [
                    'entity' => $entityName,
                ]));
    }
}
