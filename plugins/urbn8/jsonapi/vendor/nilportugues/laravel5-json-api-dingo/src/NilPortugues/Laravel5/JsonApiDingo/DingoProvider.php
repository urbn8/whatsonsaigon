<?php

namespace NilPortugues\Laravel5\JsonApiDingo;

use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use ReflectionClass;
use NilPortugues\Laravel5\JsonApi\Providers\Laravel52Provider;

class DingoProvider extends Laravel52Provider
{
    /**
     * @var RouteCollection
     */
    protected $routerCollection;

    /**
     * @param array $value
     *
     * @return mixed|string
     *
     * @throws \Exception
     */
    protected function calculateRoute(array $value)
    {
        $router = app('Dingo\Api\Routing\Router');
        $route = '';

        /** @var \Illuminate\Routing\Route $routerObject */
        // foreach ($this->getRouterCollection($router) as $routerObject) {
        //     if ($routerObject->getName() === $value['name']) {
        //         $route = $routerObject->getPath();

        //         return $this->calculateFullPath($value, $route);
        //     }
        // }
        foreach ($this->getDingoRouterCollection($router) as $name => $routerObject) {
            if ($name === 'api.'.$value['name']) {
                $route = $routerObject->getUri();
                return $this->calculateFullPath($value, $route);
            }
        }

        if (empty($route)) {
            throw new \Exception('Provided route name does not exist');
        }
    }

    /**
     * @param UrlGenerator $router
     *
     * @return mixed
     */
    protected function getDingoRouterCollection($router)
    {
        if (!empty($this->routerCollection)) {
            return $this->routerCollection;
        }

        $adapterRoutes = array_values($router->getAdapterRoutes())[0];
        

        $reflectionClass = new ReflectionClass($adapterRoutes);
        $reflectionProperty = $reflectionClass->getProperty('nameList');
        $reflectionProperty->setAccessible(true);
        $routeCollection = $reflectionProperty->getValue($adapterRoutes);

        $this->routerCollection = $routeCollection;

        return $routeCollection;
    }

    /**
     * @param UrlGenerator $router
     *
     * @return mixed
     */
    protected function getRouterCollection(UrlGenerator $router)
    {
        if (!empty($this->routerCollection)) {
            return $this->routerCollection;
        }

        $reflectionClass = new ReflectionClass($router);
        $reflectionProperty = $reflectionClass->getProperty('routes');
        $reflectionProperty->setAccessible(true);
        $routeCollection = $reflectionProperty->getValue($router);

        $this->routerCollection = $routeCollection;

        return $routeCollection;
    }

    /**
     * @param array  $value
     * @param string $route
     *
     * @return mixed|string
     */
    protected function calculateFullPath(array &$value, $route)
    {
        if (!empty($value['as_id'])) {
            preg_match_all('/{(.*?)}/', $route, $matches);
            $route = str_replace($matches[0], '{'.$value['as_id'].'}', $route);
        }

        return url($route);
    }
}
