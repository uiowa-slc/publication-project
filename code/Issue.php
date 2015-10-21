<?php
class Issue extends Page {

	private static $db = array(

		"IssueDate" => "Text",
		"IssueNumber" => "Text",
		"LetterFromEditorCustomTitle" => "Text",
		"LetterFromEditor" => "HTMLText",

	);

	private static $has_one = array(
		"Emblem" => "Image",
	);

	private static $plural_name = 'Issues';

	/* Deprecated but still needed for older issues until they're migrated */
	private static $many_many = array(
		"Articles" => "Article",
	);

	private static $default_parent = "IssueHolder";

	private static $can_be_root = false;

	private static $allowed_children = array('Article');

	//private static $icon = array("mysite/images/tree/toc","file");

	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Metadata');
		$fields->removeByName('Content');
		$fields->addFieldToTab("Root.Main", new UploadField("Emblem", "Unique image for issue"));
		$fields->addFieldToTab("Root.Main", $dateField = new TextField("IssueDate", "Issue date"));
		$fields->addFieldToTab("Root.Main", new TextField("IssueNumber", "Issue number"));
		$fields->addFieldToTab("Root.Main", new TextField("LetterFromEditorCustomTitle", "Letter From The Editors Custom Title (optional)"));
		$fields->addFieldToTab("Root.Main", new HTMLEditorField("LetterFromEditor", "Letter From The Editors"));

		return $fields;
	}

	public function Articles() {
		return $this->Children();
	}

	public function getLetterTitle() {
		if ($this->LetterFromEditorCustomTitle) {
			return $this->LetterFromEditorCustomTitle;
		} else {
			return "Letter From The Editor";
		}
	}

	public function getLetterLink() {
		return $this->Link() . 'letter/';
	}

	public function RandomArticles() {
		return SiteTree::get()->filter('ParentID', $this->ID)->sort('RAND()');
	}

}

class Issue_Controller extends Page_Controller {

	private static $allowed_actions = array("letter");

	private static $url_handlers = array(
		'letter' => 'letter',
	);

	public function init() {
		parent::init();
		//print_r($this->getClassName());
		//Session::set('issue', Issue::get_by_id('Issue', $this->ID));
	}

	public function letter() {
		$letterText = $this->LetterFromEditor;
		if ($letterText) {

			$Data = array(
				'Content' => $letterText,
				'Parent' => $this,
				'ClassName' => 'Article',
				'NextPage' => $this->Children()->First,
				'PreviousPage' => Page::get()->filter(array('URLSegment' => 'home'))->First,
			);

		} else {
			$Data = array('LetterText' => "");
		}

		return $this->Customise($Data)->renderWith(array('Issue_letter', 'Page'));
	}

}
