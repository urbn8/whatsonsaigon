<?php namespace Urbn8\Jsonapi;

use Route;
use System\Classes\PluginBase;

use Urbn8\JsonApi\http\EmployeesController;

// https://github.com/jonathandey/oc-jd-dingoapi/

class Plugin extends PluginBase
{
    public $require = ['RainLab.User'];

    public function register()
    {
      \App::register(\Dingo\Api\Provider\LaravelServiceProvider::class);

      $this->app['config']['api'] = require __DIR__ . '/config/api.php';
    }

    public function boot()
    {
      // $api = app('Dingo\Api\Routing\Router');
      // $api = app('api.router');

      // $api->version('v2', function ($api) {
      //   $api->get('test', function() {
      //     return ['a'];
      //   });

      //     $api->resource('employees', EmployeesController::class);    
          
      //     // $api->get('employees/{employee_id}/orders', [ 
      //     //     'as' => 'employees.orders',
      //     //     'uses' => 'EmployeesController@getOrdersByEmployee'
      //     // ]);
      // });

      // Route::group(['prefix' => 'api/v3'], function () {
      //     Route::resource('eventsaaa', 'Urbn8\Wos\Http\RestEvents');
      // });
      
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
}
