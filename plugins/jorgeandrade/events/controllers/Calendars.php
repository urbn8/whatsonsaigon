<?php namespace JorgeAndrade\Events\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Calendars Back-end Controller
 */
class Calendars extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['jorgeandrade.events.access_calendars'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('JorgeAndrade.Events', 'events', 'calendars');
    }
}
