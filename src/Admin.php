<?php

namespace Folk;

use Fol\App;
use Fol\NotFoundException;
use Folk\Entities\EntityInterface;
use Folk\Entities\SingleEntityInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response;
use Relay\RelayBuilder;

/**
 * Main manager.
 */
class Admin extends App implements RequestHandlerInterface
{
    private $entities = [];

    public $title = 'Folk';
    public $description = 'Universal CMS';

    public function __construct($path, UriInterface $uri)
    {
        parent::__construct($path, $uri);

        $this->addServiceProvider(new Providers\Middleware());
        $this->addServiceProvider(new Providers\Router());
        $this->addServiceProvider(new Providers\Templates());
    }

    /**
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dispatcher = $this->get('middleware');

        return $dispatcher->dispatch($request);
    }

    public function getRoute(string $name, array $data = [], array $query = null): string
    {
        return $this->getUri($this->get('router')->getGenerator()->generate($name, $data)).($query ? '?'.http_build_query($query) : '');
    }

    /**
     * Set the admin entities.
     */
    public function setEntities(array $entities): self
    {
        foreach ($entities as $name => $entity) {
            $this->addEntity($name, $entity);
        }

        return $this;
    }

    /**
     * Add a new entity.
     */
    public function addEntity(string $name, EntityInterface $entity): self
    {
        $this->entities[$name] = $entity;

        return $this;
    }

    /**
     * Return whether an entity exists.
     */
    public function hasEntity(string $name): bool
    {
        return isset($this->entities[$name]);
    }

    /**
     * Return an entity.
     *
     * @throw NotFoundException
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
     * @return EntityInterface[]
     */
    public function getAllEntities(): array
    {
        return $this->entities;
    }
}
