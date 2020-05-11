<?php

namespace Zaxbux\Reviews\Rules;

use Request;
use Illuminate\Contracts\Validation\Rule;
use ReCaptcha\ReCaptcha;

class RecaptchaValidator implements Rule {

	protected $error;

	/**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
	public function passes($attribute, $value) {
		$requestIP = Request::ip();
		$gRecaptcha = new Recaptcha('6LdJ8e0UAAAAAGV43210ihnzSXR4TxSn0h1wGJP2');

		$response = $gRecaptcha->verify($value, $requestIP);

		if (!$response->isSuccess()) {
			$this->error = $response->getErrorCodes();
		}

		return $response->isSuccess();
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
		return $this->error;
	}
}