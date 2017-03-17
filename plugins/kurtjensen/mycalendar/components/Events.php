<?php namespace KurtJensen\MyCalendar\Components;

use Auth;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use KurtJensen\MyCalendar\Models\Category;
use KurtJensen\MyCalendar\Models\Occurrence as Ocurrs;
use KurtJensen\MyCalendar\Models\Settings;
use Lang;

class Events extends ComponentBase {
	use \KurtJensen\MyCalendar\Traits\MyCalComponentTraits;

	public $category;
	public $usePermissions = 0;
	public $dayspast = 0;
	public $daysfuture = 0;
	public $compLink = 'Events';
	public $user_id = null;
	public $linkpage = '';

	public function componentDetails() {
		return [
			'name' => 'kurtjensen.mycalendar::lang.events_comp.name',
			'description' => 'kurtjensen.mycalendar::lang.events_comp.description',
		];
	}

	public function defineProperties() {
		return $this->propertiesFor('events');
	}

	public function init() {
		$this->category = $this->property('category', null);
		$this->linkpage = $this->property('linkpage', '');

		$this->usePermissions = $this->property('usePermissions', 0);
		$this->dayspast = $this->property('dayspast', 0);
		$this->daysfuture = $this->property('daysfuture', 60);

		$this->month = in_array($this->property('month'), range(1, 12)) ? $this->property('month') : date('m');
		$this->year = in_array($this->property('year'), range(2014, 2030)) ? $this->property('year') : date('Y');
	}

	public function onRun() {
		$this->page['MyEvents'] = $this->loadEvents();
	}

	public function userId() {
		if (is_null($this->user_id)) {
			$user = Auth::getUser();
		}

		if ($user) {
			$this->user_id = $user->id;
		} else {
			$this->user_id = 0;
		}
		return $this->user_id;
	}

	public function loadEvents() {
		if ($this->daysfuture || $this->dayspast) {
			$month_start = new Carbon(date('Y/m/d') . ' 00:00:00');
			$month_end = $month_start->copy()->addDays($this->daysfuture);
			$month_start->subDays($this->dayspast);
		} else {
			$month_start = new Carbon($this->year . '/' . $this->month . '/1 00:00:00');
			$month_end = $month_start->copy()->addMonth(1);
		}

		$MyEvents = [];
		$timeFormat = Settings::get('time_format', 'g:i a');
		$relations = $this->property('relations', ['event']);

		$relation_name = $relations[0];

		$occurs = Ocurrs::with(
			array($relation_name => function ($query) {
				$query->withOwner()
					->published();

				if ($this->category) {
					$query->whereHas('categorys', function ($q) {
						$q->where('slug', $this->category);
					});
				}

				if ($this->usePermissions) {

					$query->permisions(
						$this->userId(),
						[Settings::get('public_perm')],
						Settings::get('deny_perm')
					);
				}
			})
		)->
			where('start_at', '<', $month_end)->
			where('end_at', '>=', $month_start)->
			//wher//('relation', $relation_name)->
			orderBy('start_at', 'ASC')->
			get();

		if (!$occurs) {
			return [];
		}

		$maxLen = $this->property('title_max', 100);

		foreach ($occurs as $occ) {
			if (!$occ->$relation_name) {
				continue;
			}

			$title = (strlen($occ->$relation_name->text) > 50) ? substr(strip_tags($occ->$relation_name->text), 0, $maxLen) . '...' : $occ->$relation_name->text;

			$link = $occ->$relation_name->link ?:
			($this->linkpage ?
				Page::url($this->linkpage, ['slug' => $occ->$relation_name->id]) :
				'#EventDetail"
            	data-request="onShowEvent"
            	data-request-data="evid:' . $occ->id . '"
            	data-request-update="\'' . $this->compLink . '::details\':\'#EventDetail\'" data-toggle="modal" data-target="#myModal');
			$time = $occ->is_allday ? '(' . Lang::get('kurtjensen.mycalendar::lang.occurrence.is_allday') . ')'
			: $occ->start_at->format($timeFormat);

			$MyEvents[$occ->start_at->year][$occ->start_at->month][$occ->start_at->day][] = [
				'name' => $occ->$relation_name->name . ' ' . $time,
				'title' => $title,
				'link' => $link,
				'id' => $occ->id,
				'owner' => $occ->$relation_name->user_id,
				'owner_name' => $occ->$relation_name->owner_name,
				'data' => $occ->$relation_name,
			];
		}
		return $MyEvents;

	}

	public function onShowEvent() {
		$e = false;

		$relations = $this->property('relations', ['event']);
		$relation_name = $relations[0];

		$ocurrs = Ocurrs::with(
			array($relation_name => function ($query) {
				$query->withOwner()
					->published();

				if ($this->category) {
					$query->whereHas('categorys', function ($q) {
						$q->where('slug', $this->category);
					});
				}

				if ($this->usePermissions) {

					$query->permisions(
						$this->userId(),
						[Settings::get('public_perm')],
						Settings::get('deny_perm')
					);
				}
			})
		)->
			find(post('evid'));

		if (!$ocurrs->$relation_name) {
			return $this->page['ev'] = ['name' => Lang::get('kurtjensen.mycalendar::lang.event.error_not_found'), 'cats' => []];
		}

		$timeFormat = Settings::get('time_format', 'g:i a');
		$dateFormat = Settings::get('date_format', 'F jS, Y');

		if ($this->property('raw_data', false)) {
			return $this->page['ev_data'] = [
				'ev' => $ocurrs->$relation_name,
				'oc' => $ocurrs,
				'format' => ['t' => $timeFormat, 'd' => $dateFormat],
			];
		} else {
			return $this->page['ev'] = [
				'name' => $ocurrs->$relation_name->name,
				'date' => $ocurrs->start_at->format($dateFormat),
				'time' => $ocurrs->is_allday ? Lang::get('kurtjensen.mycalendar::lang.occurrence.is_allday')
				: $ocurrs->start_at->format($timeFormat) . ' - ' . $ocurrs->end_at->format($timeFormat),
				'link' => $ocurrs->$relation_name->link ? $ocurrs->$relation_name->link : '',
				'text' => $ocurrs->$relation_name->text,
				'cats' => $ocurrs->$relation_name->categorys->lists('name'),
				'owner' => $ocurrs->$relation_name->user_id,
				'owner_name' => $ocurrs->$relation_name->owner_name,
				'data' => $ocurrs->$relation_name,
			];
		}
	}
}
