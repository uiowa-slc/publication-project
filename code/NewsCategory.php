<?php

class NewsCategory extends DataObject {
	private static $has_many = array(
		'NewsItems' => 'NewsPage'
	);

	private static $db = array(
		'Title' => 'Varchar(255)'
	);

	public function getLink() {
		$newsHolder = NewsHolder::get_one('NewsHolder');
		if ($newsHolder) {
			return $newsHolder->Link() . '?category=' . $this->ID;
		}
	}
}