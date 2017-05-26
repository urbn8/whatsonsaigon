<?php namespace Urbn8\JsonApi\Http;

use Urbn8\Wos\Models\Event;
use NilPortugues\Laravel5\JsonApi\Controller\JsonApiController;

class EventsController extends JsonApiController
{
    /**
     * Return the Eloquent model that will be used 
     * to model the JSON API resources. 
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getDataModel()
    {
        return new Event();
    }
}
