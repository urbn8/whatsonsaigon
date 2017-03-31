<?php namespace NetSTI\Frontend\Controllers;

// LIBRERIAS
use Lang;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;

// CONTROLADOR
class Popups extends Controller{

	// PROPRIEDADES
	public $implement = [
		'Backend\Behaviors\ListController',
		'Backend\Behaviors\FormController',
		'NetSTI\Frontend\Behaviors\ModalContext'
	];
	
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'netsti.frontend.galleries'
    ];

	public function __construct()
	{
		parent::__construct();
		BackendMenu::setContext('NetSTI.Frontend', 'frontend', 'popups');
	}
}