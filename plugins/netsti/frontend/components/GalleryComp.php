<?php namespace NetSTI\Frontend\Components;

use Db;
use App;
use Request;
use \NetSTI\Frontend\Models\Gallery as GalleryModel;

class GalleryComp extends \Cms\Classes\ComponentBase{

	public $gallery;

	public function componentDetails()
	{
		return [
			'name'        => 'Gallery',
			'description' => 'Show Gallery Photos'
		];
	}

	public function defineProperties()
	{
		return [
			'gallery' => [
				'title'		=> 'Gallery',
				'type'		=> 'dropdown',
				'showExternalParam' => false,
			],
		];
	}

	public function onRun()
	{
		$slug = $this->property('gallery');
		$this->gallery = $this->page[$slug] = GalleryModel::whereSlug($slug)->first();
	}

	public function getGalleryOptions(){
		return GalleryModel::lists('title', 'slug');
	}
}
