<?php namespace NetSTI\Frontend\FormWidgets;

use Lang;
use Flash;
use Event;
use Config;
use BackendAuth;
use Backend\Classes\FormField;
use Backend\Classes\FormWidgetBase;
use Backend\FormWidgets\Relation as RelationWidget;

class RelationForm extends RelationWidget{
	use \Backend\Traits\FormModelSaver;

	// PROPERTIES
	protected $defaultAlias = 'selector';

	public $form;
	public $user;
	public $modelClass;
	public $permission;
	public $formWidget;

	// ON INIT
	public function init(){
		parent::init();
	}

	// PREPARE VARIABLES
	public function prepareVars(){
		parent::prepareVars();
		$this->user = BackendAuth::getUser();
	}

	public function onCreateFinish(){
		$field = $this->makeRenderFormField();
		return ['#'.$this->getId() => $this->makePartial('~/modules/backend/widgets/form/partials/_field_'.$field->type.'.htm', ['field' => $field])];
	}
	
	// INIT MODAL FORM
	public function initForm(){
		$config = $this->makeConfig($this->form);
		$config->model = new $this->modelClass;

		$widget = $this->makeWidget('Backend\Widgets\Form', $config);
		$widget->bindToController();

		return $this->formWidget = $widget;
	}

	// CREATE MODAL RECORD
	public function onCreateFieldModal(){
		$data = post();
		$model = new $this->modelClass;
		$model->fill($data);

		if($model->validate()){
			$model->save();
			Flash::success(Lang::get('backend::lang.form.create_success', ['name' => trans($this->formField->label)]));
			$field = $this->makeRenderFormField();
			return ['#'.$this->getId() => $this->makePartial('~/modules/backend/widgets/form/partials/_field_'.$field->type.'.htm', ['field' => $field])];
		}           
	}

	// CREATE MODAL POPUP
	public function onCreateModal(){
		$test = $this->getRelationObject();
		return $this->makePartial('create', ['widget' => $this->formWidget, 'fieldName' => $this->formField->label]);
	}
}