<?php namespace NetSTI\Frontend;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase{

	// DETAILS
	public function pluginDetails(){
		return [
			'name' => 'netsti.frontend::lang.plugin.name',
			'description' => 'netsti.frontend::lang.plugin.description',
			'author' => 'NetSTI',
			'icon' => 'icon-sliders',
			'homepage' => 'http://netsti.com/plugins',
		];
	}

	// PERMISSIONS
	public function registerPermissions(){
		return [
			'netsti.frontend.strings' => [
				'tab' => 'netsti.frontend::lang.menu.frontend',
				'label' => 'netsti.frontend::lang.menu.strings',
			],
			'netsti.frontend.testimonials' => [
				'tab' => 'netsti.frontend::lang.menu.frontend',
				'label' => 'netsti.frontend::lang.menu.testimonials',
			],
			'netsti.frontend.galleries' => [
				'tab' => 'netsti.frontend::lang.menu.frontend',
				'label' => 'netsti.frontend::lang.menu.galleries',
			],
			'netsti.frontend.articles' => [
				'tab' => 'netsti.frontend::lang.menu.frontend',
				'label' => 'netsti.frontend::lang.menu.articles',
			],
			'netsti.frontend.packages' => [
				'tab' => 'netsti.frontend::lang.menu.frontend',
				'label' => 'netsti.frontend::lang.menu.packages',
			],
			// 'netsti.frontend.access_import_export' => [
			// 	'tab' => 'netsti.frontend::lang.menu.frontend',
			// 	'label' => 'netsti.frontend::lang.menu.import_export',
			// ],
		];
	}

	// MENU AND NAVIGATIONS
	public function registerNavigation(){
		return [
			'frontend' => [
				'label' => 'netsti.frontend::lang.menu.frontend',
				'url' => Backend::url('netsti/frontend/frontend'),
				'icon' => 'icon-sliders',
				'iconSvg'=> 'plugins/netsti/frontend/assets/img/icon.svg',
				'order' => '101',
				'sideMenu' => [
					'articles' => [
						'label' => 'netsti.frontend::lang.menu.articles',
						'url' => Backend::url('netsti/frontend/articles'),
						'icon' => 'icon-newspaper-o',
						'permissions' => ['netsti.frontend.articles']
					],
					'galleries' => [
						'label' => 'netsti.frontend::lang.menu.galleries',
						'url' => Backend::url('netsti/frontend/galleries'),
						'icon' => 'icon-camera-retro',
						'permissions' => ['netsti.frontend.galleries']
					],
					'popups' => [
						'label' => 'netsti.frontend::lang.menu.popups',
						'url' => Backend::url('netsti/frontend/popups'),
						'icon' => 'icon-clone',
						'permissions' => ['netsti.frontend.galleries']
					],
					'testimonials' => [
						'label' => 'netsti.frontend::lang.menu.testimonials',
						'url' => Backend::url('netsti/frontend/testimonials'),
						'icon' => 'icon-comments-o',
						'permissions' => ['netsti.frontend.testimonials']
					],
					'strings' => [
						'label' => 'netsti.frontend::lang.menu.strings',
						'url' => Backend::url('netsti/frontend/strings'),
						'icon' => 'icon-language',
						'permissions' => ['netsti.frontend.strings']
					],
					// 'packages' => [
					// 	'label' => 'netsti.frontend::lang.menu.packages',
					// 	'url' => Backend::url('netsti/frontend/packages'),
					// 	'icon' => 'icon-cubes',
					// 	'permissions' => ['netsti.frontend.packages']
					// ],
				]
			]
		];
	}

	// REGISTER FORM WIDGETS
	public function registerFormWidgets(){
		return [
			'NetSTI\Frontend\FormWidgets\RelationForm' => [
				'label' => 'Relation',
				'code'  => 'relationform'
			],
		];
	}

	// COMPONENTS
	public function registerComponents(){
		return [
			'NetSTI\Frontend\Components\Strings' => 'tranlatableStrings',
			'NetSTI\Frontend\Components\PopUps' => 'popUp',
			'NetSTI\Frontend\Components\ArticleComp' => 'articleElement',
			'NetSTI\Frontend\Components\ArticlesList' => 'articlesList',
			'NetSTI\Frontend\Components\Categories' => 'categoriesList',
			// 'NetSTI\Frontend\Components\Bower' => 'dependencies',
			'NetSTI\Frontend\Components\TestimonialsComp' => 'testimonialsList',
			'NetSTI\Frontend\Components\GalleryComp' => 'galleryComponent',
		];
	}

	public function registerPageSnippets()
	{
		return [
			'NetSTI\Frontend\Components\GalleryComp' => 'galleryComponent'
		];
	}

	// ON BOOT
	public function boot(){
		
	}

	// SETTINGS
	public function registerSettings(){
		return [
			'packages' => [
				'label'       => 'netsti.frontend::lang.packages',
				'description' => 'netsti.frontend::lang.packages_description',
				'icon'        => 'icon-cubes',
				'class'       => 'NetSTI\Frontend\Models\PackagesSettings',
				'category'    => 'netsti.connections::lang.manage',
				'order'       => 106,
				'keywords'    => 'crm customer relationship management packages'
			],
		];	
	}
}
