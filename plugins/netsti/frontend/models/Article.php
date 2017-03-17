<?php namespace NetSTI\Frontend\Models;

use DB;
use App;
use Str;
use Html;
use Lang;
use Yaml;
use Model;
use Markdown;
use ValidationException;
use Backend\Models\User;
use Carbon\Carbon;

class Article extends Model{
	// VALIDACIONES
	use \October\Rain\Database\Traits\Validation;
	public $rules = [
		'title' => 'required',
		'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:netsti_frontend_articles'],
		'content' => 'required',
	];

	public $attributeNames = [
		'title' => 'Title',
		'slug' => 'Slug'
	];

	// TRASLATABLE
	public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
	public $translatable = ['title','content', ['slug', 'index' => true]];

	// PROPIEDADES
	public $timestamps = false;	
	public $preview = null;
	protected $appends = ['summary', 'has_summary', 'seo_summary'];
	protected $table = 'netsti_frontend_articles';
	protected $primaryKey = 'id';
	protected $dates = ['published_at'];
	protected $guarded = [];
	protected $jsonable = ['tags'];
	protected $fillable = [];
	protected $visible = [];

	// SHORTING ALLOWED
	public static $allowedSortingOptions = array(
		'title' => 'Title',
		'created_at' => 'Created',
		'updated_at' => 'Updated',
		'published_at' => 'Published',
		'views' => 'Views'
	);

	// RELACIONES
	public $hasOne = [];
	public $hasMany = [
		'visits' => [
			'NetSTI\Frontend\Models\Visit', 
			'key' => 'record_id',
			'conditions' => 'type = "article"'
		]
	];
	public $belongsTo = [
		'user' => ['Backend\Models\User']
	];

	public $belongsToMany = [
		'categories' => [
			'NetSTI\Frontend\Models\Category',
			'table' => 'netsti_frontend_newscategories',
			'order' => 'name'
		]
	];

	// FUCIONES
	public $morphTo = [];
	public $morphOne = [];
	public $morphMany = [];

	// ADJUNTOS Y ARCHIVOS
	public $attachOne = [
		'featured_images' => ['System\Models\File']
	];
	public $attachMany = [
		'attachments' => ['System\Models\File']
	];

	// SCOPES
	public function scopeIsPublished($query){
		return $query
		->whereNotNull('published')
		->where('published', true)
		->whereNotNull('published_at')
		->where('published_at', '<', Carbon::now());
	}

	public function scopeSearch($query, $search){
		$searchableFields = ['title', 'slug'];
		$search = trim($search);
		if (strlen($search))
			return $query->searchWhere($search, $searchableFields, 'all');
		return $query;
	}

	public function scopeCategories($query, $category){
		if(!$category)
			return $query;

		if($child = $category->children)
			$categories = $category->children->lists('slug');

		$categories[] = $category->slug;

		return $query->whereHas('categories', function($q) use ($categories) {
			$q->whereIn('slug', $categories);
		});
	}

	public function scopeFilterCategories($query, $categories){
		return $query->whereHas('categories', function($q) use ($categories) {
			$q->whereIn('id', $categories);
		});
	}

	// EVENTOS
	public function beforeCreate(){ }
	public function afterCreate(){ }

	public function beforeSave(){ }
	public function afterSave(){ }

	public function beforeValidate(){ }
	public function afterValidate(){
		if ($this->published && !$this->published_at) {
			throw new ValidationException([
				'published_at' => Lang::get('rainlab.blog::lang.post.published_validation')
			]);
		}
	}

	public function beforeUpdate(){ }
	public function afterUpdate(){ }

	public function beforeDelete(){ }
	public function afterDelete(){ }

	public function beforeRestore(){ }
	public function afterRestore(){ }

	public function beforeFetch(){ }
	public function afterFetch(){ }

	public function setUrl($pageName, $controller){
		$params = [
			'id' => $this->id,
			'slug' => $this->slug,
		];

		if (array_key_exists('categories', $this->getRelations())) {
			$params['category'] = $this->categories->count() ? $this->categories->first()->slug : null;
		}

		return $this->url = $controller->pageUrl($pageName, $params);
	}

	public function canEdit(User $user){
		return ($this->user_id == $user->id) || $user->hasAnyAccess(['netsti.frontend.access_other_posts']);
	}

	public function getHasSummaryAttribute(){
		return strlen($this->getSummaryAttribute()) < strlen($this->content);
	}

	public function getSummaryAttribute(){
		$more = '<!-- more -->';
		if (strpos($this->content, $more) !== false) {
			$parts = explode($more, $this->content);
			return array_get($parts, 0);
		}

		return Str::limit(Html::strip($this->content), 300);
	}

	public function getSeoSummaryAttribute(){
		$more = '<!-- more -->';
		if (strpos($this->content, $more) !== false) {
			$parts = explode($more, $this->content);
			return array_get($parts, 0);
		}

		return Str::limit(Html::strip($this->content), 120);
	}

	public function getViewsAttribute($value){
		return $this->visits()->count() + $value;
	}

	public function getTextAttribute(){
		return Html::strip($this->content);
	}

	public function getKeywordsAttribute(){
		$words = array_keys($this->words);
		return implode(', ', $words);
	}

	public function getWordsAttribute(){
		$max_count = 10;
		$frequency = $this->getAllWords();
		$keywords = array_slice($frequency, 0, $max_count);
		$words = [];

		foreach ($keywords as $key => $item)
			$words[$key] = array('count' => $item, 'type' => 'word');
			
		if($tags = $this->tags){
			foreach ($tags as $tag){
				$tag = strtolower($tag);

				if(in_array($tag, array_keys($frequency)))
					$words[$tag] = array('count' => $frequency[$tag] + 1, 'type' => 'tag');
				else
					$words[$tag] = array('count' => 1, 'type' => 'tag');
			}
		}

		arsort($words);

		return $words;
	}

	public function getTagsOptions(){
		$frequency = $this->getAllWords();
		$max_count = 50;
		$keywords = array_slice($frequency, 0, $max_count);
		$words = [];
		foreach ( $keywords as $key => $item )
			$words[$key] = $key;
		return $words;
	}

	private function getAllWords(){
		$string = Html::strip($this->title.' '.$this->content);
		$stop_words = Yaml::parseFile('plugins/netsti/frontend/stopwords.yaml');

		$string = trim($string);
		$string = strtolower($string);

		preg_match_all('/\b.*?\b/i', $string, $match_words);
		$match_words = $match_words[0];

		foreach ( $match_words as $key => $item )
			if ( $item == '' || in_array(strtolower($item), $stop_words) || strlen($item) <= 3 )
				unset($match_words[$key]);

		$word_count = str_word_count( implode(" ", $match_words) , 1); 
		$frequency = array_count_values($word_count);

		arsort($frequency);

		return $frequency;
	}
}
