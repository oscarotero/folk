<?php

namespace Folk;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

class Middleware implements MiddlewareInterface
{
    private $uri;
    private $factory;

    /**
     * Set the Uri of the admin.
     *
     * @param UriInterface $uri
     * @param ...$arguments
     */
    public function __construct(UriInterface $uri, callable $factory)
    {
        $this->uri = $uri;
        $this->factory = $factory;
    }

    /**
     * Process a server request and return a response.
     *
     * @param ServerRequestInterface $request
     * @param DelegateInterface      $delegate
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        if (strpos($request->getUri()->getPath(), $this->uri->getPath()) === 0) {
            $admin = call_user_func($this->factory, $this->uri);

            return $admin($request);
        }

        return $delegate->process($request);
    }
}
