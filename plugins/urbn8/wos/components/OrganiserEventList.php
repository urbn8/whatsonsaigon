<?php namespace Urbn8\Wos\Components;

use Auth;
use Flash;
use Response;
use View;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Urbn8\Wos\Models\Event as EventModel;
use Urbn8\Wos\Models\Organiser as OrganiserModel;

class OrganiserEventList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Organiser\'s Events List',
            'description' => 'Display organiser\'s events list.'
        ];
    }

    public function defineProperties()
    {
        return [
            'organiserId' => [
                'title'       => 'urbn8.wos::lang.components.organiser_event_list.organiser_id',
                'description' => 'urbn8.wos::lang.components.organiser_event_list.organiser_id_description',
                'required' => true,
                'type'        => 'string'
            ],
            'categoryFilter' => [
                'title'       => 'urbn8.wos::lang.components.organiser_event_list.category_filter',
                'description' => 'urbn8.wos::lang.components.organiser_event_list.category_filter_description',
                'default'     => 'category',
                'type'        => 'string'
            ],
            'noDataMessage' => [
                'title'        => 'urbn8.wos::lang.components.common.no_data_message',
                'description'  => 'urbn8.wos::lang.components.common.no_data_message_description',
                'type'         => 'string',
                'default'      => 'No data',
                'showExternalParam' => false,
                'group'       => 'Messages',
            ],
            'editPage' => [
                'title'       => 'urbn8.wos::lang.components.organiser_event_list.edit_page',
                'description' => 'urbn8.wos::lang.components.organiser_event_list.edit_page_description',
                'type'        => 'dropdown',
                'default'     => 'organiser',
                'group'       => 'Links',
            ],
        ];
    }

    public function getEditPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    { 
        if (!$this->user = Auth::getUser()) {
          return Response::make('Access denied!', 403);
        }

        $this->prepareVars();

        $this->events = $this->page['events'] = $this->loadEvents();
    }

    protected function prepareVars()
    {
        $this->noDataMessage = $this->page['noDataMessage'] = $this->property('noDataMessage');

        /*
         * Page links
         */
        $this->editPage = $this->page['editPage'] = $this->property('editPage');
    }

    public function loadEvents()
    {
      $user = Auth::getUser();

      $organiserId = $this->property('organiserId');

      $organiser = OrganiserModel::join('urbn8_wos_organiser_user', function ($join) use ($user) {
        $join->on('organiser_id', '=', 'id')
          ->where('user_id', '=', $user->id);
      })->findOrFail($organiserId);

      $categoryFilter = $this->property('categoryFilter');
      $categoryFilterValue = input($categoryFilter);

      $items = EventModel::where('organiser_id', $organiserId)->orderBy('created_at', 'desc');

      if ($categoryFilterValue) {
        $items = $items->join('urbn8_wos_business_events_categories', function ($join) use ($categoryFilterValue) {
          $join->on('urbn8_wos_business_events_categories.even_id', '=', 'id')
            ->where('category_id', '=', $categoryFilterValue);
        });
      }

      $items = $items->get();

      /*
        * Add a "url" helper attribute for linking to each post and category
        */
      $items->each(function($item) {
        $item->setEditUrl($this->property('editPage'), $this->controller);
      });

      return $items;
    }

    public function getStatusOptions()
    {
      return [
        0 => 'Inactive',
        1 => 'Active',
      ];
    }
}
