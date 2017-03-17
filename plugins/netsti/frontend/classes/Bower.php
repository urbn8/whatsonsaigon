<?php
namespace NetSTI\Frontend\Classes;

use DB;
use NetSTI\Frontend\Models\PackagesSettings;

class Bower{

	private $themePath;
	private $path;
	private $command;
	private $pathCommand;
	private $bowerphp;
	private $settings;
	
	function __construct(){
		$actualTheme = DB::table('system_parameters')
			->where('namespace', 'cms')->where('group', 'theme')
			->where('item', 'active')
			->first()->value;

		$this->themePath = themes_path()."/".str_replace('"', '', $actualTheme);
		$this->command = plugins_path()."/netsti/frontend/classes/bowerphp";
		$this->path = 'export HOME="'.app_path().'";'.$this->command;
		$this->bowerphp = realpath(dirname(__FILE__)).'/bowerphp';

		$settings = PackagesSettings::instance();
	}

	function checkCommandPermission(){
		return substr(sprintf('%o', fileperms($this->command)), -4);
	}

	function updateCommand(){
		if($this->checkCommandPermission() == '0755'){
			return false;
		}else{
			chmod($this->command, 0755);
			return true;
		}
	}

	function updateTheme(){
		if(file_exists($this->themePath."/.bowerrc")){
			return false;
		}else{
			$bowerrc = fopen($this->themePath."/.bowerrc", "w") or die("Unable to open file!");
			fwrite($bowerrc, '{ "directory": "assets/vendor" }');
			fclose($bowerrc);
			$this->execBower('init -n');
		}

	}

	function execBower($params){
		$home = app_path();
		$php = PackagesSettings::get('php');
		return shell_exec("export HOME='$home';cd $this->themePath;$php $this->bowerphp $params");
	}

	function execBowerLocal($params){
		return shell_exec('export PATH="'.PackagesSettings::get('path_variable').'";export HOME="'.app_path().'";cd "'.$this->themePath.'";bower '.$params.' -n 2>&1');
	}

	function listPackages(){
		$data = [];
		$result = $this->execBower("list");

		foreach (explode("\n", $result) as $key => $value) {
			if(strlen($value) > 0 && $value != 'Search results:'){
				$data[] = explode('#', str_replace('extraneous', '', str_replace('  ', '', $value)));
			}
		}

		return $data;
	}

	function searchPackages($query){
		$data = [];
		$result = $this->execBower('search "'.$query.'"');

		$result = str_replace('    ', '', $result);
		$result = str_replace("Search results:\n\n", '', $result);
		$result = explode("\n", $result);

		foreach ($result as $key => $value){
			if($value != ''){
				$data[] = explode(' ', $value);

				if($key > 8)
					break;
			}
		}

		return $data;
	}

	function help(){
		return $this->execBower("help");
	}

	function install($package){
		if(PackagesSettings::get('local'))
			return $this->execBowerLocal("install ".$package);
		else
			return $this->execBower("install ".$package);
	}

	function uninstall($package){
		if(PackagesSettings::get('local'))
			return $this->execBowerLocal("uninstall ".$package);
		else
			return $this->execBower("uninstall ".$package);
	}

	function updatePackages(){
		if(PackagesSettings::get('local'))
			return $this->execBowerLocal('update');
		else
			return $this->execBower('update');
	}

	function getSummaryPackage($package){
		if($file = file_get_contents($this->themePath.'/assets/vendor/'.$package.'/bower.json'))
			return json_decode($file);
		else
			return false;
	}

	function getListFiles(){
		$packages = $this->listPackages();
		$data = [
			'css' => [],
			'js' => []
		]; 

		foreach ($packages as $package) {
			$summary = $this->getSummaryPackage($package[0]);
			$files = $summary->main;

			if(count($files)>1)
				foreach ($files as $file)
					$data = $this->getFileType($package[0], $data, $file, isset($summary->dependencies));
			else
				$data = $this->getFileType($package[0], $data, $files, isset($summary->dependencies));
		}

		return $data;
	}

	private function getFileType($package, $data, $file, $dep){
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		$file = str_replace('./', '/', $file);
		$file = $file[0] == '/' ? substr($file, 1, strlen($file)) : $file;
		$file = 'assets/vendor/'.$package.'/'.$file;

		if($ext == 'js'){
			if(count($dep))
				array_unshift($data['js'], $file);
			else
				$data['js'][] = $file;
		}else if($ext == 'css' || $ext == 'less'){
			if(count($dep))
				array_unshift($data['css'], $file);
			else
				$data['css'][] = $file;
		}

		return $data;
	}

	function getPackagePath($package){
		return $themePath.'/assets/vendor/'.$package;
	}
}

?>