<?php

declare(strict_types=1);

namespace Magma\Router;

use Magma\Base\Exception\BaseNoValueException;
use Magma\Base\Exception\BaseUnexpectedValueException;

class RouterFactory
{

    /** @var RouterInterface */
    protected RouterInterface $router;

    /** @var string  */
    protected string $dispatchedUrl;

    /** @var array */
    protected array $routes;

    /**
     * Main class constructor
     *
     * @param RouterInterface $router
     * @param string $dispatchedUrl
     * @param array $routes - from yaml file
     */
    public function __construct(string $dispatchedUrl = null, array $routes)
    {
        if (empty($routes)) {
            throw new BaseNoValueException('There are one or more empty arguments. In order to continue please ensure your <code>routes.yaml</code> has your defined routes and your passing the correct $_SERVER variable ie "QUERY_STRING".');
        }
        $this->dispatchedUrl = $dispatchedUrl;
        $this->routes = $routes;
    }

    /**
     * Instantiate the router object and checks whether the object
     * implements the correct interface else throw an exception.
     *
     * @param string $routerString
     * @return self
     */
    public function create(string $routerString) : self
    {
        $this->router = new $routerString();
        if (!$this->router instanceof RouterInterface) {
            throw new BaseUnexpectedValueException($routerString . ' is not a valid Router object');
        }
        return $this;

    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function buildRoutes()
    {
        if (is_array($this->routes) && !empty($this->routes)) {
            $args = [];
            foreach ($this->routes as $key => $route) {
                if (isset($route['namespace']) && $route['namespace'] !='') {
                    $args = ['namespace' => $route['namespace']];
                } elseif(isset($route['controller']) && $route['controller'] !='') {
                    $args = ['controller' => $route['controller'], 'action' => $route['action']];
                }
                if (isset($key)) {
                    $this->router->add($key, $args);
                }
            }
            $this->router->dispatch($this->dispatchedUrl);
        }
        return false;

    }

}