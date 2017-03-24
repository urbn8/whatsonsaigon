<?php namespace Urbn8\Wos\Http;

use Backend\Classes\Controller;

/**
 * Organisers Back-end Controller
 */
class Organisers extends Controller
{
    public $implement = [
        'Mohsin.Rest.Behaviors.RestController'
    ];

    public $restConfig = 'config_rest.yaml';

}
