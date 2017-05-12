<?php namespace Urbn8\Jsonapi;

use Route;
use System\Classes\PluginBase;

use Urbn8\JsonApi\Http\EventsController;

// https://github.com/jonathandey/oc-jd-dingoapi/

class Plugin extends PluginBase
{
    public $require = ['RainLab.User', 'Urbn8.Wos'];

    public function register()
    {
      \App::register(\Dingo\Api\Provider\LaravelServiceProvider::class);
      \App::register(\NilPortugues\Laravel5\JsonApiDingo\Laravel5JsonApiDingoServiceProvider::class);

      $this->app['config']['api'] = require __DIR__ . '/config/api.php';
      $this->app['config']['jsonapi'] = require __DIR__ . '/config/jsonapi.php';
    }

    public function boot()
    {
      // require realpath(__DIR__ . '/routes.php');

      // $api = app('Dingo\Api\Routing\Router');
      $api = app('api.router');

      $api->version('v1', function ($api) {
        $api->get('test', function() {
          return ['a'];
        });

          $api->resource('events', EventsController::class);    
          
          // $api->get('employees/{employee_id}/orders', [ 
          //     'as' => 'employees.orders',
          //     'uses' => 'EmployeesController@getOrdersByEmployee'
          // ]);
      });

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
