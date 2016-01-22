<?php

class Author_Controller extends ContentController {

	private static $allowed_actions = array(
		'author',
	);

	private static $url_handlers = array(
		'$Contributor!' => 'author',
	);

	public function author() {
		$ContributorName = $this->getRequest()->param('Contributor');

		$contributor = Contributor::get()->filter(array('URLSegment' => $ContributorName))->First();
		if ($contributor != null) {
			$articles = $contributor->Articles();
			return $this->customise(new ArrayData(array(
						'Author'   => $contributor,
						'Articles' => $articles,
					)))->renderWith(array("Author", "Page"));
		} else {
			return $this->httpError(404, 'Page not found');
		}

	}
}