<?php
class Author extends Contributor {

	private static $db = array(

	);

	private static $has_one = array(

	);

	private static $many_many = array(
		'Articles' => 'Article',
	);
	private static $many_many_extraFields = array(
		'Articles'     => array(
			'ArticleNote' => 'HTMLText',
		)
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new HTMLEditorField(
				'ManyMany[ArticleNote]',
				'Author note related to article (specific to this article only)'
			));
		return $fields;
	}
}
