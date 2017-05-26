<?php namespace Urbn8\Wos\Models;

use Model;

/**
 * Model
 */
class Organiser extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;

    /**
     * Hard implement the TranslatableModel behavior.
     */
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];
    
    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = [
      'name', 'desc',
      ['slug', 'index' => true],
    ];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    protected $fillable = [
      'name',
      'website', 'phone', 'email', 'facebook', 'twitter', 'address',
      'open_at', 'close_at',
      'desc',
      'status'];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|between:2,16',
        'slug' => 'required|unique:urbn8_wos_organisers',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'urbn8_wos_organisers';

    public $belongsToMany = [
        'users' => [
            'RainLab\User\Models\User',
            'table' => 'urbn8_wos_organiser_user_joins',
        ],
        'categories' => [
            'Urbn8\Wos\Models\EventCategory',
            'table' => 'urbn8_wos_organiser_category_joins',
            'key'      => 'organiser_id',
            'otherKey' => 'category_id',
        ],
    ];

    public $hasMany = [
      'events' => 'Urbn8\Wos\Models\Event'
    ];

    public $attachOne = [
      'logo' => 'System\Models\File'
    ];

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    public function setEventUrl($pageName, $controller)
    {
        $params = [
            'organiser_id' => $this->id,
        ];

        return $this->eventUrl = $controller->pageUrl($pageName, $params);
    }


    public function hasCategory($categoryId) {
      $result = array_search(intval($categoryId), array_column($this->categories->toArray(), 'id'));
      return $result !== false;
    }
}
