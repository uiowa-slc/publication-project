<?php
class Article extends Page {
	private static $db = array(
		'FormattedTitle' => 'HTMLText',
		'Citation'       => 'Text',
	);

	private static $has_one = array(
		'Image'            => 'Image',
		'PrintableArticle' => 'File',
	);
	private static $plural_name       = 'Articles';
	private static $belongs_many_many = array(
		'Authors' => 'Author',
	);
	private static $many_many = array(

		'Tags' => 'ArticleTag',
	);
	private static $listing_page_class = 'Issue';
	private static $show_in_sitetree   = false;
	private static $default_parent     = "IssueHolder";
	private static $can_be_root        = false;

	public function getArticleHolder() {
		$holder = ArticleHolder::get()->First();

		if ($holder) {
			return $holder;
		}
	}

	public function getArticleTitle() {

		if ($this->FormattedTitle) {
			return $this->FormattedTitle;
		} else {
			return $this->dbObject('Title');
		}

	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$titleField = new HTMLEditorField('FormattedTitle', 'Formatted Article Title (if the title has formatting)');
		$titleField->setRows(1);

		$authorFieldConfig = GridFieldConfig_RelationEditor::create();
		$authorGridField   = new GridField('Authors', 'Authors', $this->Authors(), $authorFieldConfig);
		$fields->addFieldToTab('Root.Authors', $authorGridField);

		$fields->addFieldToTab('Root.Main', $titleField, 'Content');
		$fields->addFieldToTab('Root.Files', new UploadField('Image', 'Image (1920x1080 or 1280x720)'));
		$fields->addFieldToTab('Root.Files', new UploadField('PrintableArticle', 'Download/Printable Version of the Article'));

		$tagField = TagField::create('Tags', 'Tags', ArticleTag::get(), $this->Tags())->setShouldLazyLoad(true);

		$fields->addFieldToTab('Root.Main', $tagField, 'Content');
		return $fields;
	}

}

class Article_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}


}
