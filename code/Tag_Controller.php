<?php

class Tag_Controller extends ContentController {
	
	private static $allowed_actions = array(
		'tag'
	);

	
	private static $url_handlers = array(
		'$Tag!' => 'tag'
	);

	public function tag() {
		$tagName = $this->getRequest()->param('Tag');

		$tag = ArticleTag::get()->filter(array('URLSegment' => $tagName))->First();

		if($tag) {
			$articles = $tag->Articles();
			return $this->customise(new ArrayData(array(
				'Tag' => $tag,
				'Articles' => $articles
			)))->renderWith(array("Tag", "Page"));
		}
	}
}