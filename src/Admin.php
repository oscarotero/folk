<?php

namespace Folk;

use Fol;
use Folk\Entities\EntitiesInterface;
use Aura\Router\RouterContainer;
use Psr7Middlewares\Middleware as M;

/**
 * Main manager
 */
class Admin extends Fol
{
    protected $entities = [];

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
