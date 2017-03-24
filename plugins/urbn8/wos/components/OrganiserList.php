<?php namespace Urbn8\Wos\Components;

use Auth;
use Flash;
use Response;
use View;
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
                'default'     => '',
                'type'        => 'string'
            ],
            'noDataMessage' => [
                'title'        => 'urbn8.wos::lang.components.common.no_data_message',
                'description'  => 'urbn8.wos::lang.components.common.no_data_message_description',
                'type'         => 'string',
                'default'      => 'No data',
                'showExternalParam' => false
            ],
        ];
    }

    public function onRun()
    { 
        if (!$this->user = Auth::getUser()) {
          return Response::make('Access denied!', 403);
        }

        $this->noDataMessage = $this->page['noDataMessage'] = $this->property('noDataMessage');

        $this->organisers = $this->page['organisers'] = $this->loadOrganisers();
    }

    public function loadOrganisers()
    {
      $organisers = OrganiserModel::all()->sortByDesc('created_at');
      // dd($organisers);
      // $organisers = OrganiserModel::orderBy('created_at', 'desc')->get();
      // $organisers = OrganiserModel::all();
      return $organisers;
    }

    public function getStatusOptions()
    {
      return [
        0 => 'Inactive',
        1 => 'Active',
      ];
    }
}
