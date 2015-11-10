<?php
class Issue extends Page {

	private static $db = array(
		"IssueVolume" => "Int",
		"IssueDate"   => "Text",
		"IssueNumber" => "Text",
	);

	private static $has_one = array(
		"Emblem" => "Image",
	);

	private static $plural_name = 'Issues';

	private static $extensions = array(
		'Lumberjack',
	);

	private static $default_parent   = "IssueHolder";
	private static $show_in_sitetree = false;
	private static $can_be_root      = false;

	private static $allowed_children = array('Article');

	//private static $icon = array("mysite/images/tree/toc","file");

	function getCMSFields() {
		$fields = parent::getCMSFields();
		return $fields;
	}

	public function getArticles() {
		return $this->Children();
	}

	public function RandomArticles() {
		return SiteTree::get()->filter('ParentID', $this->ID)->sort('RAND()');
	}

}

class Issue_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}

}
