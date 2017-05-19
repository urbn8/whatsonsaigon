<?php namespace Urbn8\Wos\Components;

use Log;
use Auth;
use Flash;
use Response;
use Request;
use View;
use Input;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Urbn8\Wos\Models\Organiser as OrganiserModel;
use Urbn8\Wos\Models\OrganiserCategory as CategoryModel;

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
            'id' => [
                'title'       => 'urbn8.wos::lang.common.modeldataform.id',
                'description' => 'urbn8.wos::lang.common.modeldataform.id_description',
                'default'     => '{{ :id }}',
                'type'        => 'string'
            ],
            'organiserListPage' => [
                'title'       => 'urbn8.wos::lang.components.organiser_list.edit_page',
                'description' => 'urbn8.wos::lang.components.organiser_list.edit_page_description',
                'type'        => 'dropdown',
                'default'     => 'organiser',
                'group'       => 'Links',
            ],
        ];
    }

    public function getOrganiserListPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
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

        $this->organiserListPage = $this->page['organiserListPage'] = $this->property('organiserListPage');
    }

    public function getStatusOptions()
    {
      return [
        0 => 'Inactive',
        1 => 'Active',
      ];
    }

    public function getCategoryOptions()
    {
      return CategoryModel::all()->toArray();
    }

    public function loadOrganiser($slug)
    {
      $user = Auth::getUser();
      if (!$user) {
          throw new ApplicationException('You should be logged in.');
      }

      $organiser = new OrganiserModel;
      $organiser = $organiser->isClassExtendedWith('RainLab.Translate.Behaviors.TranslatableModel')
        ? $user->organisers()->transWhere('slug', $slug)
        : $user->organisers()->where('slug', $slug);

      $organiser = $organiser->with('categories')->with('logo');
      
      $organiser = $organiser->first();

      if (!$organiser) {
        // https://octobercms.com/forum/post/returning-404-from-a-component
        return \Response::make($this->controller->run('404'), 404);
      }

      return $organiser;
    }

    private function update() {

    }

    private function handleCreate() {

      if (!$user = Auth::getUser()) {
        throw new ApplicationException('You should be logged in.');
      }

      $organiser = new OrganiserModel(post());
      $organiser->slugAttributes();

      if (Input::file('logo')) {
        $organiser->logo = Input::file('logo');
      }

      $user->organisers()->save($organiser);

      if (post('category_id')) {
        $organiser->categories()->attach(post('category_id'));
      }

      Flash::success('organiser created successfully!');

      if (Request::ajax()) {
        return [
            '#flashmessage' => $this->renderPartial('@flashmessage'),
            'data' => $organiser,
        ];
      }
    }

    private function handleUpdate() {
      if (!$user = Auth::getUser()) {
        throw new ApplicationException('You should be logged in.');
      }

      $slug = $this->property('slug');

      $organiser = $this->loadOrganiser($slug);
      $organiser->fill(post());
      $organiser->slug = null;
      $organiser->slugAttributes();

      if (Input::file('logo')) {
        $organiser->logo = Input::file('logo');
      }

      $organiser->save();

      $organiser->categories()->detach();
      if (post('category_id')) {
        $organiser->categories()->attach(post('category_id'));
      }

      // dd(post('logo'));
      // if (post('logo')) {
      // Log::info(var_export(Input::all(), true));
      
      // }

      Flash::success('organiser updated successfully!');

      if (Request::ajax()) {
        return [
            '#flashmessage' => $this->renderPartial('@flashmessage'),
            'data' => $organiser,
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
          return $this->handleUpdate();
        }

        return $this->handleCreate();
      }
      catch (Exception $ex) {
          Flash::error($ex->getMessage());
      }
    }
}
