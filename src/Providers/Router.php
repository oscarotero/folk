<?php

namespace Folk\Providers;

use Fol;
use Fol\ServiceProviderInterface;
use Aura\Router\RouterContainer;

class Router implements ServiceProviderInterface
{
    public function register(Fol $app)
    {
        $app['router'] = function ($app) {
            $router = new RouterContainer();

            $map = $router->getMap();
            $ns = 'Folk\\Controllers';

            $map->get('index', '/', "{$ns}\\Index");
            $map->get('search', '/{entity}', "{$ns}\\SearchEntity");
            $map->get('insert', '/{entity}/new', "{$ns}\\InsertEntity");
            $map->put('create', '/{entity}', "{$ns}\\CreateEntity");
            $map->get('read', '/{entity}/{id}', "{$ns}\\ReadEntity");
            $map->post('update', '/{entity}/{id}', "{$ns}\\UpdateEntity");
            $map->delete('delete', '/{entity}/{id}', "{$ns}\\DeleteEntity");

            return $router;
        };
    }
}
