<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 13/01/16
 * Time: 19:56.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Laravel5\JsonApi\Controller;

use ReflectionClass;
use Log;
use DB;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use NilPortugues\Laravel5\JsonApi\Actions\PatchResource;
use NilPortugues\Laravel5\JsonApi\Actions\PutResource;
use NilPortugues\Api\JsonApi\Server\Errors\Error;
use NilPortugues\Api\JsonApi\Server\Errors\ErrorBag;
use NilPortugues\Laravel5\JsonApi\Eloquent\EloquentHelper;
use NilPortugues\Laravel5\JsonApi\JsonApiSerializer;
use NilPortugues\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

use Urbn8\JsonApi\Exts\JsonApiTrailExt;

trait JsonApiTrait
{
    /**
     * @var JsonApiSerializer
     */
    protected $serializer;

    /**
     * @var int
     */
    protected $pageSize = 10;

    /**
     * @param JsonApiSerializer $serializer
     */
    public function __construct(JsonApiSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $controllerAction
     *
     * @return mixed
     */
    protected function uriGenerator($controllerAction)
    {
        return Container::getInstance()->make('url')->action($controllerAction, [], true);
    }

    protected function currentUrl()
    {
        return app('Dingo\Api\Routing\UrlGenerator')->current();
    }

    /**
     * Returns the total number of results available for the current resource.
     *
     * @return callable
     * @codeCoverageIgnore
     */
    protected function totalAmountResourceCallable()
    {
        return function () {
            $idKey = $this->getDataModel()->getKeyName();

            return $this->getDataModel()->query()->count([$idKey]);
        };
    }

    /**
     * Returns an Eloquent Model.
     *
     * @return Model
     */
    abstract public function getDataModel();

    protected function parseFilters($filters)
    {
      $joinFilters = [];
      $fieldFilters = [];
      foreach ($filters as $key => $value) {
        if (is_array($value)) {
          $joinFilters[$key] = $value;
          continue;
        }

        $fieldFilters[$key] = $value;
      }

      return [$joinFilters, $fieldFilters];
    }

    /**
     * Returns a list of resources based on pagination criteria.
     *
     * @return callable
     * @codeCoverageIgnore
     */
    protected function listResourceCallable($page, $filters)
    {

        return function () use ($page, $filters) {
            $relationFilters = JsonApiTrailExt::relationFilters($filters);
            $fieldFilters = JsonApiTrailExt::fieldFilters($filters);

            $reflect = new ReflectionClass($this->getDataModel());
            $targetTable = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $reflect->getShortName()));
            
            $offset = ($page->number() - 1) * ($page->size());
            $query = $this->getDataModel()
              ->select($this->getDataModel()->table.'.*')
              ->where($fieldFilters)
              ->limit($page->size())
              ->offset($offset);
            
            $clause = JsonApiTrailExt::belongsToOneWhereClause(
              $this->getDataModel()->table,
              $this->getDataModel()->belongsToOne,
              $relationFilters
            );

            foreach ($clause['joins'] as $join) {
              $query->join($join['table'], function($joiner) use ($join) {
                $joiner->on(...$join['on']);

                foreach ($join['where'] as $where) {
                  $joiner->where(...$where);
                }
              });
            }
            
            foreach ($fieldFilters as $relationName => $filters) {

              foreach ($this->getDataModel()->belongsToMany as $modelRelationName => $config) {
                if ($relationName === $modelRelationName) {
                  $relationClassName = $config[0];
                  $obj = new $relationClassName;

                  $reflect = new ReflectionClass($obj);
                  Log::info($reflect->getShortName());

                  $className = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $reflect->getShortName()));

                  $primaryKey = 'id';
                  $foreignKey = $config['key'];
                  
                  $pivotTable = $config['table'];

                  $query->join($pivotTable, function($join) use ($obj, $primaryKey, $foreignKey, $filters, $pivotTable, $targetTable) {
                    $join->on($foreignKey, '=', $this->getDataModel()->table.'.'.$primaryKey);
                    
                    $filters = array_combine(
                        array_map(function($k) use ($obj, $pivotTable, $targetTable) {
                          if ($k == 'id') {
                            return $pivotTable.'.'.$targetTable.'_id';
                          }
                          return $pivotTable.'.'.$k;
                        }, array_keys($filters)),
                        $filters
                    );
                    
                    foreach ($filters as $field => $value) {
                      $join->where($field, '=', $value);
                    }
                  });
                }
              }
            }

            return $query->get();
        };
    }

    /**
     * @param Response $response
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function addHeaders(Response $response)
    {
        return $response;
    }

    /**
     * @param $id
     *
     * @return callable
     * @codeCoverageIgnore
     */
    protected function findResourceCallable($id)
    {
        return function () use ($id) {
            $idKey = $this->getDataModel()->getKeyName();
            $model = $this->getDataModel()->query()->where($idKey, $id)->first();

            return $model;
        };
    }

    /**
     * Reads the input and creates and saves a new Eloquent Model.
     *
     * @return callable
     * @codeCoverageIgnore
     */
    protected function createResourceCallable()
    {
        return function (array $data, array $values, ErrorBag $errorBag) {
            $model = $this->getDataModel()->newInstance();

            foreach ($values as $attribute => $value) {
                $model->setAttribute($attribute, $value);
            }

            if (!empty($data['id'])) {
                $model->setAttribute($model->getKeyName(), $data['id']);
            }

            try {
                $model->save();
            } catch (\Exception $e) {
                $errorBag[] = new Error('creation_error', 'Resource could not be created');
                throw $e;
            }

            return $model;
        };
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    protected function putAction(Request $request, $id)
    {
        $find = $this->findResourceCallable($id);
        $update = $this->updateResourceCallable();

        $resource = new PutResource($this->serializer);
        $model = $this->getDataModel();
        $data = (array) $request->get('data');
        if (array_key_exists('attributes', $data) && $model->timestamps) {
            $data['attributes'][$model::UPDATED_AT] = Carbon::now()->toDateTimeString();
        }

        return $this->addHeaders(
            $resource->get($id, $data, get_class($model), $find, $update)
        );
    }

    /**
     * @return callable
     * @codeCoverageIgnore
     */
    protected function updateResourceCallable()
    {
        return function (Model $model, array $data, array $values, ErrorBag $errorBag) {
            foreach ($values as $attribute => $value) {
                $model->$attribute = $value;
            }
            try {
                $model->update();
            } catch (\Exception $e) {
                $errorBag[] = new Error('update_failed', 'Could not update resource.');
                throw $e;
            }
        };
    }

    /**
     * @param Request $request
     * @param $id
     * @return Response
     */
    protected function patchAction(Request $request, $id)
    {
        $find = $this->findResourceCallable($id);
        $update = $this->updateResourceCallable();

        $resource = new PatchResource($this->serializer);

        $model = $this->getDataModel();
        $data = (array) $request->get('data');
        if (array_key_exists('attributes', $data) && $model->timestamps) {
            $data['attributes'][$model::UPDATED_AT] = Carbon::now()->toDateTimeString();
        }
        
        return $this->addHeaders(
            $resource->get($id, $data, get_class($model), $find, $update)
        );
    }

    /**
     * @param $id
     *
     * @return \Closure
     */
    protected function deleteResourceCallable($id)
    {
        return function () use ($id) {
            $idKey = $this->getDataModel()->getKeyName();
            $model = $this->getDataModel()->query()->where($idKey, $id)->first();

            return $model->delete();
        };
    }
}
