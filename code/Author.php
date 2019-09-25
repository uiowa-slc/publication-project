<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
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
			'SortOrder'   => 'Int',
		)
	);

	//private static $default_sort = 'SortOrder';

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create(
				'ManyMany[ArticleNote]',
				'Author note related to article (specific to this article only)'
			)->setRows(5));

		$fields->removeByName('SortOrder');
		$fields->removeByName('URLSegment');
		return $fields;
	}

	public function getAsterisks() {
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

    public function Articles() {
        return $this->getManyManyComponents('Articles')->sort('SortOrder');
    }
}
