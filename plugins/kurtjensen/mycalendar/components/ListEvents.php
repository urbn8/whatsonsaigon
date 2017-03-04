<?php namespace KurtJensen\MyCalendar\Components;

use KurtJensen\MyCalendar\Components\Events;
use KurtJensen\MyCalendar\Components\EvList;

class ListEvents extends EvList {
	public $EventsComp = null;
	public $eventsCompEvents = [];

	public function componentDetails() {
		return [
			'name' => 'kurtjensen.mycalendar::lang.list_events.name',
			'description' => 'kurtjensen.mycalendar::lang.list_events.description',
		];
	}

	public function defineProperties() {
		$this->EventsComp = new Events();
		return array_merge($this->propertiesFor('list'), $this->propertiesFor('events'));
	}

	public function init() {
		$this->initFor('list');
		$this->EventsComp->compLink = 'ListEvents';
		$this->EventsComp->month = $this->property('month');
		$this->EventsComp->year = $this->property('year');
		$this->EventsComp->linkpage = $this->property('linkpage');
		$this->EventsComp->category = $this->property('category', null);
		$this->EventsComp->usePermissions = $this->property('usePermissions', 0);
		if (!$this->property('month') || !$this->property('year')) {
			$this->EventsComp->dayspast = $this->property('dayspast', 120);
			$this->EventsComp->daysfuture = $this->property('daysfuture', 60);
		}
	}

	public function onRun() {
		$this->eventsCompEvents = $this->EventsComp->loadEvents();
	}

	public function onRender() {
		$this->renderFor('list');
		$this->events = $this->eventsCompEvents;
	}

	public function onShowEvent() {
		$this->EventsComp->compLink = 'ListEvents';
		return $this->page['ev'] = $this->EventsComp->onShowEvent();
	}
}
