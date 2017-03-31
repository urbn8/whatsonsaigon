<?php namespace KurtJensen\MyCalendar\Components;

use Cms\Classes\ComponentBase;

class Week extends ComponentBase {
	use \KurtJensen\MyCalendar\Traits\MyCalComponentTraits;

	public function componentDetails() {
		return [
			'name' => 'kurtjensen.mycalendar::lang.week.name',
			'description' => 'kurtjensen.mycalendar::lang.week.description',
		];
	}

	public function defineProperties() {
		return $this->propertiesFor('week');
	}

	public function init() {
		$this->initFor('week');
	}

	public function onRender() {
		// Must use onRender() for properties that can be modified in page
		$this->renderFor('week');
	}

	public function calcElements() {
		$time = $this->calcElementsFor('week');
		$this->linkPrevious = $time->copy()->subDays(7);
		$this->linkNext = $time->copy()->addDays(7);
	}

}
