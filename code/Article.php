<?php
class Article extends Page {
	private static $db = array(
		'Title'   => 'HTMLText',
		'Content' => 'HTMLText',
	);

	private static $has_one           = array('Image' => 'Image');
	private static $plural_name       = 'Articles';
	private static $belongs_many_many = array(
		'Issues'  => 'Issue',
		'Authors' => 'Author',
	);

	private static $listing_page_class = 'Issue';
	private static $show_in_sitetree   = false;
	private static $default_parent     = "IssueHolder";
	private static $can_be_root        = false;

	public function getArticleHolder() {
		$holder = ArticleHolder::get()->First();

		if ($holder) {
			return $holder;
		}
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		return $fields;
	}

}

class Article_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}

}
