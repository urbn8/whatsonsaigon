<?php namespace Urbn8\Wos\Http;

use Backend\Classes\Controller;

/**
 * Rest Events Back-end Controller
 */
class RestEvents extends Controller
{
    public $implement = [
        'Mohsin.Rest.Behaviors.RestController'
    ];

    public $restConfig = 'config_rest.yaml';

}
