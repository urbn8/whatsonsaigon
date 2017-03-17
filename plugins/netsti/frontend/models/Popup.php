<?php namespace NetSTI\Frontend\Models;

// LIBRERIAS
use Model;
use ValidationException;

// CLASE
class Popup extends Model{

	// VALIDACIONES
	use \October\Rain\Database\Traits\Validation;
	public $rules = [
		'title' => 'required',
		'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:netsti_frontend_galleries']
	];

	public $attributeNames = [
		'title' => 'Title',
		'slug' => 'Slug'
	];

	// TRASLATABLE
	public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
	public $translatable = ['title','code'];

	// PROPIEDADES
	public $timestamps = false;
	protected $table = 'netsti_frontend_popups';
	protected $primaryKey = 'id';
	protected $dates = [];
	protected $guarded = [];
	protected $jsonable = [];
	protected $fillable = [];
	protected $visible = [];

	// RELACIONES
	public $hasOne = [];
	public $hasMany = [];
	public $belongsTo = [];
	public $belongsToMany = [];

	// FUCIONES
	public $morphTo = [];
	public $morphOne = [];
	public $morphMany = [];

	// ADJUNTOS Y ARCHIVOS
	public $attachOne = [
		'image' => ['System\Models\File'],
	];
	public $attachMany = [];

	// EVENTOS
	public function beforeCreate(){ }
	public function afterCreate(){ }

	public function beforeSave(){ }
	public function afterSave(){ }

	public function beforeValidate(){ }
	public function afterValidate(){ }

	public function beforeUpdate(){ }
	public function afterUpdate(){ }

	public function beforeDelete(){ }
	public function afterDelete(){ }

	public function beforeRestore(){ }
	public function afterRestore(){ }

	public function beforeFetch(){ }
	public function afterFetch(){ }

	public function setClickCount(){
		$this->clicks++;
		$this->save();
	}

	public function setBounceCount(){
		$this->bounces++;
		$this->save();
	}
}