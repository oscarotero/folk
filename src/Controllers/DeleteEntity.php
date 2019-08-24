<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;

class DeleteEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $this->app->getEntity($entityName)->delete($request->getAttribute('id'));

        return new RedirectResponse($this->app->getRoute('search', [
            'entity' => $entityName,
        ]));
    }
}
