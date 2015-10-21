<?php

class NewsPage extends BlogPost {
	private static $default_parent = 'NewsHolderPage';
	private static $db = array(
		'Date' => 'SS_Datetime',
		'Abstract' => 'Text',
		'Author' => 'Varchar(255)'
	);

	private static $defaults = array(
		'InheritSideBar' => true
	);
}

class NewsPage_Controller extends Page_Controller {
	
}