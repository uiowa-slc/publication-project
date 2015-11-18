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

	/**
	 * @var array
	 */
	private static $extensions = array(
		'ArticleURLSegmentExtension',
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new HTMLEditorField(
				'ManyMany[ArticleNote]',
				'Author note related to article (specific to this article only)'
			));
		return $fields;
	}

	/**
	 * Returns a relative URL for the tag link.
	 *
	 * @return string
	 */
	public function Link() {
		return 'author/'.$this->URLSegment;
	}
}
