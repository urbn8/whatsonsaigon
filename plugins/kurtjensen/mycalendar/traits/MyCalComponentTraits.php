<?php namespace KurtJensen\MyCalendar\Traits;

/**
 * MyCalComponentTraits
 * Consolidated Component Properties and Functions for easier reuse and
 * easier code management.
 *
 * @package kurtjensen\mycalendar
 * @author Kurt Jensen
 */
use Carbon\Carbon;
use Cms\Classes\Page;
use KurtJensen\MyCalendar\Models\Occurrence as Ocurrs;
use Lang;

trait MyCalComponentTraits {
	// Week
	public $day;

	// Month - Week
	public $month;
	public $year;
	public $weekstart;
	public $dayprops;
	// ---  Calc Vars
	public $calHeadings;
	public $monthNum;
	public $running_day;
	public $days_in_month;
	public $dayPointer;
	public $prevMonthLastDay;
	public $prevMonthStartDay;
	public $monthTitle;
	public $linkNext;
	public $linkPrevious;

	// Month - Week - List
	public $color;
	public $events;

	public $langPath = 'kurtjensen.mycalendar::lang.';

	public function propertiesFor($type) {
		$properties = [];
		switch ($type) {
		case 'events':
			$properties = [
				'linkpage' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.linkpage_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.linkpage_desc',
					'type' => 'dropdown',
					//'options' => $this->getpageOptions(),
					'default' => '',
					'group' => 'kurtjensen.mycalendar::lang.events_comp.linkpage_group',
				],
				'title_max' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.title_max_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.title_max_description',
					'default' => 100,
				],
				'usePermissions' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.permissions_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.permissions_description',
					'type' => 'dropdown',
					'default' => 0,
					'options' => [
						0 => 'kurtjensen.mycalendar::lang.events_comp.opt_no',
						1 => 'kurtjensen.mycalendar::lang.events_comp.opt_yes',
					],
				],
				'category' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.category_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.category_description',
					'default' => '{{ :cat }}',
				],
				'month' => [
					'title' => 'kurtjensen.mycalendar::lang.month.month_title',
					'description' => 'kurtjensen.mycalendar::lang.month.month_description',
					'default' => '{{ :month }}',
				],
				'year' => [
					'title' => 'kurtjensen.mycalendar::lang.month.year_title',
					'description' => 'kurtjensen.mycalendar::lang.month.year_description',
					'default' => '{{ :year }}',
				],
				'dayspast' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.past_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.past_description',
					'default' => 0,
				],
				'daysfuture' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.future_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.future_description',
					'default' => 60,
				],
				'relations' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.relations_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.relations_description',
					'type' => 'set',
					'items' => $this->getRelationItems(),
					'default' => ['event'],
				],
				'raw_data' => [
					'title' => 'kurtjensen.mycalendar::lang.events_comp.raw_data_title',
					'description' => 'kurtjensen.mycalendar::lang.events_comp.raw_data_description',
					'type' => 'dropdown',
					'default' => 0,
					'options' => [
						0 => 'kurtjensen.mycalendar::lang.events_comp.opt_no',
						1 => 'kurtjensen.mycalendar::lang.events_comp.opt_yes',
					],
				],
			];

			return $properties;
			break;
		case 'week':
			$properties = [
				// Week
				'day' => [
					'title' => $this->langPath . 'com_prop_trait.day_title',
					'description' => $this->langPath . 'com_prop_trait.day_description',
					'default' => '{{ :day }}',
				],
			];
		case 'month':
			$properties = array_merge($properties,
				[
					// Month - Week
					'month' => [
						'title' => $this->langPath . 'com_prop_trait.month_title',
						'description' => $this->langPath . 'com_prop_trait.month_description',
						'default' => '{{ :month }}',
					],
					'year' => [
						'title' => $this->langPath . 'com_prop_trait.year_title',
						'description' => $this->langPath . 'com_prop_trait.year_description',
						'default' => '{{ :year }}',
					],
					'weekstart' => [
						'title' => $this->langPath . 'com_prop_trait.weekstart_title',
						'description' => $this->langPath . 'com_prop_trait.weekstart_description',
						'type' => 'dropdown',
						'default' => '0',
					],
					'dayprops' => [
						'title' => $this->langPath . 'com_prop_trait.dayprops_title',
						'description' => $this->langPath . 'com_prop_trait.dayprops_description',
					],
				]);
		case 'list':
			$properties = array_merge($properties,
				[
					// Month - Week - List
					'events' => [
						'title' => $this->langPath . 'com_prop_trait.events_title',
						'description' => $this->langPath . 'com_prop_trait.events_description',
					],
					'color' => [
						'title' => $this->langPath . 'com_prop_trait.color_title',
						'description' => $this->langPath . 'com_prop_trait.color_description',
						'type' => 'dropdown',
						'default' => 'red',
					],
					'loadstyle' => [
						'title' => $this->langPath . 'com_prop_trait.loadstyle_title',
						'description' => $this->langPath . 'com_prop_trait.loadstyle_description',
						'type' => 'dropdown',
						'default' => '1',
						'options' => [
							0 => $this->langPath . 'com_prop_trait.opt_no',
							1 => $this->langPath . 'com_prop_trait.opt_yes',
						],
					],
				]);
		}
		return $properties;
	}

	public function initFor($type) {
		switch ($type) {
		case 'week':
		case 'month':
			$this->weekstart = $this->property('weekstart', 0);
		case 'list':
			if ($this->property('loadstyle')) {
				$this->addCss('/plugins/kurtjensen/mycalendar/assets/css/calendar.css');
			}
			$this->color = $this->property('color');
		}
	}

	public function renderFor($type) {
		switch ($type) {
		case 'week':
			// Must use onRender() for properties that can be modified in page
			$this->day = $this->property('day') ?: date('d');

		case 'month':
			$y_start = date('Y') - 2;
			$y_end = $y_start + 15;

			$this->month = in_array($this->property('month'), range(1, 12)) ? $this->property('month') : date('m');

			$this->year = in_array($this->property('year'), range($y_start, $y_end)) ? $this->property('year') : date('Y');

			$this->calHeadings = $this->getWeekstartOptions();

			$this->calcElements();

			$this->dayprops = $this->property('dayprops') ?: [];

		case 'list':
			$this->events = $this->property('events') ?: [];
		}

	}

	public function calcElementsFor($type) {
		switch ($type) {
		case 'week':
			$time = new Carbon($this->year . '-' . $this->month . '-' . $this->day);
			$this->monthTitle = Lang::get('kurtjensen.mycalendar::lang.rrule.month.' . $time->month); // Nov
			break;
		case 'month':
			$time = new Carbon($this->month . '/1/' . $this->year); // 11/01/2016
			$this->monthTitle = Lang::get('kurtjensen.mycalendar::lang.rrule.month.' . $time->month); // Nov
			break;
		}

		$this->monthNum = $time->month;
		$this->running_day = $time->dayOfWeek;
		$this->days_in_month = $time->daysInMonth;

		switch ($type) {
		case 'week':
			$this->dayPointer = $this->day - $this->running_day - $this->weekstart - 1;
			break;
		case 'month':
			$this->dayPointer = $this->weekstart - $this->running_day; // 1 - 2 = -1
			break;
		}

		$prevMonthLastDay = $time->copy()->subMonth()->daysInMonth;

		$this->prevMonthStartDay = $this->dayPointer + $prevMonthLastDay + 1;
		return $time;
	}

	public function getMonthYear($offset) {
		$month = $this->month + $offset;
		$year = $this->year;
		if ($month == 13) {
			$year++;
			$month = 1;
		}
		if ($month == -1) {
			$year--;
			$month = 12;
		}
		return [$month, $year];
	}

	public function monthEvents($offset = 0) {
		list($month, $year) = $this->getMonthYear($offset);

		if (array_key_exists($year, $this->events)) {
			$yrEvents = $this->events[$year];
			if (array_key_exists($month, $yrEvents)) {
				return $yrEvents[$month];
			}
		}
		return [];
	}

	public function monthProperties($offset = 0) {
		list($month, $year) = $this->getMonthYear($offset);

		if (array_key_exists($year, $this->dayprops)) {
			$yrProps = $this->dayprops[$year];
			if (array_key_exists($month, $yrProps)) {
				return $yrProps[$month];
			}
		}
		return [];
	}

	public function trans($string) {
		return Lang::get($string);
	}

	public function getLinkpageOptions() {
		return ['' => Lang::get('kurtjensen.mycalendar::lang.events_comp.linkpage_opt_none')] +
		Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
	}

	public function getRelationItems() {
		$occ = new Ocurrs();
		foreach ($occ->belongsTo as $key => $rel) {
			$options[$key] = $rel[0];
		}

		return $options;
	}

	public function getColorOptions() {
		$colors = [
			'red' => Lang::get($this->langPath . 'com_prop_trait.color_red'),
			'green' => Lang::get($this->langPath . 'com_prop_trait.color_green'),
			'blue' => Lang::get($this->langPath . 'com_prop_trait.color_blue'),
			'yellow' => Lang::get($this->langPath . 'com_prop_trait.color_yellow'),
		];
		return $colors;
	}

	public function getWeekstartOptions() {
		return [
			Lang::get($this->langPath . 'com_prop_trait.day_sun'),
			Lang::get($this->langPath . 'com_prop_trait.day_mon'),
			Lang::get($this->langPath . 'com_prop_trait.day_tue'),
			Lang::get($this->langPath . 'com_prop_trait.day_wed'),
			Lang::get($this->langPath . 'com_prop_trait.day_thu'),
			Lang::get($this->langPath . 'com_prop_trait.day_fri'),
			Lang::get($this->langPath . 'com_prop_trait.day_sat'),
		];
	}
}
