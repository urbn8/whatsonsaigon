<?php namespace Urbn8\Wos;

use Event;
use Log;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function boot()
    {
        Event::listen('eloquent.created: RainLab\User\Models\User', function ($user) {
            Log::info('User created: '.$user->email);
        });
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }
}
