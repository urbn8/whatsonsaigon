<?php namespace JorgeAndrade\Events\Models;

use Model;

/**
 * Event Model
 */
class Event extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'jorgeandrade_events_events';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['name', 'slug', 'detail', 'calendar_id', 'course_id'];

    protected $dates = ['start_at', 'ends_at', 'created_at', 'updated_at'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'calendar' => 'JorgeAndrade\Events\Models\Calendar',
    ];

    public $hasMany = [
        'dates' => 'JorgeAndrade\Events\Models\Date',
    ];

    public $attachOne = [
        'banner' => 'System\Models\File',
    ];

    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];
        return $this->url = $controller->pageUrl($pageName, $params);
    }

}
