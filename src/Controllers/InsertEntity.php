<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;

class InsertEntity extends Entity
{
    public function html(Request $request, string $entityName)
    {
        return $this->app->get('templates')->render('pages/insert', [
            'entityName' => $entityName,
            'form' => $this->createForm($entityName),
        ]);
    }
}
