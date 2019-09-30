<?php

use SilverStripe\View\ArrayData;
use SilverStripe\CMS\Controllers\ContentController;

class Category_Controller extends ContentController {
	
	private static $allowed_actions = array(
		'category'
	);

	
	private static $url_handlers = array(
		'$Category!' => 'category'
	);

	public function category() {
		$tagName = $this->getRequest()->param('Category');

		$tag = ArticleCategory::get()->filter(array('URLSegment' => $tagName))->First();

		if($tag) {
			$articles = $tag->Articles();
			return $this->customise(new ArrayData(array(
				'Tag' => $tag,
				'Articles' => $articles
			)))->renderWith(array("Tag", "Page"));
		}
	}
}