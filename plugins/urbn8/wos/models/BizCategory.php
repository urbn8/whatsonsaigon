<?php namespace Urbn8\Wos\Models;

use Model;

/**
 * Model
 */
class BizCategory extends Model
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
    public $table = 'urbn8_wos_biz_categories';
}