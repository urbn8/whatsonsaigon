<?php namespace Urbn8\Wos\Components;

use Auth;
use Flash;
use Response;
use View;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Urbn8\Wos\Models\Organiser as OrganiserModel;

class OrganiserList extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Organisers List',
            'description' => 'Display organisers list.'
        ];
    }

    public function defineProperties()
    {
        return [
            'categoryFilter' => [
                'title'       => 'urbn8.wos::lang.components.organiser_list.category_filter',
                'description' => 'urbn8.wos::lang.components.organiser_list.category_filter_description',
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
                'title'       => 'urbn8.wos::lang.components.organiser_list.edit_page',
                'description' => 'urbn8.wos::lang.components.organiser_list.edit_page_description',
                'type'        => 'dropdown',
                'default'     => 'organiser',
                'group'       => 'Links',
            ],
            'eventListPage' => [
                'title'       => 'urbn8.wos::lang.components.organiser_list.event_list_page',
                'description' => 'urbn8.wos::lang.components.organiser_list.event_list_description',
                'type'        => 'dropdown',
                'default'     => 'events',
                'group'       => 'Links',
            ],
        ];
    }

    public function getEditPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getEventListPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    { 
        if (!$this->user = Auth::getUser()) {
          return Response::make('Access denied!', 403);
        }

        $this->prepareVars();

        $this->organisers = $this->page['organisers'] = $this->loadOrganisers();
    }

    protected function prepareVars()
    {
        $this->noDataMessage = $this->page['noDataMessage'] = $this->property('noDataMessage');

        /*
         * Page links
         */
        $this->editPage = $this->page['editPage'] = $this->property('editPage');
    }

    public function loadOrganisers()
    {
      $user = Auth::getUser();

      $categoryFilter = $this->property('categoryFilter');
      $categoryFilterValue = input($categoryFilter);

      $items = OrganiserModel::join('urbn8_wos_organiser_user', function ($join) use ($user) {
        $join->on('organiser_id', '=', 'id')
          ->where('user_id', '=', $user->id);
      })->orderBy('created_at', 'desc');

      if ($categoryFilterValue) {
        $items = $items->join('urbn8_wos_organiser_o_category', function ($join) use ($categoryFilterValue) {
          $join->on('urbn8_wos_organiser_o_category.organiser_id', '=', 'id')
            ->where('o_category_id', '=', $categoryFilterValue);
        });
      }

      $items = $items->get();

      /*
        * Add a "url" helper attribute for linking to each post and category
        */
      $items->each(function($item) {
        $item->setUrl($this->property('editPage'), $this->controller);
        $item->setEventUrl($this->property('eventListPage'), $this->controller);
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
