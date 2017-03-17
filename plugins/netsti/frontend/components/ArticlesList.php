<?php namespace NetSTI\Frontend\Components;

use DB;
use Redirect;
use Cms\Classes\Page;
use Cms\Classes\Theme;
use Cms\Classes\ComponentBase;
use NetSTI\Frontend\Models\Article;
use NetSTI\Frontend\Models\Category;

class ArticlesList extends ComponentBase{

	public $articles;
	public $thisPage;
	public $postPage;
	public $category;
	public $cardStyle;

	public function componentDetails(){
		return [
			'name'        => 'netsti.frontend::lang.settings.posts_title',
			'description' => 'netsti.frontend::lang.settings.posts_description'
		];
	}

	public function defineProperties(){
		return [
			'categoryFilter' => [
				'title'       => 'netsti.frontend::lang.settings.posts_filter',
				'description' => 'netsti.frontend::lang.settings.posts_filter_description',
				'type'        => 'dropdown',
				'default'     => '{{ :category }}',
			],
			'postsPerPage' => [
				'title'             => 'netsti.frontend::lang.settings.posts_per_page',
				'type'              => 'string',
				'validationPattern' => '^[0-9]+$',
				'validationMessage' => 'netsti.frontend::lang.settings.posts_per_page_validation',
				'default'           => 25,
				'showExternalParam' => false
			],
			'cardStyle' => [
				'title'        => 'Card Style',
				'type'         => 'checkbox',
				'default'      => true,
				'showExternalParam' => false
			],
			'published' => [
				'title'        => 'Show Published',
				'type'         => 'checkbox',
				'default'      => true,
				'showExternalParam' => false
			],
			'sortOrderAttribute' => [
				'title'       => 'netsti.frontend::lang.settings.posts_order_attribute',
				'description' => 'netsti.frontend::lang.settings.posts_order_description',
				'group'       => 'netsti.frontend::lang.settings.posts_order',
				'type'        => 'dropdown',
				'default'     => 'published_at',
			],
			'sortOrderDirection' => [
				'title'       => 'netsti.frontend::lang.settings.posts_order_direction',
				'group'       => 'netsti.frontend::lang.settings.posts_order',
				'type'        => 'dropdown',
				'default'     => 'desc',
				'options'	  => [
					'asc' => 'Ascending',
					'desc' => 'Descending',
				]
			],
			'postPage' => [
				'title'       => 'netsti.frontend::lang.settings.posts_post',
				'description' => 'netsti.frontend::lang.settings.posts_post_description',
				'type'        => 'dropdown',
				'default'     => 'blog/post',
				'group'       => 'Links',
			],
		];
	}

	public function getPostPageOptions(){
		return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
	}

	public function getSortOrderAttributeOptions(){
		return Article::$allowedSortingOptions;
	}

	public function onRun(){
		$this->prepareVars();

		$this->addCss('/plugins/netsti/frontend/assets/css/post.css');
		$this->addCss('/plugins/netsti/frontend/assets/css/cards.css');
	}

	protected function prepareVars(){
		$attr = $this->property('sortOrderAttribute');
		$dirr = $this->property('sortOrderDirection');
		$postsPerPage = $this->property('postsPerPage');
		$this->cardStyle = $this->property('cardStyle');

		$query = Article::search(input('search'));
		$query->categories($this->loadCategory());

		if($this->property('published'))
			$query->isPublished();


		$query->orderBy($attr, $dirr);

		$posts = $query->paginate($postsPerPage);

		$this->thisPage = $this->page->baseFileName;
		$this->postPage = $this->property('postPage');

		$posts->each(function($post) {
			$post->setUrl($this->postPage, $this->controller);
			$this->linkCategories($post->categories);
		});

		$viewed = $this->listMostViewedArticles();
		$recent = $this->listMostRecentArticles();

		$viewed->each(function($post) {
			$post->setUrl($this->postPage, $this->controller);
		});

		$recent->each(function($post) {
			$post->setUrl($this->postPage, $this->controller);
		});

		$this->page['articles'] = $posts;
		$this->page['mostViewedArticles'] = $viewed;
		$this->page['mostRecentArticles'] = $recent;
	}

	protected function listMostViewedArticles(){
		return Article::with('categories')->orderBy('views', 'desc')->limit(5)->get();
	}

	protected function listMostRecentArticles(){
		return Article::with('categories')->orderBy('published_at', 'desc')->limit(5)->get();
	}

	protected function loadCategories(){
		$categories = Category::orderBy('name');

		$categories = $categories->getNested();

		return $this->linkCategories($categories);
	}

	protected function linkCategories($categories){
		return $categories->each(function($category) {
			$category->setUrl($this->thisPage, $this->controller);

			if ($category->children) {
				$this->linkCategories($category->children);
			}
		});
	}

	protected function loadCategory(){
		if (!$categoryId = $this->property('categoryFilter'))
			return null;

		if (!$category = Category::whereSlug($categoryId)->first())
			return null;

		return $category;
	}

	public function getCategoryFilterOptions(){
		$list = Category::lists('name', 'slug');
		array_unshift($list, 'All Categories');
		return $list;
	}
}
