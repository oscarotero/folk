<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Folk\Schema\Schema;

/**
 * Display a form to edit a row
 */
class Read extends Controller
{
    public function __invoke(ServerRequestInterface $request)
    {
        $entityName = $request->getAttribute('entityName');

        if (!$this->app->hasEntity($entityName)) {
            return self::notFoundResponse();
        }

        $entity = $this->app->getEntity($entityName);
        $id = $request->getAttribute('id');
        $data = $entity->read($id);

        //JSON request
        if (self::isJSON($request)) {
            return json_encode($data);
        }

        //HTML request
        $row = new Schema($entity->getScheme());
        $row->setValue($data);

        return $this->app->get('templates')->render('pages/read', compact('entityName', 'id', 'row'));
    }
}
