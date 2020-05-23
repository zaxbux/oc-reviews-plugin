<?php

namespace Zaxbux\Reviews\Components;

use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Zaxbux\Reviews\Models\Review;

class Reviews extends ComponentBase {

	public $reviews;

	public $reviewsPage;

	public $pageParam;

	public $schemaOrg;

	public function componentDetails() {
		return [
			'name'        => 'zaxbux.reviews::lang.components.reviews.name',
			'description' => 'zaxbux.reviews::lang.components.reviews.description'
		];
	}

	public function defineProperties() {
		return [
			'pageNumber' => [
				'title'       => 'zaxbux.reviews::lang.properties.pageNumber.title',
				'description' => 'zaxbux.reviews::lang.properties.pageNumber.description',
				'type'        => 'string',
				'default'     => '{{ :page }}',
			],
			'reviewsPerPage' => [
				'title'             => 'zaxbux.reviews::lang.properties.reviewsPerPage.title',
				'description'       => 'zaxbux.reviews::lang.properties.reviewsPerPage.description',
				'type'              => 'string',
				'validationPattern' => '^[0-9]+$',
				'validationMessage' => 'zaxbux.reviews::lang.properties.reviewsPerPage.validation',
			],
			'showFeatured' => [
				'title'       => 'zaxbux.reviews::lang.properties.showFeatured.title',
				'description' => 'zaxbux.reviews::lang.properties.showFeatured.description',
				'type'        => 'checkbox',
				'default'     => 0,
			],
		];
	}

	public function getReviewsPageOptions() {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
	}
	
	public function onRun() {
		$this->prepareVars();

		$this->reviews = $this->page['reviews'] = $this->loadReviews();

		$this->schemaOrg = $this->page['reviewSchemaOrg'] = $this->reviews->map(function ($model) {
			return $model->getSchemaOrg();
		});

		/*
         * If the page number is not valid, redirect
         */
        if ($pageNumberParam = $this->paramName('pageNumber')) {
            $currentPage = $this->property('pageNumber');

            if ($currentPage > ($lastPage = $this->reviews->lastPage()) && $currentPage > 1) {
                return Redirect::to($this->currentPageUrl([$pageNumberParam => $lastPage]));
            }
        }
	}

	protected function prepareVars() {
		$this->pageParam   = $this->paramName('pageNumber');
	}

	protected function loadReviews() {
		$page =    $this->property('pageNumber');
		$perPage = $this->property('reviewsPerPage');

		if ($this->property('showFeatured')) {
			if ($perPage > 0) {
				return Review::isFeatured()->orderBy('created_at', 'desc')->paginate($perPage, $page);
			}

			return Review::isFeatured()->orderBy('created_at', 'desc')->get();
		}

		if ($perPage > 0) {
			return Review::isPublished()->orderBy('created_at', 'desc')->paginate($perPage, $page);
		}

		return Review::isPublished()->orderBy('created_at', 'desc')->get();
	}
}