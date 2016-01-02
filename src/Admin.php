<?php

namespace Folk;

use Fol;
use Folk\Entities\EntitiesInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Relay\RelayBuilder;

/**
 * Main manager.
 */
class Admin extends Fol
{
    private $entities = [];

    public $title = 'Folk';
    public $description = 'Universal CMS';

    public function __construct()
    {
        $this->register(new Providers\Builder());
        $this->register(new Providers\Middlewares());
        $this->register(new Providers\Router());
        $this->register(new Providers\Templates());
    }

    /**
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $dispatcher = (new RelayBuilder())->newInstance($this['middlewares']);

        return $dispatcher($request, new Response());
    }

    /**
     * Add a new entity.
     *
     * @param EntitiesInterface $entity
     */
    protected function addEntity(EntitiesInterface $entity)
    {
        $name = strtolower(substr(strrchr(get_class($entity), '\\'), 1));
        $entity->setAdmin($name, $this);

        $this->entities[$name] = $entity;
    }

    /**
     * Return an entity.
     *
     * @param string $name
     *
     * @return EntitiesInterface|null
     */
    public function getEntity($name)
    {
        return isset($this->entities[$name]) ? $this->entities[$name] : null;
    }

    /**
     * Return all entities.
     *
     * @return array
     */
    public function getAllEntities()
    {
        return $this->entities;
    }
}
