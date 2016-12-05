<?php
class Author extends DataObject {

	private static $db = array(
		'Note' => 'HTMLText'
	);

	private static $has_one = array(
		'Contributor' => 'Contributor',
		'Article' => 'Article'

	);

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
