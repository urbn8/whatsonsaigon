<?php namespace Urbn8\Wos\Components;

use Auth;
use Flash;
use Response;
use View;
use Input;
use Request;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Urbn8\Wos\Models\Organiser as OrganiserModel;
use Urbn8\Wos\Models\Event as EventModel;

class OrganiserEventForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Organiser Event Form',
            'description' => 'Display organiser event form.'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'urbn8.wos::lang.common.modeldataform.slug',
                'description' => 'urbn8.wos::lang.common.modeldataform.slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'organiser_id' => [
                'title'       => 'urbn8.wos::lang.common.organiser_event_list.organiser_id',
                'description' => 'urbn8.wos::lang.common.organiser_event_list.organiser_id_description',
                'default'     => '{{ :organiser_id }}',
                'type'        => 'string'
            ],
            'organiserEventListPage' => [
                'title'       => 'urbn8.wos::lang.components.organiser_event_list.edit_page',
                'description' => 'urbn8.wos::lang.components.organiser_event_list.edit_page_description',
                'type'        => 'dropdown',
                'default'     => 'organiser',
                'group'       => 'Links',
            ],
        ];
    }

    public function getOrganiserEventListPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    { 
        if (!$user = Auth::getUser()) {
          return Response::make('Access denied!', 403);
        }

        $this->loadOrganiser();

        $slug = $this->property('slug');
        if ($slug) {
          $this->event = $this->page['event'] = $this->loadEvent($slug);
        }

        $this->organiserEventListPage = $this->page['organiserEventListPage'] = $this->property('organiserEventListPage');
    }

    public function getStatusOptions()
    {
      return [
        0 => 'Inactive',
        1 => 'Active',
      ];
    }

    public function loadEvent($slug)
    {
      $user = Auth::getUser();
      if (!$user) {
          throw new ApplicationException('You should be logged in.');
      }

      $item = EventModel::with('thumbnail')->findOrFail($slug);

      if (!$item) {
        // https://octobercms.com/forum/post/returning-404-from-a-component
        return \Response::make($this->controller->run('404'), 404);
      }

      return $item;
    }

    public function loadOrganiser()
    {
      $user = Auth::getUser();
      if (!$user) {
          throw new ApplicationException('You should be logged in.');
      }

      $organiserId = $this->property('organiser_id');

      $organiser = OrganiserModel::join('urbn8_wos_organiser_user', function ($join) use ($user) {
        $join->on('organiser_id', '=', 'id')
          ->where('user_id', '=', $user->id);
      })->findOrFail($organiserId);

      if (!$organiser) {
        // https://octobercms.com/forum/post/returning-404-from-a-component
        return \Response::make($this->controller->run('404'), 404);
      }

      return $organiser;
    }

    private function onUpdate() {
      $slug = $this->property('slug');
      $item = $this->loadEvent($slug);
      $item->fill(post());
      $item->slug = null;
      $item->slugAttributes();

      if (Input::file('thumbnail')) {
        $item->thumbnail = Input::file('thumbnail');
      }

      $item->save();

      Flash::success('event updated successfully!');

      if (Request::ajax()) {
        return [
            '#flashmessage' => $this->renderPartial('@flashmessage'),
            'data' => $item,
        ];
      }
    }

    private function onCreate() {
      $organiser = $this->loadOrganiser();

      $item = new EventModel(post());
      $item->slugAttributes();

      if (Input::file('thumbnail')) {
        $item->thumbnail = Input::file('thumbnail');
      }

      $organiser->events()->save($item);

      Flash::success('event created successfully!');

      if (Request::ajax()) {
        return [
            '#flashmessage' => $this->renderPartial('@flashmessage'),
            'data' => $item,
        ];
      }
    }

    public function onSave() {
      try {
        if (!$user = Auth::getUser()) {
          throw new ApplicationException('You should be logged in.');
        }

        $slug = $this->property('slug');
        if ($slug) {
          return $this->onUpdate();
        }

        return $this->onCreate();
      }
      catch (Exception $ex) {
        Flash::error($ex->getMessage());
      }
    }
}
