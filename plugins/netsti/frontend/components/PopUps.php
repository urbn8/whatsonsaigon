<?php namespace NetSTI\Frontend\Components;

use NetSTI\Frontend\Models\Popup;
use Illuminate\Support\Facades\Schema;

class PopUps extends \Cms\Classes\ComponentBase{

	public $slug;
	public $popup;

	public function componentDetails()
	{
		return [
			'name'        => 'netsti.frontend::lang.popup_component',
			'description' => 'netsti.frontend::lang.popup_component_description',
		];
	}

	public function defineProperties(){
		return [
			'slug' => [
				'title'        => 'Ad to Embed',
				'type'         => 'dropdown',
				'required' => true
			],
		];
	}

	public function onRun()
	{
		$this->prepareVars();

		$this->addCss('/plugins/netsti/frontend/assets/css/animate.css');
		$this->addCss('/plugins/netsti/frontend/assets/css/popup.css');
		$this->addJs('/plugins/netsti/frontend/assets/js/popup.js');
	}

	protected function prepareVars(){
		$this->slug = $this->property('slug');
		$this->popup = Popup::whereSlug($this->property('slug'))->first();
	}

	public function getUrl(){
		return $this->currentPageUrl();
	}

	public function onSetCount(){
		$el = Popup::find(post('id'));

		if(post('mode') == 'clicks'){
			$el->setClickCount();
			return redirect(post('url'));
		}else{
			$el->setBounceCount();
		}
	}

	public function getSlugOptions(){
		return Popup::lists('title', 'slug');
	}

}
