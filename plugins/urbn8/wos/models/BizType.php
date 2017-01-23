<?php namespace Urbn8\Wos\Models;

use Model;

/**
 * Model
 */
class BizType extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;

    /**
     * Hard implement the TranslatableModel behavior.
     */
    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var array Attributes that support translation, if available.
     */
    public $translatable = ['name', 'desc'];
    
    /*
     * Validation
     */
    public $rules = [
        'name' => 'required|between:2,16',
        'slug' => 'required|unique',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'urbn8_wos_biz_types';
}