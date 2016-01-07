<?php
class Issue extends Page {

	private static $db = array(
		"Volume"                  => "Int",
		"Date"                    => "Text",
		"Number"                  => "Text",
		"OriginalPublicationDate" => "Date",
	);

	private static $has_one = array(
		"CoverImage"        => "Image",
		"MastheadImage"     => "Image",
		"PrintableMasthead" => "File",
	);

	private static $plural_name = 'Issues';
	private static $default_parent = "IssueHolder";
	private static $can_be_root    = false;
	// private static $default_sort = array('Volume'=>'DESC', 'Number'=>'DESC');

	private static $allowed_children = array('Article');

	//private static $icon = array("mysite/images/tree/toc","file");

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Content');
		$fields->addFieldToTab('Root.Main', new TextField('Volume'));
		$fields->addFieldToTab('Root.Main', new TextField('Number', 'Issue Number'));

		$fields->addFieldToTab('Root.Main', new TextField('Date', 'Issue Date'));
		$fields->addFieldToTab('Root.Main', DateField::create('OriginalPublicationDate', 'Original publish date (not shown, only for internal purposes)')
			->setConfig('showcalendar', true));

		$fields->addFieldToTab('Root.Masthead', new UploadField('MastheadImage', 'Image version of the Masthead'));
		$fields->addFieldToTab('Root.Masthead', new UploadField('PrintableMasthead', 'Printable version of the Masthead (PDF format recommended)'));
		$fields->addFieldToTab('Root.Masthead', new HTMLEditorField('Content', 'Masthead text'));

		return $fields;
	}

	public function getArticles() {
		return $this->Children();
	}

	public function getRandomArticles() {
		return SiteTree::get()->filter('ParentID', $this->ID)->sort('RAND()');
	}


}

class Issue_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}

}
