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
    $modelTable, $belongsToOneSetting, $relationFilterObj
  ) {
    $joins = [];

    foreach ($relationFilterObj as $relationDatabaseEntityName => $filterObj) {
      foreach ($belongsToOneSetting as $modelRelationName => $config) {
        if ($relationDatabaseEntityName !== $modelRelationName) {
          continue;
        }

        $relationClassName = $config[0];
        $obj = new $relationClassName;
        $reflect = new ReflectionClass($obj);
        $className = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $reflect->getShortName()));

        $foreignKey = $className.'_id';

        $where = [];

        $filterObj = array_combine(
          array_map(function($k) use ($obj) { return $obj->table.'.'.$k; }, array_keys($filterObj)),
          $filterObj
        );

        foreach ($filterObj as $field => $value) {
          $where[] = [$field, '=', $value];
        }

        // dd($obj->table);

        $joins[] = [
          'table' => $obj->table,
          'on' => [$obj->table.'.id', '=', $modelTable.'.'.$foreignKey],
          'where' => $where,
        ];
      }
    }

    return [
      'joins' => $joins,
    ];
  }

  static function belongsToManyWhereClause(
    $modelTable, $modelClass, $belongsToManySetting, $relationFilterObj
  ) {
    $joins = [];

    $reflect = new ReflectionClass($modelClass);
    $modelLowerName = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $reflect->getShortName()));

    foreach ($relationFilterObj as $relationDatabaseEntityName => $filterObj) {
      foreach ($belongsToManySetting as $modelRelationName => $config) {
        if ($relationDatabaseEntityName !== $modelRelationName) {
          continue;
        }

        $relationClassName = $config[0];
        $obj = new $relationClassName;

        $reflect = new ReflectionClass($obj);
        $className = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $reflect->getShortName()));

        $primaryKey = 'id';
        $pivotTable = $config['table'];
        $foreignKey = $pivotTable.'.'.$config['key'];

        $otherKey = $config['otherKey'];

        $where = [];

        $filterObj = array_combine(
          array_map(function($k) use ($obj, $pivotTable, $otherKey) {
            if ($k == 'id') {
              return $pivotTable.'.'.$otherKey;
            }
            return $pivotTable.'.'.$k;
          }, array_keys($filterObj)),
          $filterObj
        );
        
        foreach ($filterObj as $field => $value) {
          $where[] = [$field, '=', $value];
        }

        $joins[] = [
          'table' => $pivotTable,
          'on' => [$foreignKey, '=', $modelTable.'.'.$primaryKey],
          'where' => $where,
        ];
      }
    }

    return [
      'joins' => $joins,
    ];
  }

}