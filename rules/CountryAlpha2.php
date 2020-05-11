<?php

namespace Zaxbux\Reviews\Rules;

use Illuminate\Contracts\Validation\Rule;
use League\ISO3166\ISO3166;
use League\ISO3166\Exception\ISO3166Exception;

class CountryAlpha2 implements Rule {
	/**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
	public function passes($attribute, $value) {
		try {
			(new ISO3166)->alpha2($value);
			return true;
		} catch (ISO3166Exception $ex) {}

		return false;
	}
	
	/**
     * Validation callback method.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  array  $params
     * @return bool
     */
	public function validate($attribute, $value, $params) {
		return $this->passes($attribute, $value);
	}
	
	/**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
		return 'The :attribute must be an ISO3166 alpha2 country code.';
	}
}