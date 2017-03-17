<?php namespace NetSTI\Frontend\Controllers;

// LIBRERIAS
use Lang;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use NetSTI\Frontend\Classes\Bower;

// CONTROLADOR
class Packages extends Controller{

	// PROPRIEDADES
	public $implement = [];
	public $pageTitle = "netsti.frontend::lang.menu.packages";
	private $bower;
	
	public $requiredPermissions = ['netsti.frontend.packages'];

	public function __construct()
	{
		parent::__construct();
		BackendMenu::setContext('NetSTI.Frontend', 'frontend', 'packages');

		$this->bower = new Bower();
	}

	// METODOS
	public function index(){
		$this->bodyClass = 'slim-container';
		$this->addCss('/plugins/netsti/frontend/assets/css/packages.css');

		$this->bower->updateCommand();
		$this->bower->updateTheme();

		return $this->makePartial('index');
	}

	public function onSearchForm(){
		return $this->makePartial('search');
	}

	public function onPackageForm(){
		$this->vars['slug'] = post('package');
		$this->vars['version'] = post('version');
		$this->vars['package'] = $this->bower->getSummaryPackage(post('package'));
		return $this->makePartial('package');
	}

	public function onUpdatePackages(){
		$this->vars['output'] = $this->bower->updatePackages();
		$this->vars['data'] = $this->bower->listPackages();

		Flash::success('The packages successfully updated');
	}

	public function onSearchPackage(){
		$this->vars['result'] = $this->bower->searchPackages(post('q'));
	}

	public function onInstallPakages(){
		$list = str_replace('&', ' ', str_replace('checked=', '', post('checked')));
		if(strlen($list) > 1)
			$this->vars['output'] = $this->bower->install($list);

		$this->vars['data'] = $this->bower->listPackages();

		Flash::success('The package successfully installed');
	}

	public function onRemovePakages(){
		$listArray = explode('&', str_replace('checked=', '', post('checked')));
		$list = str_replace('&', ' ', str_replace('checked=', '', post('checked')));
		if(count($listArray) == 1)
			$this->vars['output'] = $this->bower->uninstall($list);
		else
			Flash::error('Only can remove one package');

		$this->vars['data'] = $this->bower->listPackages();
	}

	public function listPackages(){
		$this->vars['data'] = $this->bower->listPackages();
		return $this->makePartial('list');
	}

	public function listSearchPackages(){
		$this->vars['result'] = $this->bower->searchPackages('');
		return $this->makePartial('packages');
	}

	public function getFileType($file){
		return pathinfo($file, PATHINFO_EXTENSION);
	}

	public function listFiles(){
		return $this->bower->getListFiles();
	}
}