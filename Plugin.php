<?php namespace Zaxbux\Reviews;

use Validator;
use System\Classes\PluginBase;
use System\Classes\MediaLibrary;

class Plugin extends PluginBase {

	public function boot() {
		Validator::extend('country_alpha2', Rules\CountryAlpha2::class);
	}

	public function registerComponents() {
		return [
			Components\Reviews::class       => 'reviews',
			Components\ReviewSubmit::class  => 'reviewSubmit',
			Components\ReviewSummary::class => 'reviewSummary',
		];
	}

	public function registerPermissions() {
        return [
            'zaxbux.reviews.access_settings' => [
                'label' => 'zaxbux.reviews::lang.permissions.access_settings',
                'tab'   => 'zaxbux.reviews::lang.plugin.name',
                'order' => 200,
                'roles' => [
                    // role API codes
                ]
			],
			'zaxbux.reviews.manage_reviews' => [
                'label' => 'zaxbux.reviews::lang.permissions.manage_reviews',
                'tab'   => 'zaxbux.reviews::lang.plugin.name',
                'order' => 200,
                'roles' => [
                    // role API codes
                ]
            ],
        ];
    }

	public function registerSettings() {
        return [
            'settings' => [
                'label'       => 'zaxbux.reviews::lang.settings.label',
                'description' => 'zaxbux.reviews::lang.settings.description',
                'category'    => 'zaxbux.reviews::lang.settings.category',
                'icon'        => 'icon-star-half-o',
                'class'       => Models\Settings::class,
                'order'       => 500,
                'keywords'    => 'reviews',
                'permissions' => [
                    'zaxbux.reviews.access_settings'
                ]
            ],
        ];
	}

	public function registerListColumnTypes() {
		return [
			'switch_status' => function($value) {
				$value  = (bool) $value;
				$colour = $value ? 'success' : 'danger';
				$text   = $value ? 'Yes' : 'No';
				return sprintf('<span class="oc-icon-circle text-%s">%s</span>', $colour, $text);
			}
		];
	}
	
	public function registerMailTemplates(){
		return [
			'zaxbux.reviews::mail.new-review',
		];
    }
}
