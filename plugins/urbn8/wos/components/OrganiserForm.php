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
            'slug' => [
                'title'       => 'urbn8.wos::lang.common.modeldataform.slug',
                'description' => 'urbn8.wos::lang.common.modeldataform.slug_description',
                'default'     => '{{ :slug }}',
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

    public function loadOrganiser($slug)
    {
      $user = Auth::getUser();
      if (!$user) {
          throw new ApplicationException('You should be logged in.');
      }

      $organiser = $user->organisers()->where('slug', $slug)->first();
      if (!$organiser) {
        // https://octobercms.com/forum/post/returning-404-from-a-component
        return \Response::make($this->controller->run('404'), 404);
      }

      return $organiser;
    }

    public function onSave() {
      try {
          if (!$user = Auth::getUser()) {
              throw new ApplicationException('You should be logged in.');
          }

          $organiser = $user->organisers()->first(); 
          if (!$organiser) {
            $organiser = new OrganiserModel(post());
            $user->organisers()->save($organiser);
          } else {
            $organiser->fill(post());
            $organiser->slugAttributes();
            $organiser->save();
          }

          Flash::success('organiser created successfully!');
          return [
              '#flashmessage' => $this->renderPartial('@flashmessage'),
              'data' => $organiser,
          ];
      }
      catch (Exception $ex) {
          Flash::error($ex->getMessage());
      }
    }
}
