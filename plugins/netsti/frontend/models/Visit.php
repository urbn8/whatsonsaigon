<?php namespace NetSTI\Frontend\Models;

// LIBRERIAS
use Model;

// CLASE
class Visit extends Model{
	// PROPIEDADES
	public $timestamps = true;
	protected $table = 'netsti_frontend_visits';
	protected $primaryKey = 'id';
	protected $dates = [];
	protected $guarded = [];
	protected $jsonable = [];
	protected $fillable = ['record_id', 'type'];
	protected $visible = [];

	// RELACIONES
	public $hasOne = [];
	public $hasMany = [];
	public $belongsTo = [];
	public $belongsToMany = [];

	// EVENTOS
	public function beforeCreate(){
		$this->uid = md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
		$this->os = $this->getOS();
		
		$host = $_SERVER['REMOTE_ADDR'];
		$ip = (!in_array($host, ['127.0.0.1','::1']))? $host : '';
		$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
		if(!$query && $query['status'] != 'success')
			return;

		$this->ip = @$query['query'];
		$this->country = @$query['country'];
		$this->region = @$query['regionName'];
		$this->city = @$query['city'];
		$this->isp = @$query['isp'];
		$this->timezone = @$query['timezone'];

		$this->region_code = @$query['region'];
		$this->country_code = @$query['countryCode'];
		$this->lon = @$query['lon'];
		$this->lat = @$query['lat'];
	}

	protected function getOS() { 
		$user_agent = $_SERVER['HTTP_USER_AGENT'];

		$os_platform = "other";
		$os_array = array(
			'/windows/i'            =>  'windows',
			'/win98/i'              =>  'windows',
			'/win95/i'              =>  'windows',
			'/win16/i'              =>  'windows',
			'/macintosh|mac os x/i' =>  'osx',
			'/mac_powerpc/i'        =>  'osx',
			'/linux/i'              =>  'linux',
			'/ubuntu/i'             =>  'ubuntu',
			'/iphone/i'             =>  'ios',
			'/ipod/i'               =>  'ios',
			'/ipad/i'               =>  'ios',
			'/android/i'            =>  'android',
			'/blackberry/i'         =>  'blackberry',
			'/webos/i'              =>  'mobile'
		);

		foreach ($os_array as $regex => $value)
			if (preg_match($regex, $user_agent))
				$os_platform = $value;

		return $os_platform;
	}

	public function scopeListing($query, $id, $type){
		return $query->where('record_id',$id)->where('type',$type);
	}
}