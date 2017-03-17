<?php namespace NetSTI\Frontend\Controllers;

// LIBRERIAS
use Lang;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;

// CONTROLADOR
class Frontend extends Controller{

	// PROPRIEDADES
	public $implement = [];
	public $pageTitle = "netsti.frontend::lang.menu.frontend";
	
	public $requiredPermissions = [
		'netsti.frontend.galleries', 
		'netsti.frontend.strings', 
		'netsti.frontend.testimonials',
	];

	public function __construct()
	{
		parent::__construct();
		BackendMenu::setContext('NetSTI.Frontend', 'frontend');
	}

	// METODOS
	public function index(){
		return '<div class="layout-cell layout-container" id="layout-body"> <div class="layout-relative"> <div class="layout"> <div class="layout-row"> <div class="layout"> <div class="layout-cell oc-logo-transparent"></div> </div> </div> </div> </div> </div>';
	}
}