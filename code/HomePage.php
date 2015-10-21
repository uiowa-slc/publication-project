<?php
class HomePage extends Page {

	private static $db = array(

	
	);

	private static $has_one = array(
		'FeaturedIssue' => 'SiteTree'
	);
	
	function getCMSFields() {
	
		
		$fields = parent::getCMSFields();
		
		$fields->renameField('Content', 'Right side content (e.g., "What we\'re reading)');
		$fields->removeByName('LearnMorePageID'); //inherited from ExpressHomePage, I guess
		$fields->removeByName('Metadata');
		$fields->removeByName('Carousel');
		$fields->removeByName('Quicklinks');
		$fields->removeByName('Features');
		
		$treedropdownfield = new TreeDropdownField("FeaturedIssueID", "Newest/Featured Issue", "SiteTree");
		$fields->addFieldToTab('Root.Main', $treedropdownfield);
		
		return $fields;
	}	

}


class HomePage_Controller extends Page_Controller {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();

		// Note: you should use SS template require tags inside your templates 
		// instead of putting Requirements calls here.  However these are 
		// included so that our older themes still work
	}
	
	public function getDataObjectAsPage(){
		$set = DataObjectAsPage::get();
		return $set;
	}
	
	public function getNewsItems($limit = 3) {
		$holder = NewsPage::get()->limit($limit)->sort("Date DESC");
		return $holder;
	}
	
	public function getLetterEditor(){
	
	
		$siteTreeID = $this->FeaturedIssue()->ID; 
		$issue = Issue::get()->byID($siteTreeID);		
		$editorLetter = $issue->LetterFromEditor()->First();
		return $editorLetter;
	}
	
	public function getFeaturedIssue(){
		return $this->FeaturedIssue();
	}
	
	public function getFeaturedSegment(){
		return $this->FeaturedIssue()->URLSegment;
	}
	
	

	

}