<?php

namespace Zaxbux\Reviews\Components;

use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Zaxbux\Reviews\Models\Review;
use Spatie\SchemaOrg\Schema;

class ReviewSummary extends ComponentBase {

	public $reviewCount;

	public $overallRating;

	public $schemaOrg;

	public function componentDetails() {
		return [
			'name'        => 'zaxbux.reviews::lang.components.reviewSummary.name',
			'description' => 'zaxbux.reviews::lang.components.reviewSummary.description'
		];
	}

	public function defineProperties() {
		return [];
	}
	
	public function onRun() {
		$this->reviewCount   = $this->page['reviewCount']   = Review::isPublished()->get()->count();
		$this->overallRating = $this->page['overallRating'] = Review::isPublished()->avg('rating');
		$this->schemaOrg     = Schema::aggregateRating()
			->bestRating(5)
			->ratingValue(round($this->overallRating, 2))
			->worstRating(1)
			->ratingCount($this->reviewCount);
	}
}