<?php namespace Urbn8\Wos\Models;

use Model;

/**
 * Model
 */
class Event extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    
    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|between:2,16',
        'slug' => 'required|unique:urbn8_wos_events',
    ];

    protected $slugs = ['slug' => 'name'];

    protected $fillable = ['name',
      'district', 'address', 'lat_lon',
      'desc',
      'status'
    ];

    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name', 'address', 'desc'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'urbn8_wos_events';

    public $belongsToMany = [
        'categories' => [
            'Urbn8\Wos\Models\EventCategory',
            'table' => 'urbn8_wos_event_category_joins',
            'key'      => 'event_id',
            'otherKey' => 'category_id',
        ],
    ];

    public $belongsToOne = [
        'organiser' => [
            'Urbn8\Wos\Models\Organiser',
        ],
    ];

    public $attachOne = [
        'thumbnail' => 'System\Models\File'
    ];

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setEditUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'event_id' => $this->id,
            'slug' => $this->slug,
            'business_id' => $this->business_id,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }
}