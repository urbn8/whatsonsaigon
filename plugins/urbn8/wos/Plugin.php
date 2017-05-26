<?php namespace Urbn8\Wos;

use Event;
use Log;
use DB;
use System\Classes\PluginBase;

Use RainLab\User\Models\User;

class Plugin extends PluginBase
{

    /**
     * @var array Plugin dependencies
     */
    public $require = ['Rainlab.User', 'Vdomah.JWTAuth'];

    public function boot()
    {
        User::extend(function($model) {
            $model->addDynamicMethod('scopeOrphan', function($query) {
                return $query->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('urbn8_wos_organiser_user_joins')
                        ->whereRaw('urbn8_wos_organiser_user_joins.user_id = users.id');
                });
            });

            $model->belongsToMany['organisers'] = [
                'Urbn8\Wos\Models\Organiser',
                'table' => 'urbn8_wos_organiser_user_joins',
            ];
        });

        Event::listen('eloquent.created: RainLab\User\Models\User', function ($user) {
            Log::info('User created: '.$user->email);
        });
    }

    public function registerComponents()
    {
        return [
            'Urbn8\Wos\Components\EventForm' => 'EventForm',
            'Urbn8\Wos\Components\OrganiserForm' => 'OrganiserForm',
            'Urbn8\Wos\Components\OrganiserList' => 'OrganiserList',
            'Urbn8\Wos\Components\OrganiserEventList' => 'OrganiserEventList',
            'Urbn8\Wos\Components\OrganiserEventForm' => 'OrganiserEventForm',
        ];
    }

    public function registerSettings()
    {
    }
}
