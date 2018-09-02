<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Folk\Entities\EntityInterface;
use Folk\SearchQuery;

/**
 * Display table to search rows
 */
class Search extends Controller
{
    public function __invoke(ServerRequestInterface $request)
    {
        $entityName = $request->getAttribute('entityName');

        if (!$this->app->hasEntity($entityName)) {
            return self::notFoundResponse();
        }

        $entity = $this->app->getEntity($entityName);
        $search = new SearchQuery($request->getQueryParams());
        $data = $entity->search($search);

        //JSON request
        if (self::isJSON($request)) {
            foreach ($data as $id => &$item) {
                $item = $entity->getLabel($id, $item);
            }

            return json_encode($data);
        }

        //HTML request
        $row = $entity->getScheme();
        $rows = [];

        foreach ($data as $id => $value) {
            $rows[$id] = clone $row;
            $rows[$id]->setValue($value);
        }

        return $this->app->get('templates')
            ->render('pages/search', compact('rows', 'entityName', 'search'));
    }
}
