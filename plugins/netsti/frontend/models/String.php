<?php namespace NetSTI\Frontend\Models;

// LIBRERIAS
use Model;
use ValidationException;

// CLASE
class String extends Model{

	// VALIDACIONES
	use \October\Rain\Database\Traits\Validation;
	public $rules = [
		'name' => 'required',
		'slug' => ['required', 'regex:/^[a-z0-9\/\:_\-\*\[\]\+\?\|]*$/i', 'unique:netsti_frontend_strings']
	];

	public $attributeNames = [
		'name' => 'Name',
		'slug' => 'Slug'
	];

	// TRASLATABLE
	public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
	public $translatable = ['text', 'richtext', 'textarea', 'markdown'];

	// PROPIEDADES
	public $timestamps = false;
	protected $table = 'netsti_frontend_strings';
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
	public $attachOne = [];
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
}