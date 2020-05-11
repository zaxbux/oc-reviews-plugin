<?php

namespace Zaxbux\Reviews\Models;

use Model;
use Backend\Models\UserGroup;

class Settings extends Model {
	public $implement = [
		'System.Behaviors.SettingsModel'
	];

	// Unique code
	public $settingsCode = 'Zaxbux_Reviews_Settings';

	// Fields definition
	public $settingsFields = 'fields.yaml';

	public function initSettingsData() {
        
    }

	public function getModeratorGroupOptions() {
		return UserGroup::all()->reject(function($group) {
			// Remove groups without a unique code (for API)
			return empty($group->code);
		})->lists('name', 'code');
	}
}