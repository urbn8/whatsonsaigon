<?php namespace Urbn8\Wos\Components;

use Auth;
use Flash;
use Cms\Classes\ComponentBase;
use Urbn8\Wos\Models\Business as BusinessModel;
use Urbn8\Wos\Models\BusinessBranch as BusinessBranchModel;

class BusinessForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Business Form',
            'description' => 'Display business form.'
        ];
    }

    public function onRun()
    { 
        if (!$user = Auth::getUser()) {
          return Response::make('Access denied!', 403);
        }

        $this->page['business'] = $this->getUserBusiness();
    }

    public function getStatusOptions()
    {
      return [
        0 => 'Inactive',
        1 => 'Active',
      ];
    }

    public function getUserBusiness()
    {
      if ($this->userBusiness !== null) {
          return $this->userBusiness;
      }

      $user = Auth::getUser();
      if (!$user) {
          throw new ApplicationException('You should be logged in.');
      }

      $business = $user->businesses()->first(); 
      if (!$business) {
        $business = new BusinessModel([
          'name' => '',
        ]);

        $business->slugAttributes();

        $user->businesses()->save($business);
      }

      return $this->userBusiness = $business;
    }

    public function getUserDefaultBusinessBranch()
    {
      $business = $this->getUserBusiness();
      $branch = $business->branches()->first();

      if (!$branch) {
        $data = $business->toArray();
        unset($data['id']);
        $branch = new BusinessBranchModel($data);
        $branch->slugAttributes();
        $business->branches()->save($branch);
      }

      return $branch;
    }

    public function onSave() {
      try {
          if (!$user = Auth::getUser()) {
              throw new ApplicationException('You should be logged in.');
          }

          $business = $this->getUserBusiness();
          $this->getUserDefaultBusinessBranch();

          $business->update(post());

          Flash::success('flash from ajax handler');
          return $business;
      }
      catch (Exception $ex) {
          Flash::error($ex->getMessage());
      }
    }

    public function defineProperties()
    {
        return [
        ];
    }
}
