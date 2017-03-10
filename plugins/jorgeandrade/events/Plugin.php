<?php namespace JorgeAndrade\Events;

use Cms\Classes\Controller;
use Event;
use System\Classes\PluginBase;

/**
 * Events Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Adds date translation to the plugin
     */
    public function boot()
    {
        Event::Listen('cms.page.beforeDisplay', function (Controller $controller, $url, $page) {
            if (extension_loaded('intl')) {
                $twigIntlExtension = new \Twig_Extensions_Extension_Intl();

                if (!$controller->getTwig()->hasExtension($twigIntlExtension->getName())) {
                    $controller->getTwig()->addExtension($twigIntlExtension);
                }
            }
        });
    }

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Calendar Events',
            'description' => 'Manage properly your own events',
            'author' => 'Jorge Andrade',
            'icon' => 'icon-calendar',
            'homepage' => 'http://andradedev.com',
        ];
    }

    public function registerComponents()
    {
        return [
            'JorgeAndrade\Events\Components\EventList' => 'eventList',
            'JorgeAndrade\Events\Components\Event' => 'event',
        ];
    }

    public function registerPermissions()
    {
        return [
            'jorgeandrade.events.access_events' => [
                'label' => 'Manage the events',
                'tab' => 'Events',
            ],
            'jorgeandrade.events.access_calendars' => [
                'label' => 'Manage the calendars',
                'tab' => 'Events',
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'events' => [
                'label' => 'Events',
                'url' => \Backend::url('jorgeandrade/events/events'),
                'icon' => 'icon-calendar',
                'permissions' => ['jorgeandrade.events.*'],
                'order' => 200,

                'sideMenu' => [
                    'events' => [
                        'label' => 'Events',
                        'icon' => 'icon-list',
                        'url' => \Backend::url('jorgeandrade/events/events'),
                        'permissions' => ['jorgeandrade.events.access_events'],
                    ],
                    'calendars' => [
                        'label' => 'Calendars',
                        'icon' => 'icon-calendar',
                        'url' => \Backend::url('jorgeandrade/events/calendars'),
                        'permissions' => ['jorgeandrade.events.access_calendars'],
                    ],
                ],

            ],
        ];
    }

}
