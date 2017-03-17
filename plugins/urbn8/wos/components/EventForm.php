<?php namespace Urbn8\Wos\Components;

use Cms\Classes\ComponentBase;

class EventForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Event Form',
            'description' => 'Display event form.'
        ];
    }

    public function onRun()
    {
        
    }

    // This array becomes available on the page as {{ component.posts }}
    public function events()
    {
        return ['First Post', 'Second Post', 'Third Post', 'choithoi'.$this->property('testChoiThoi')];
    }

    public function defineProperties()
    {
        return [
            'testChoiThoi' => [
                'title'             => 'Max items',
                'description'       => 'The most amount of todo items allowed',
                'default'           => 10,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'The Max Items property can contain only numeric symbols'
            ],
        ];
    }
}
