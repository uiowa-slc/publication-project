<?php

use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;

class ArticleCategory extends DataObject {
	/**
	 * @var array
	 */
	private static $db = array(
		'Title' => 'Varchar(255)',
	);

	/**
	 * @var array
	 */
	private static $has_many = array(
		'Articles' => 'Article',
	);

	/**
	 * @var array
	 */
	private static $extensions = array(
		'ArticleURLSegmentExtension',
	);

	/**
	 * {@inheritdoc}
	 */
	public function getCMSFields() {
		$fields = new FieldList(
			TextField::create('Title', _t('BlogTag.Title', 'Title'))
		);

		$this->extend('updateCMSFields', $fields);

		return $fields;
	}

	/**
	 * Returns a relative URL for the tag link.
	 *
	 * @return string
	 */
	public function getLink() {
		return 'category/'.$this->URLSegment;
	}

}
