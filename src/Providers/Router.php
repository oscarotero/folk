<?php

namespace Folk\Providers;

use Fol\App;
use Interop\Container\ServiceProviderInterface;
use Aura\Router\RouterContainer;
use Folk\Controllers\Index;
use Folk\Controllers\Search;
use Folk\Controllers\Insert;
use Folk\Controllers\Create;
use Folk\Controllers\Read;
use Folk\Controllers\Update;
use Folk\Controllers\Delete;

class Router implements ServiceProviderInterface
{
    public function getFactories()
    {
        return [
            'router' => function (App $app): RouterContainer {
                $router = new RouterContainer();
                $map = $router->getMap();

                $map->get('index', '/', Index::class);
                $map->get('search', '/{entityName}', Search::class);
                $map->get('read', '/{entityName}/{id}', Read::class);
                // $map->get('insert', '/{entity}/new', Insert::class);
                // $map->put('create', '/{entity}', Create::class);
                // $map->post('update', '/{entity}/{id}', Update::class);
                // $map->delete('delete', '/{entity}/{id}', Delete::class);

                return $router;
            }
        ];
    }

    public function getExtensions() {
        return [];
    }
}
