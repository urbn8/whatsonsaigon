<?php namespace Urbn8\Wos\Http;

use Backend\Classes\Controller;

/**
 * Rest Event Categories Back-end Controller
 */
class RestEventCategories extends Controller
{
    public $implement = [
        'Mohsin.Rest.Behaviors.RestController'
    ];

    public $restConfig = 'config_rest.yaml';

}
