<?php

namespace Folk\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Folk\Admin;
use Folk\Entities\EntityInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Folk\SearchQuery;

class Search extends Entity
{
    public function html(Request $request, string $entityName)
    {
        $entity = $this->app->getEntity($entityName);
        $search = new SearchQuery($request->getQueryParams());
        $data = $this->search($entity, $search);

        $row = $entity->getRow();
        $rows = [];

        foreach ($data as $id => $value) {
            $rows[$id] = clone $row;
            $rows[$id]->setValue($value);
        }

        return $this->app->get('templates')
            ->render('pages/search', compact('rows', 'entityName', 'search'));
    }

    public function json(Request $request, string $entityName)
    {
        $entity = $this->app->getEntity($entityName);

        $search = new SearchQuery($request->getQueryParams());

        $json = [];

        foreach ($this->search($entity, $search) as $id => $item) {
            $json[$id] = $entity->getLabel($id, $item);
        }

        return json_encode($json);
    }

    private function search(EntityInterface $entity, SearchQuery $search): array
    {
        if ($search->getPage() === null) {
            $search->setPage(1);
        }

        return $entity->search($search);
    }
}
