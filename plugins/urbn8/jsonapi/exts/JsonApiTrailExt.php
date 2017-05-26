<?php

namespace Urbn8\JsonApi\Exts;

use ReflectionClass;

class JsonApiTrailExt {

  static function relationFilters($filters)
  {
    $out = [];
    foreach ($filters as $key => $value) {
      if (is_array($value)) {
        $out[$key] = $value;
      }
    }

    return $out;
  }

  static function fieldFilters($filters) {
    $out = [];
    foreach ($filters as $key => $value) {
      if (!is_array($value)) {
        $out[$key] = $value;
      }
    }

    return $out;
  }

  static function databaseEntityName($modelInstance) {
    $reflect = new ReflectionClass($modelInstance);
    $out = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $reflect->getShortName()));
    return $out;
  }
  
  static function pageOffset($page) {
    $offset = ($page->number() - 1) * ($page->size());
    return $offset;
  }

  static function belongsToOneWhereClause(
    $modelTable, $belongsToOneSetting, $relationFilterObj, &$join
  ) {
    foreach ($relationFilterObj as $relationDatabaseEntityName => $filterObj) {
      foreach ($this->getDataModel()->belongsToOne as $modelRelationName => $config) {
        if ($relationName === $modelRelationName) {
          $relationClassName = $config[0];
          $obj = new $relationClassName;

          $reflect = new ReflectionClass($obj);
          Log::info($reflect->getShortName());
          $className = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $reflect->getShortName()));
          $foreignKey = $className.'_id';

          $query->join($obj->table, function($join) use ($obj, $foreignKey, $filterObj) {
            $join->on($obj->table.'.id', '=', $modelTableZ.'.'.$foreignKey);
            
            $filterObj = array_combine(
                array_map(function($k) use ($obj) { return $obj->table.'.'.$k; }, array_keys($filterObj)),
                $filterObj
            );

            foreach ($filters as $field => $value) {
              $join->where($field, '=', $value);
            }
          });
        }
      }
    }
  }
}