<?php

class NewsHolder extends Blog {
	private static $allowed_children = array('NewsPage');
	private static $default_child = 'NewsPage';

}

class NewsHolder_Controller extends Blog_Controller {

	public function init() {
		parent::init();

	
	}

}