<?php namespace Urbn8\Wos\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Events extends Controller
{
    public $implement = ['Backend\Behaviors\ListController','Backend\Behaviors\FormController'];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'urbn8.wos.events' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Urbn8.Wos', 'wos-main', 'events');

        $this->addJs('http://maps.google.com/maps/api/js?language=en&key=AIzaSyBapEfdZSwOwxHNADMcze2RvCMpBH3sAso');
        $this->addJs('/plugins/urbn8/wos/assets/js/gmap3.min.js');
        $this->addJs('/plugins/urbn8/wos/assets/js/events.location.js');
    }
}