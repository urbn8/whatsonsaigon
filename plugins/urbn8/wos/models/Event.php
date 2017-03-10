<?php namespace Urbn8\Wos\Models;

use Model;

/**
 * Model
 */
class Event extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Validation
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'urbn8_wos_events';

    public $belongsToMany = [
        'categories' => [
            'Urbn8\BizCategories\Models\Menu',
            'table' => 'urbn8_wos_business_events_categories',
            'key'      => 'event_id',
            'otherKey' => 'category_id',
        ],
    ];
}