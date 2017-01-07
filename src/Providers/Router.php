<?php

namespace Folk\Providers;

use Fol\{App, ServiceProviderInterface};
use Aura\Router\RouterContainer;

class Router implements ServiceProviderInterface
{
    public function register(App $app)
    {
        $app['router'] = function (App $app): RouterContainer {
            $router = new RouterContainer();

            $map = $router->getMap();
            $ns = 'Folk\\Controllers';

            $map->get('index', '/', "{$ns}\\Index");
            $map->get('search', '/{entity}', "{$ns}\\SearchEntity");
            $map->get('insert', '/{entity}/new', "{$ns}\\InsertEntity");
            $map->put('create', '/{entity}', "{$ns}\\CreateEntity");
            $map->put('createField', '/{entity}/{field}', "{$ns}\\CreateEntityField");
            $map->get('read', '/{entity}/{id}', "{$ns}\\ReadEntity");
            $map->post('update', '/{entity}/{id}', "{$ns}\\UpdateEntity");
            $map->post('updateField', '/{entity}/{id}/{field}', "{$ns}\\UpdateEntityField");
            $map->delete('delete', '/{entity}/{id}', "{$ns}\\DeleteEntity");

            return $router;
        };
    }
}
