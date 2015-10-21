<?php

class ArchivePage extends Page {
	
	private static $db = array(
	);
	
	private static $has_one = array(
	);
	
	private static $allowed_children = array("Issue");
	
}

class ArchivePage_Controller extends Page_Controller {
	
	public function init() {
		parent::init();
	}
	
}

?>