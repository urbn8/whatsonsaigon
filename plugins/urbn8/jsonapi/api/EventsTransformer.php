<?php namespace Urbn8\JsonApi\Api;

use Urbn8\Wos\Models\Event;
use NilPortugues\Api\Mappings\JsonApiMapping;

class EventsTransformer implements JsonApiMapping
{
    /**
     * Returns a string with the full class name, including namespace.
     *
     * @return string
     */
    public function getClass()
    {
        return Event::class;
    }

    /**
     * Returns a string representing the resource name 
     * as it will be shown after the mapping.
     *
     * @return string
     */
    public function getAlias()
    {
        return 'event';
    }

    /**
     * Returns an array of properties that will be renamed.
     * Key is current property from the class. 
     * Value is the property's alias name.
     *
     * @return array
     */
    public function getAliasedProperties()
    {
        return [];
    }

    /**
     * List of properties in the class that will be  ignored by the mapping.
     *
     * @return array
     */
    public function getHideProperties()
    {
        return [];
    }

    /**
     * Returns an array of properties that are used as an ID value.
     *
     * @return array
     */
    public function getIdProperties()
    {
        return ['id'];
    }

    /**
     * Returns a list of URLs. This urls must have placeholders 
     * to be replaced with the getIdProperties() values.
     *
     * @return array
     */
    public function getUrls()
    {
        return [
            'self' => ['name' => 'events.show', 'as_id' => 'id'],
        ];
    }

    /**
     * Returns an array containing the relationship mappings as an array.
     * Key for each relationship defined must match a property of the mapped class.
     *
     * @return array
     */
    public function getRelationships()
    {
        return [];
    }
       
    /**
     * Returns an array of properties that are mandatory to be passed in when doing create or update.
     *
     * @return array
     */
    public function getRequiredProperties() {
        return [];
    }
}
