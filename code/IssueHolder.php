<?php
class IssueHolder extends Page {

	private static $db = array(

	);

	private static $has_one = array(

	);

	private static $extensions = array(
		'Lumberjack',
	);

	private static $allowed_children = array("Issue");

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		return $fields;
	}
}

class IssueHolder_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}

}
