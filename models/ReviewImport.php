<?php

namespace Zaxbux\Reviews\Models;

use BackendMenu;

class ReviewImport extends \Backend\Models\ImportModel {
	/**
	 * @var array The rules to be applied to the data.
	 */
	public $rules = [];

	public function importData($results, $sessionKey = null) {
		foreach ($results as $row => $data) {

			if ($data['check_in']) {
				$data['check_in'] = \DateTime::createFromFormat($this->date_format, $data['check_in']);
			}

			$data['created_at'] = $data['check_in'];

			try {
				$subscriber = new Review;
				$subscriber->fill($data);
				$subscriber->save();

				$this->logCreated();
			}
			catch (\Exception $ex) {
				$this->logError($row, $ex->getMessage());
			}

		}
	}
}