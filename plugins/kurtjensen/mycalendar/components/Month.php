<?php namespace KurtJensen\MyCalendar\Components;

use Cms\Classes\ComponentBase;

class Month extends ComponentBase {
	use \KurtJensen\MyCalendar\Traits\MyCalComponentTraits;

	public function componentDetails() {
		return [
			'name' => 'kurtjensen.mycalendar::lang.month.name',
			'description' => 'kurtjensen.mycalendar::lang.month.description',
		];
	}

	public function defineProperties() {
		return $this->propertiesFor('month');
	}

	public function init() {
		$this->initFor('month');
	}

	public function onRender() {
		// Must use onRender() for properties that can be modified in page
		$this->renderFor('month');
	}

	public function calcElements() {
		$time = $this->calcElementsFor('month');
		$this->linkPrevious = $time->copy()->subDays(2);
		$this->linkNext = $time->copy()->addDays(32);
	}

}
