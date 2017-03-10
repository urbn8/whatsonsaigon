<?php namespace JorgeAndrade\Events\Models;

use Model;

/**
 * Date Model
 */
class Date extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_events_dates';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['title', 'url', 'date', 'time_init', 'time_end'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'event' => 'JorgeAndrade\Events\Models\Event',
    ];

}
