<?php namespace NetSTI\Frontend\Models;

// LIBRERIAS
use Model;
use ValidationException;

// CLASE
class Testimonial extends Model{

	// VALIDACIONES
	use \October\Rain\Database\Traits\Validation;
	public $rules = [
		'content' => 'required',
		'name' => 'required'
	];

	public $attributeNames = [
		'content' => 'Content',
		'name' => 'Name'
	];

	// TRASLATABLE
	public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
	public $translatable = ['content', 'source', 'place'];

	// PROPIEDADES
	public $timestamps = false;
	protected $table = 'netsti_frontend_testimonials';
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
}