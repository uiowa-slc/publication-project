<?php

class Volume extends DataObject {

	private static $casting = array(
	    "Title" => 'Varchar',
	    "Number" => 'Int',
	 );


	private static $plural_name = 'Volumes';

	public function getIssues(){
		return Issue::get()->filter(array('Volume' => $this->Number));
	}

}