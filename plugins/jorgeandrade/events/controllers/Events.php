<?php namespace JorgeAndrade\Events\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Events Back-end Controller
 */
class Events extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = ['jorgeandrade.events.access_events'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('JorgeAndrade.Events', 'events', 'events');
        $this->addJs('http://maps.google.com/maps/api/js?language=en');
        $this->addJs('/plugins/jorgeandrade/events/assets/js/gmap3.min.js');
        $this->addJs('/plugins/jorgeandrade/events/assets/js/events.location.js');
    }
}
