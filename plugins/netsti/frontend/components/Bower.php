<?php namespace NetSTI\Frontend\Components;

use NetSTI\Frontend\Classes\Bower as BowerClass;
use Illuminate\Support\Facades\Schema;

class Bower extends \Cms\Classes\ComponentBase{

	public function componentDetails()
	{
		return [
			'name'        => 'netsti.frontend::lang.bower_component',
			'description' => 'netsti.frontend::lang.bower_component_description',
		];
	}

	public function onRun(){
		$bower = new BowerClass();
		$this->page['deps'] = $bower->getListFiles();
	}
}
