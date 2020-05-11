<?php

namespace Zaxbux\Reviews\Components;

use Input;
use Redirect;
use Validator;
use ValidationException;
use Zaxbux\Reviews\Rules\RecaptchaValidator;
use Cms\Classes\ComponentBase;
use Zaxbux\Reviews\Models\Review;
use Zaxbux\Reviews\Models\Settings;

class ReviewSubmit extends ComponentBase {
	public $countries;
	public $gRecaptchaConfig;

	public $jsonable = [
		'recpatcha'
	];

	public function componentDetails() {
		return [
			'name'        => 'zaxbux.reviews::lang.components.reviewSubmit.name',
			'description' => 'zaxbux.reviews::lang.components.reviewSubmit.description'
		];
	}

	public function onRun() {
		$this->countries = (new \League\ISO3166\ISO3166)->all();
		$this->gRecaptchaConfig = Settings::get('recaptcha');
	}

	public function onReviewSubmit() {
		$review = new Review;
		$rules = $review->rules;

		$rules['email'][] = 'required';
		$rules['title'][] = 'required';
		$rules['g-recaptcha-response'] = ['required', new RecaptchaValidator];

		$validator = Validator::make(Input::all(), $rules, $review->customMessages);

		if ($validator->fails()) {
			throw new ValidationException($validator);
			return;
		}

		$review = new Review;

		$review->name     = input('name');
		$review->email    = input('email');
		$review->country  = input('country');
		$review->check_in = input('check_in');
		$review->rating   = input('rating');
		$review->title    = input('title');
		$review->content  = input('content');

		$review->save();
	}
}