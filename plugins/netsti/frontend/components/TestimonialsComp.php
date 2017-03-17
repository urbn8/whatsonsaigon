<?php namespace NetSTI\Frontend\Components;

use Db;
use App;
use Request;
use \NetSTI\Frontend\Models\Testimonial as TestimonialModel;

class TestimonialsComp extends \Cms\Classes\ComponentBase{

	public function componentDetails()
	{
		return [
			'name'        => 'Testimonials',
			'description' => 'Show all published testimonials'
		];
	}

	public function defineProperties()
	{
		return [
			'limit' => [
				'title'       => 'Limit',
				'default'     => 5,
				'type'        => 'string'
			],
		];
	}

	public function onRun()
	{
		$this->testimonials = $this->page['testimonials'] = TestimonialModel::where('published', 1)->orderBy('date')->limit($this->property('limit'))->get();
	}
}
