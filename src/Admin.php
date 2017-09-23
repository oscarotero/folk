<?php

namespace Folk;

use Fol\{App, NotFoundException};
use Folk\Entities\EntityInterface;
use Folk\Entities\SingleEntityInterface;
use Psr\Http\Message\{ServerRequestInterface, ResponseInterface, UriInterface};
use Interop\Http\Server\RequestHandlerInterface;
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

        $this->addServiceProvider(new Providers\Formats());
        $this->addServiceProvider(new Providers\Middleware());
        $this->addServiceProvider(new Providers\Router());
        $this->addServiceProvider(new Providers\Templates());
    }

    /**
     * {@inheritdoc}
     * 
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
     * @param string|null $id
     */
    public function addEntity(EntityInterface $entity, $id = null)
    {
        $name = $entity->getName();

        if (empty($entity->title)) {
            $entity->title = ucfirst($name);
        }

        $this->entities[$name] = [$entity, $id];
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
     * Return the entity id.
     *
     * @param string $name
     *
     * @return mixed|null
     */
    public function getEntityId(string $name)
    {
        if ($this->hasEntity($name)) {
            return $this->entities[$name][1];
        }
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
            return $this->entities[$name][0];
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
