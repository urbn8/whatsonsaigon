<?php namespace NetSTI\Frontend\Components;

use Cms\Classes\Page;
use Cms\Classes\Theme;
use Cms\Classes\ComponentBase;
use NetSTI\Frontend\Models\Visit;
use NetSTI\Frontend\Models\Article as BlogPost;

class ArticleComp extends ComponentBase{
	
	public $post;
	public $thisPage;
	public $categoryPage;

	public function componentDetails()
	{
		return [
			'name'        => 'netsti.frontend::lang.settings.post_title',
			'description' => 'netsti.frontend::lang.settings.post_description'
		];
	}

	public function defineProperties()
	{
		return [
			'slug' => [
				'title'       => 'netsti.frontend::lang.settings.post_slug',
				'description' => 'netsti.frontend::lang.settings.post_slug_description',
				'default'     => '{{ :slug }}',
				'type'        => 'string'
			],
			'categoryPage' => [
				'title'       => 'netsti.frontend::lang.settings.category_page',
				'description' => 'netsti.frontend::lang.settings.category_page_description',
				'type'        => 'dropdown',
				'default'     => 'blog',
			],
		];
	}

	public function getCategoryPageOptions()
	{
		return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
	}

	public function onRun()
	{
		$this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
		$this->post = $this->page['post'] = $this->loadPost();

		$theme = Theme::getActiveTheme();
		$page = Page::load($theme,$this->page->baseFileName);
		$this->thisPage = $this->page->baseFileName;

		if($this->post){
			$this->controller->pageTitle = $this->post->title;

			$viewed = $this->listMostViewedPosts();
			$related = $this->listMostRelatedPosts($this->post->categories->lists('id'));

			$viewed->each(function($post) {
				$post->setUrl($this->postPage, $this->controller);
			});

			$related->each(function($post) {
				$post->setUrl($this->postPage, $this->controller);
			});

			$this->page['mostViewedArticles'] = $viewed;
			$this->page['mostRelatedArticles'] = $related;
		}

		$this->addCss('/plugins/netsti/frontend/assets/css/post.css');
	}

	protected function loadPost()
	{
		$slug = $this->property('slug');
		$post = BlogPost::isPublished()->whereSlug($slug)->first();

		if ($post && $post->categories->count()) {
			$post->categories->each(function($category){
				$category->setUrl($this->categoryPage, $this->controller);
			});
		}

		if($post)
			Visit::create(['record_id' => $post->id, 'type' => 'article']);

		return $post;
	}

	protected function listMostViewedPosts(){
		return BlogPost::with('categories')->orderBy('views', 'desc')->limit(5)->get();
	}

	protected function listMostRelatedPosts($categories){
		return BlogPost::filterCategories($categories)->with('categories')->orderBy('published_at', 'desc')->limit(5)->get();
	}
}
