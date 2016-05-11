<?php

namespace Folk;

use Fol;
use Fol\NotFoundException;
use Folk\Entities\EntityInterface;
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

    public function __construct($url)
    {
        $this->setUrl($url);

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

    public function getRoute($name, array $data = array(), array $query = null)
    {
        return $this->getUrl($this['router']->getGenerator()->generate($name, $data)).($query ? '?'.http_build_query($query) : '');
    }

    /**
     * Set the admin entities.
     *
     * @param array $entities
     */
    public function setEntities(array $entities)
    {
        foreach ($entities as $name => $entity) {
            if (is_int($name)) {
                $name = strtolower(substr(strrchr($entity, '\\'), 1));
            }

            $this->addEntity($name, new $entity($this));
        }
    }

    /**
     * Add a new entity.
     *
     * @param string          $name
     * @param EntityInterface $entity
     */
    public function addEntity($name, EntityInterface $entity)
    {
        if (empty($entity->title)) {
            $entity->title = ucfirst($name);
        }

        $this->entities[$name] = $entity;
    }

    /**
     * Return whether an entity exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasEntity($name)
    {
        return isset($this->entities[$name]);
    }

    /**
     * Return an entity.
     *
     * @param string $name
     *
     * @throw NotFoundException
     * 
     * @return EntityInterface
     */
    public function getEntity($name)
    {
        if ($this->hasEntity($name)) {
            return $this->entities[$name];
        }

        throw new NotFoundException(sprintf('Entity %s not found', $name));
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
