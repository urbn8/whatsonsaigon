<?php namespace KurtJensen\MyCalendar\Components;

use KurtJensen\MyCalendar\Components\Events;
use KurtJensen\MyCalendar\Components\Month;

class MonthEvents extends Month {
	public $EventsComp = null;
	public $eventsCompEvents = [];

	public function componentDetails() {
		return [
			'name' => 'kurtjensen.mycalendar::lang.month_events.name',
			'description' => 'kurtjensen.mycalendar::lang.month_events.description',
		];
	}

	public function defineProperties() {
		$this->EventsComp = new Events();
		$this->EventsComp->compLink = 'MonthEvents';
		$properties = $this->propertiesFor('month');

		return array_merge($properties, $this->EventsComp->defineProperties());
	}

	public function init() {
		$this->initFor('month');
		$this->EventsComp->linkpage = $this->property('linkpage');
		$this->EventsComp->category = $this->property('category', null);
		$this->EventsComp->usePermissions = $this->property('usePermissions', 0);
		$this->EventsComp->dayspast = $this->property('dayspast', 120);
		$this->EventsComp->daysfuture = $this->property('daysfuture', 60);
	}

	public function onRun() {
		$this->eventsCompEvents = $this->EventsComp->loadEvents();
	}

	public function onRender() {
		$this->renderFor('month');
		$this->events = $this->eventsCompEvents;
	}

	public function onShowEvent() {
		$this->EventsComp->compLink = 'MonthEvents';
		return $this->page['ev'] = $this->EventsComp->onShowEvent();
	}

}
