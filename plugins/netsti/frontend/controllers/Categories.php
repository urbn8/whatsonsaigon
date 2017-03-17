<?php namespace NetSTI\Frontend\Controllers;

// LIBRERIAS
use Lang;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;

// CONTROLADOR
class Categories extends Controller{

	// PROPRIEDADES
	public $implement = [
		'Backend\Behaviors\ListController',
		'Backend\Behaviors\FormController',
		'Backend\Behaviors\ReorderController',
		'NetSTI\Frontend\Behaviors\ModalContext',
	];
	
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'netsti.frontend.articles'
    ];

	public function __construct()
	{
		parent::__construct();
		BackendMenu::setContext('NetSTI.Frontend', 'frontend', 'articles');
	}
}