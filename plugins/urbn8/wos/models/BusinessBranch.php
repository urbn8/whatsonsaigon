<?php namespace Urbn8\Wos\Models;

use Model;

/**
 * Model
 */
class BusinessBranch extends Model
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

    protected $fillable = ['name', 'desc', 'status'];

    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|between:2,16',
        'slug' => 'required|unique:urbn8_wos_business_branches',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'urbn8_wos_business_branches';

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'business' => ['Urbn8\Wos\Models\Business'],
    ];

    public $belongsToMany = [
        'categories' => [
            'Urbn8\BizCategories\Models\Menu',
            'table' => 'urbn8_wos_business_branch_biz_category',
            'key'      => 'business_branch_id',
            'otherKey' => 'biz_category_id',
        ],
    ];

    public function scopeTestScope($query)
    {
        return $query;
    }
}