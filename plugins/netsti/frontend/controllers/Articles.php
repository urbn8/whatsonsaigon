<?php namespace NetSTI\Frontend\Controllers;

// LIBRERIAS
use DB;
use Lang;
use Flash;
use Event;
use BackendMenu;
use Backend\Classes\Controller;
use NetSTI\Frontend\Models\Article;
use NetSTI\Frontend\Models\Category;

// CONTROLADOR
class Articles extends Controller{

	// PROPRIEDADES
	public $implement = [
		'Backend\Behaviors\ListController',
		'Backend\Behaviors\FormController',
		'Backend\Behaviors\ImportExportController',
	];
	
	public $listConfig = 'config_list.yaml';
	public $formConfig = 'config_form.yaml';
	public $importExportConfig = 'config_migration.yaml';
	public $bodyClass = 'compact-container';

	public $requiredPermissions = [
		'netsti.frontend.articles'
	];

	public function __construct(){
		if (post('comment_mode'))
			$this->formConfig = 'config_form_categories.yaml';

		parent::__construct();
		BackendMenu::setContext('NetSTI.Frontend', 'frontend', 'articles');
	}

	public function index()
	{
		$this->vars['postsTotal'] = Article::count();
		$this->vars['postsPublished'] = Article::isPublished()->count();
		$this->vars['postsDrafts'] = $this->vars['postsTotal'] - $this->vars['postsPublished'];
		$this->vars['categories'] = Category::count();

		$this->asExtension('ListController')->index();
	}

	public function onCreateForm(){
		$this->asExtension('FormController')->create();
		return $this->makePartial('create_form');
	}
	
	public function onCreate(){
		$this->asExtension('FormController')->create_onSave();
	}

	public function statistics(){
		$this->pageTitle = trans('netsti.frontend::lang.articles_statistics');
		$this->bodyClass = null;

		$query = 'SELECT MONTH(published_at) as month, COUNT(id) as total, SUM(views) as views FROM netsti_frontend_articles WHERE YEAR(published_at) = ? GROUP BY MONTH(published_at) ORDER BY published_at';
		$year = date('Y');
		$thisYear = array();
		$lastYear = array();
		$mostViews = Article::select('id','title','views','published_at')->with('categories')->orderBy('views', 'desc')->take(10)->get();
		$lessViews = Article::select('id','title','views','published_at')->with('categories')->orderBy('views', 'asc')->take(10)->get();

		for ($i=1; $i <= 12; $i++) { 
			$thisYear[] = array('month' => $year.'-'.$i, 'total' => 0, 'views' => 0);
			$lastYear[] = array('month' => ($year-1).'-'.$i, 'total' => 0, 'views' => 0);
		}

		$thisYearQuery = DB::select($query, [$year]);
		$lastYearQuery = DB::select($query, [$year-1]);

		foreach ($thisYearQuery as $value)
			$thisYear[$value->month -1] = array('month' => $year.'-'.$value->month, 'total' => $value->total, 'views' => $value->views);

		foreach ($lastYearQuery as $value)
			$lastYear[$value->month -1] = array('month' => ($year-1).'-'.$value->month, 'total' => $value->total, 'views' => $value->views);

		$result = array(
			'thisYear'  => $thisYear,
			'lastYear'  => $lastYear,
			'mostViews' => $mostViews,
			'lessViews' => $lessViews,
			'articles'  => Article::count(),
			'categories'=> Category::count(),
			'year' => $year
		);

		$this->addCss('/plugins/netsti/frontend/assets/css/statistics.css');
		$this->addJs('/plugins/netsti/frontend/assets/js/statistics.js');

		return $this->makePartial('statistics', $result);
	}

	public function info($id){
		$model = Article::findOrFail($id);
		$this->pageTitle = trans('netsti.frontend::lang.fields.details');
		$this->bodyClass = 'slim-container ';
		return $this->makePartial('info', ['model' => $model]);
	}

	public function listInjectRowClass($record, $definition = null)
	{
		if (!$record->published)
			return 'safe disabled';
	}

	public function formBeforeCreate($model){
		if (!post('comment_mode'))
			$model->user_id = $this->user->id;
	}
}