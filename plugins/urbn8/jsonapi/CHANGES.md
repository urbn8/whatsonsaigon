/opt/lampp/htdocs/whatsonsaigon/plugins/urbn8/jsonapi/vendor/nilportugues/laravel5-json-api/src/NilPortugues/Laravel5/JsonApi/Controller/JsonApiController.php

```
    public function index()
    {
        $apiRequest = RequestFactory::create();

        $page = $apiRequest->getPage();
        if (!$page->size()) {
            $page->setSize($this->pageSize);
        }

        $fields = $apiRequest->getFields();
        $sorting = $apiRequest->getSort();
        $included = $apiRequest->getIncludedRelationships();
        $filters = $apiRequest->getFilters();

        $resource = new ListResource($this->serializer, $page, $fields, $sorting, $included, $filters);

        $totalAmount = $this->totalAmountResourceCallable($page, $filters);
        $results = $this->listResourceCallable($page, $filters);

        // $controllerAction = '\\'.get_called_class().'@index';
        // $uri = $this->uriGenerator($controllerAction);
        $uri = $this->currentUrl();

        return $this->addHeaders($resource->get($totalAmount, $results, $uri, get_class($this->getDataModel())));
    }
```

/opt/lampp/htdocs/whatsonsaigon/plugins/urbn8/jsonapi/vendor/nilportugues/laravel5-json-api/src/NilPortugues/Laravel5/JsonApi/Controller/JsonApiTrait.php
```
++
protected function currentUrl()
    {
        return app('Dingo\Api\Routing\UrlGenerator')->current();
    }
```

```
protected function listResourceCallable($page, $filters)
    {
        return function () use ($page, $filters) {
            $offset = ($page->number() - 1) * ($page->size());
            return $this->getDataModel()->query()->where($filters)->offset($offset)->limit($page->size())->get();
            // return EloquentHelper::paginate($this->serializer,
            //   $this->getDataModel()->query()->where($filters)->offset($offset),
            //   $page->size())->get();
        };
    }
```

/opt/lampp/htdocs/whatsonsaigon/plugins/urbn8/jsonapi/vendor/dingo/api/src/Exception/Handler.php
```
protected function prepareReplacements(Exception $exception)
    {
        $statusCode = $this->getStatusCode($exception);

        if (! $message = $exception->getMessage()) {
            $message = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

        $replacements = [
            ':message' => $message,
            ':status_code' => $statusCode,
        ];

        $exceptionError = $exception;

        if ($exception instanceof DataException) {
          $exceptionError = $exception->getErrors();
        }

        if (($exceptionError instanceof MessageBagErrors)
          && $exceptionError->hasErrors()) {
            $errors = $exceptionError->getErrors();
            if (is_array($errors)) {
              $replacements[':errors'] = $errors;
            } else {
              $replacements[':errors'] = $errors->toArray();
            }
        } else if ($exceptionError instanceof ErrorBag) {
            $replacements[':errors'] = $exceptionError->toArray();
        }

        if ($code = $exception->getCode()) {
            $replacements[':code'] = $code;
        }

        if ($this->runningInDebugMode()) {
            $replacements[':debug'] = [
                'line' => $exceptionError->getLine(),
                'file' => $exceptionError->getFile(),
                'class' => get_class($exceptionError),
                'trace' => explode("\n", $exceptionError->getTraceAsString()),
            ];
        }
        return array_merge($replacements, $this->replacements);
    }
```

/opt/lampp/htdocs/whatsonsaigon/plugins/urbn8/jsonapi/vendor/nilportugues/laravel5-json-api-dingo/src/NilPortugues/Laravel5/JsonApiDingo/DingoProvider.php
```
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
```