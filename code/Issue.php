<?php
class Issue extends Page {

	private static $db = array(
		"Volume" => "Int",
		"Date" => "Text",
		"Number" => "Int",
		"OriginalPublicationDate" => "Date",
	);

	private static $has_one = array(
		"CoverImage" => "Image",
	);

	private static $plural_name = 'Issues';
	private static $default_parent = "IssueHolder";
	private static $can_be_root = false;
	// private static $default_sort = array('Volume'=>'DESC', 'Number'=>'DESC');

	private static $allowed_children = array('Article');

	//private static $icon = array("mysite/images/tree/toc","file");

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Content');
		$fields->addFieldToTab('Root.Main', new TextField('Volume'));
		$fields->addFieldToTab('Root.Main', new TextField('Number', 'Issue Number'));
		$fields->addFieldToTab('Root.Main', new TextField('Date', 'Issue Date'));

		return $fields;
	}

	public function getArticles() {
		return $this->Children();
	}

	public function getRandomArticles() {
		return SiteTree::get()->filter('ParentID', $this->ID)->sort('RAND()');
	}

	public function IsFirstIssueInVolume(){
		$issueTest = Issue::get()->filter(array(
			'Volume' => $this->Volume,
			'ParentID' => $this->ParentID,
			'Number:LessThan' => $this->Number

		))->First();
		//Debug::show($issueTest);
		if($issueTest){
			return false;
		}else{
			return true;
		}
	}

	public function IsLastIssueInVolume(){
		$issueTest = Issue::get()->filter(array(
			'Volume' => $this->Volume,
			'ParentID' => $this->ParentID,
			'Number:GreaterThan' => $this->Number

		))->First();
		if($issueTest){
			return false;
		}else{
			return true;
		}
	}

	public function PreviousIssue() {
		if($this->IsFirstIssueInVolume()){
			// echo "this is the first issue in a volume";
			$issue = Issue::get()->filter(array(
				'ClassName' => 'Issue',
				'ParentID' => $this->ParentID,
				'Volume:LessThan' => $this->Volume
			))->sort(array('Number DESC', 'Volume DESC'))->First();
		}else{

			$issue = Issue::get()->filter(array(
				'Volume' => $this->Volume,
				'ParentID' => $this->ParentID,
				'Number:LessThan' => $this->Number
			))->sort('Number DESC')->First();
		}

		if($issue){
			return $issue;
		}else{
			return false;
		}
	}

	public function NextIssue() {
		if($this->IsLastIssueInVolume()){
			//echo "this is the last issue in a voluem";
			$issue = Issue::get()->filter(array(
				'ClassName' => 'Issue',
				'ParentID' => $this->ParentID,
				'Volume:GreaterThan' => $this->Volume
			))->sort(array('Number DESC', 'Volume DESC'))->Last();
		}else{
			$issue = Issue::get()->filter(array(
				'Volume' => $this->Volume,
				'ParentID' => $this->ParentID,
				'Number:GreaterThan' => $this->Number
			))->sort('Number DESC')->Last();
		}

		if($issue){
			return $issue;
		}else{
			return false;
		}
	}

}

class Issue_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}

}
