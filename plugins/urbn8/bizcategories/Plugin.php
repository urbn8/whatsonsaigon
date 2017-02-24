<?php namespace Urbn8\BizCategory;

use Backend;
use Controller;
use System\Classes\PluginBase;

/**
 * BizCategory Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'urbn8.bizcategories::lang.plugin.name',
            'description' => 'urbn8.bizcategories::lang.plugin.description',
            'author'      => 'Urbn8',
            'icon'        => 'icon-list-alt'
        ];
    }

    /**
     * Create the navigation items for this plugin
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'bizcategories' => [
                'label'    => 'urbn8.bizcategories::lang.menu.name',
                'url'      => Backend::url('urbn8/bizcategories/menus'),
                'icon'     => 'icon-list-alt',
                'permissions' => ['urbn8.bizcategories.*'],
                'order'    => 500,
                'sideMenu' => [
                    'edit'    => [
                        'label' => 'urbn8.bizcategories::lang.menu.editmenu',
                        'icon'  => 'icon-list-alt',
                        'url'   => Backend::url('urbn8/bizcategories/menus'),
                        'permissions' => ['urbn8.bizcategories.access_bizcategories']
                    ],
                    'reorder' => [
                        'label' => 'urbn8.bizcategories::lang.menu.reordermenu',
                        'icon'  => 'icon-exchange',
                        'url'   => Backend::url('urbn8/bizcategories/menus/reorder'),
                        'permissions' => ['urbn8.bizcategories.access_bizcategories']
                    ]
                ]
            ]
        ];
    }

    public function registerPermissions()
    {
        return array(
            'urbn8.bizcategories.access_bizcategories' => ['label' => 'Manage categories', 'tab' => 'BizCategory']
        );
    }

    /**
     * Register the front end component
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            '\Urbn8\BizCategory\Components\Menu' => 'menu',
        ];
    }

}
