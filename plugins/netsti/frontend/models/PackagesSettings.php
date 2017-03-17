<?php namespace NetSTI\Frontend\Models;

use October\Rain\Database\Model as BaseModel;

/**
 * Settings Model
 */
class PackagesSettings extends BaseModel
{
	public $implement = ['System.Behaviors.SettingsModel'];
	public $settingsCode = 'netsti_system_packages_settings';
	public $settingsFields = 'fields.yaml';
	public $attachOne = [];
}