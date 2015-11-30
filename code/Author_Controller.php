<?php

class Author_Controller extends ContentController {

	private static $allowed_actions = array(
		'author'
	);

	
	private static $url_handlers = array(
		'$Author!' => 'author'
	);

	public function author() {
		$authorName = $this->getRequest()->param('Author');

		$author = Author::get()->filter(array('URLSegment' => $authorName))->First();

		if($author) {
			$articles = $author->Articles();
			return $this->customise(new ArrayData(array(
				'Author' => $author,
				'Articles' => $articles
			)))->renderWith(array("Author", "Page"));
		}
	}
}