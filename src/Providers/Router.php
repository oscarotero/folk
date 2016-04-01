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

            $map->get('index', '/', "{$ns}\\Index::index");
            $map->get('list', '/{entity}/list', "{$ns}\\Entity::listItems");
            $map->get('create', '/{entity}/new', "{$ns}\\Entity::createItem")->allows(['POST']);
            $map->get('edit', '/{entity}/{id}/edit', "{$ns}\\Entity::editItem")->allows('POST');
            $map->post('delete', '/{entity}/{id}/delete', "{$ns}\\Entity::deleteItem");
            $map->get('entity', '/{entity}', "{$ns}\\Index::entity");

            return $router;
        };
    }
}
