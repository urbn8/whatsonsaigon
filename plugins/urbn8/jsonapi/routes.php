<?php
$api = app('api.router');
// $api = app('Dingo\Api\Routing\Router');

$api->version('v2', function ($api) {
    $api->resource('employees', 'EmployeesController');    

    $api->get('/test', function() {
      return ['a'];
    });
    
    // $api->get('employees/{employee_id}/orders', [ 
    //     'as' => 'employees.orders',
    //     'uses' => 'EmployeesController@getOrdersByEmployee'
    // ]);
});

