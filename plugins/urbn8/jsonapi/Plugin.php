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
      \App::register(\NilPortugues\Laravel5\JsonApiDingo\Laravel5JsonApiDingoServiceProvider::class);
      \App::register(\Dingo\Api\Provider\LaravelServiceProvider::class);

      $this->app['config']['api'] = require __DIR__ . '/config/api.php';
      $this->app['config']['jsonapi'] = require __DIR__ . '/config/jsonapi.php';
    }

    public function boot()
    {
      $api = app('api.router');

      $api->version('v1', function ($api) {
        $api->get('test', function() {
          return ['a'];
        });

          $api->resource('events', EventsController::class);
      });      
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
}
