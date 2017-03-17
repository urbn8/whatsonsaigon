<?php namespace NetSTI\Frontend\Components;

use NetSTI\Frontend\Models\MString;
use Illuminate\Support\Facades\Schema;

class Strings extends \Cms\Classes\ComponentBase{

	public function componentDetails()
	{
		return [
			'name'        => 'netsti.frontend::lang.string_component',
			'description' => 'netsti.frontend::lang.string_component_description',
		];
	}

	public function onRun()
	{
		$strings = String::all();
		$text = [];
		foreach ($strings as $item) {
			switch ($item->type) {
				case 'text':
					$text[$item->slug] = $item->text;
					break;
				case 'longtext':
					$text[$item->slug] = $item->longtext;
					break;
				case 'richtext':
					$text[$item->slug] = $item->richtext;
					break;
				case 'markdown':
					$text[$item->slug] = $item->markdown;
					break;
			}
		}
		$this->page['trans'] = $text;
	}
}
