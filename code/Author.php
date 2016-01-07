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
			'SortOrder' => 'Int'
		)
	);

	private static $default_sort = ('SortOrder');

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new HTMLEditorField(
				'ManyMany[ArticleNote]',
				'Author note related to article (specific to this article only)'
			));
		return $fields;
	}

	public function getAsterisks(){
		$asterisks = '';
		for ($i = 0; $i < $this->SortOrder; $i++) {
    		$asterisks .= '*';
		}

		return $asterisks;
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
