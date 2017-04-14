<?php namespace Urbn8\Wos\Components;

use Auth;
use Flash;
use Response;
use View;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Urbn8\Wos\Models\Organiser as OrganiserModel;
use Urbn8\Wos\Models\OCategory as CategoryModel;

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
      $items = CategoryModel::all()->toArray();
      return $items;

      // $arr = array_reduce(
      //   $items,
      //   function(&$result, $item) {
      //     $result[$item->id] = $item->name;
      //     return $result;
      //   },
      //   array()
      // );

      // dd($arr);
      // return [];
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

      $organiser = $organiser->first();

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

        $slug = $this->property('slug');
        if ($slug) {
          $organiser = $this->loadOrganiser($slug);
          $organiser->fill(post());
          $organiser->slug = null;
          $organiser->slugAttributes();
          $organiser->save();

          Flash::success('organiser updated successfully!');
          return [
              '#flashmessage' => $this->renderPartial('@flashmessage'),
              'data' => $organiser,
          ];
        }

        $organiser = new OrganiserModel(post());
        $organiser->slugAttributes();
        $user->organisers()->save($organiser);

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
