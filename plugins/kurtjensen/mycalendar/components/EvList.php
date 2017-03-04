<?php namespace KurtJensen\MyCalendar\Components;

use Cms\Classes\ComponentBase;

class EvList extends ComponentBase {
	use \KurtJensen\MyCalendar\Traits\MyCalComponentTraits;

	public function componentDetails() {
		return [
			'name' => 'kurtjensen.mycalendar::lang.evlist.name',
			'description' => 'kurtjensen.mycalendar::lang.evlist.description',
		];
	}

	public function defineProperties() {
		return $this->propertiesFor('list');
	}

	public function init() {
		$this->initFor('list');
	}

	public function onRender() {
		// Must use onRender() for properties that can be modified in page
		$this->renderFor('list');
	}
}
