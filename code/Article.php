<?php
class Article extends Page {
	private static $db = array(
		'FormattedTitle' => 'HTMLText',
		'Citation'       => 'HTMLText',
	);

	private static $has_one = array(
		'Image'            => 'Image',
		'PrintableArticle' => 'File',

		'FeaturedTag' => 'ArticleTag',
	);
	private static $plural_name       = 'Articles';
	private static $belongs_many_many = array(
		'Authors' => 'Author',
	);
	private static $many_many = array(
		'Categories' => 'ArticleCategory',
		'Tags'       => 'ArticleTag',
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
		$fields->addFieldToTab('Root.FormattedTitle', $titleField);

		$fields->addFieldToTab('Root.Citation', new HTMLEditorField('Citation', 'Citation'));

		$authorFieldConfig = GridFieldConfig_RelationEditor::create();
		$authorGridField   = new GridField('Authors', 'Authors', $this->Authors(), $authorFieldConfig);

		if ($this->ID == 0) {
			$fields->addFieldToTab('Root.Authors', new LabelField('<strong>Note: You need to save a draft of this article before adding an author</strong><br />'));
		}
		$fields->addFieldToTab('Root.Authors', new LabelField('Please search for an existing author first before adding a new one.'));
		$fields->addFieldToTab('Root.Authors', $authorGridField);

		$catField = TagField::create('Categories', 'Category', ArticleCategory::get(), $this->Tags())->setShouldLazyLoad(true);
		$catField->setIsMultiple(false);

		$tagField = TagField::create('Tags', 'Tags', ArticleTag::get(), $this->Tags())->setShouldLazyLoad(true);

		$fields->addFieldToTab('Root.Files', new UploadField('PrintableArticle', 'Download/Printable Version of the Article'));
		$fields->addFieldToTab('Root.Files', new UploadField('Image', 'Image (1920x1080 or 1280x720)'));

		$fields->addFieldToTab('Root.Main', $catField, 'Content');
		$fields->addFieldToTab('Root.Main', $tagField, 'Content');
		return $fields;
	}

}

class Article_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}

}
