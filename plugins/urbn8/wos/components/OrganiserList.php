<?php namespace Urbn8\Wos\Components;

use Auth;
use Flash;
use Response;
use View;
use Cms\Classes\ComponentBase;
use Urbn8\Wos\Models\Organiser as OrganiserModel;

class OrganiserForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Organiser Form',
            'description' => 'Display organiser form.'
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
        ];
    }

    public function onRun()
    { 
        if (!$user = Auth::getUser()) {
          return Response::make('Access denied!', 403);
        }

        $slug = $this->property('slug');
        if ($slug) {
          $this->organiser = $this->page['organiser'] = $this->loadOrganiser($slug);
        }
    }

    public function getStatusOptions()
    {
      return [
        0 => 'Inactive',
        1 => 'Active',
      ];
    }
}
