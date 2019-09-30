<?php

use SilverStripe\Assets\Image;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DataObject;
class Contributor extends DataObject {

	private static $db = array(
		'Name'                => 'Text',
		'BiographicalDetails' => 'HTMLText'
	);

	private static $has_one = array(
		'Image' => Image::class,
	);

	private static $many_many = array(

	);

	/**
	 * @var array
	 */
	private static $extensions = array(
		'ArticleURLSegmentExtension',
	);
	public function getTitle() {
		return $this->Name;
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName('Content');
		$fields->removeByName('Metadata');
		$fields->removeByName(Image::class);
		$fields->removeByName('Articles');

		$fields->addFieldToTab('Root.Main', new TextField('Name'));
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('BiographicalDetails', 'Biographical Details')->setRows(5));

		return $fields;
	}
}
