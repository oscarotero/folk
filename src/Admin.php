<?php

namespace Folk;

use Fol\{App, NotFoundException};
use Folk\Entities\EntityInterface;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface, UriInterface};
use Zend\Diactoros\Response;
use Relay\RelayBuilder;

/**
 * Main manager.
 */
class Admin extends App
{
    private $entities = [];

    public $title = 'Folk';
    public $description = 'Universal CMS';

    public function __construct(UriInterface $uri)
    {
        parent::__construct(__DIR__, $uri);

        $this->register(new Providers\Formats());
        $this->register(new Providers\Middleware());
        $this->register(new Providers\Router());
        $this->register(new Providers\Templates());
    }

    /**
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $dispatcher = $this->get('middleware');

        return $dispatcher->dispatch($request);
    }

    public function getRoute(string $name, array $data = [], array $query = null): string
    {
        return $this->getUri($this['router']->getGenerator()->generate($name, $data)).($query ? '?'.http_build_query($query) : '');
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
                $name = substr(strrchr($entity, '\\'), 1);
            }

            $this->addEntity(new $entity(strtolower($name), $this));
        }
    }

    /**
     * Add a new entity.
     *
     * @param EntityInterface $entity
     */
    public function addEntity(EntityInterface $entity)
    {
        $name = $entity->getName();

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
    public function hasEntity(string $name): bool
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
    public function getEntity(string $name): EntityInterface
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
    public function getAllEntities(): array
    {
        return $this->entities;
    }
}
