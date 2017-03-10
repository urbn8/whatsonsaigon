<?php namespace JorgeAndrade\Events\Components;

use Cms\Classes\ComponentBase;
use JorgeAndrade\Events\Models\Calendar;

class EventList extends ComponentBase
{
    public $locale = 'en';

    public function componentDetails()
    {
        return [
            'name' => 'Events List Component',
            'description' => 'Show a list of events.',
        ];
    }

    public function defineProperties()
    {
        return [
            'eventsPerPage' => [
                'title' => 'Events per page',
                'description' => 'Max event shown per page.',
                'default' => 10,
            ],
            'noEventMessage' => [
                'title' => 'No Event Message',
                'description' => 'Message shown when is not events.',
                'default' => 'No events.',
            ],
            'calendar' => [
                'title' => 'Calendar',
                'description' => 'Select how calendar events show',
                'type' => 'dropdown',
                'default' => 1,
            ],
            'eventPage' => [
                'title' => 'Event Page',
                'description' => 'Name of the event page file for the "Read more" links. This property is used by the default component partial.',
                'default' => 'events/event',
                'group' => 'Links',
            ],
        ];
    }

    public function getCalendarOptions()
    {
        return Calendar::whereIsActive(true)->orderBy('name')->get()->lists('name', 'id');
    }

    public function onRun()
    {
        // Get current locale if rainlab.translate plugin is installed
        if (class_exists('\RainLab\Translate\Classes\Translator')) {
            $this->locale = \RainLab\Translate\Classes\Translator::instance()->getLocale();
        }

        $this->noEventMessage = $this->page['noEventMessage'] = $this->property('noEventMessage');
        $this->events = $this->page['events'] = $this->listEvents();
    }
    protected function listEvents()
    {
        $calendar = Calendar::findOrFail($this->property('calendar'));
        $events = $calendar->events()->paginate($this->property('eventsPerPage'));
        $events->each(function ($event) {
            $event->setUrl($this->property('eventPage'), $this->controller);
        });

        return $events;
    }

}
