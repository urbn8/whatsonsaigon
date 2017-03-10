<?php namespace Urbn8\Wos\Models;

use Model;

/**
 * Model
 */
class Business extends Model
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
    public $translatable = ['name', 'desc'];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|between:2,16',
        'slug' => 'required|unique:urbn8_wos_businesses',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'urbn8_wos_businesses';

    /**
     * @var array Relations
     */
    public $hasMany = [
        'branches' => ['Urbn8\Wos\Models\BusinessBranch', 'scope' => 'testScope'],
    ];

    public $belongsToMany = [
        'users' => [
            'RainLab\User\Models\User',
            'table' => 'urbn8_wos_business_user',
        ],
    ];
}