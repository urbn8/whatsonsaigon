<?php namespace JorgeAndrade\Events\Models;

use Model;

/**
 * Calendar Model
 */
class Calendar extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_events_calendars';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'events' => 'JorgeAndrade\Events\Models\Event',
    ];

    public function getEventsCountAttribute()
    {
        return $this->events()->count();
    }

}
