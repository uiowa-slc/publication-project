<?php
class Contributor extends DataObject {

	private static $db = array(
		'Name'                => 'Text',
		'BiographicalDetails' => 'HTMLText'
	);

	private static $has_one = array(
		'Image' => 'Image',
	);

	  private static $belongs_many_many = [
	    "Articles" => "Article",
	  ];

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
		$fields->removeByName('Image');
		$fields->removeByName('Articles');

		$fields->addFieldToTab('Root.Main', new TextField('Name'));
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('BiographicalDetails', 'Biographical Details')->setRows(5));

		return $fields;
	}
}
