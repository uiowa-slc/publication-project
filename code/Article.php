<?php

use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\TagField\TagField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;
class Article extends Page {
	private static $db = array(

		'FormattedTitle' => 'HTMLText',
		'Citation' => 'HTMLText',
		'ExpandedText' => 'HTMLText',
		'IsExcerpt' => 'Boolean',
		'JointAuthorNotes' => 'HTMLText',

	);

	private static $has_one = array(
		'Image' => Image::class,
		'PrintableArticle' => File::class,
		'ResponseTo' => 'Article',
		'FeaturedTag' => 'ArticleTag',
		'Category' => 'ArticleCategory',
	);
	private static $has_many = array(
		'Responses' => 'Article',
		'Footnotes' => 'Footnote',
	);

	private static $plural_name = 'Articles';

	private static $belongs_many_many = array(
		'Authors' => 'Author',
	);
	private static $many_many = array(

		'Tags' => 'ArticleTag',
		'Footnotes' => 'Footnote',
	);
	private static $listing_page_class = 'Issue';
	private static $show_in_sitetree = false;
	private static $default_parent = "IssueHolder";
	private static $can_be_root = false;

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

	public function getSortedAuthors(){
		
		$authors = $this->obj('Authors')->sort('SortOrder');
		return $authors;
	}

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		//Main Content tab.
		$fields->removeByName('Content');
		$fields->removeByName('Metadata');
		$fields->addFieldToTab('Root.Main', new CheckboxField('IsExcerpt', 'This article is a stub (a short version or simply a link to the PDF).'));

		$titleField = new HTMLEditorField('FormattedTitle', 'Formatted Article Title (only fill out if the article title uses bold, italics, etc.)');
		$titleField->setRows(1);
		$fields->addFieldToTab('Root.Main', $titleField);

		//Tag and Featured tag fields - ArticleInfo tab
		$tagField = TagField::create('Tags', 'Tags:', ArticleTag::get(), $this->Tags())->setShouldLazyLoad(true);
		$catField = DropdownField::create(
			'CategoryID',
			'Category',
			ArticleCategory::get()->map('ID', 'Title')
		)->setEmptyString('(No Category)');

		$fields->addFieldToTab('Root.Main', new UploadField(Image::class, 'Image (1920x1080 or 1280x720)'));
		$fields->addFieldToTab('Root.ArticleInfo', $tagField);
		$fields->addFieldToTab('Root.ArticleInfo', $catField);


		//Author field - ArticleInfo tab
		$authorFieldConfig = GridFieldConfig_RelationEditor::create();
		$authorFieldConfig->addComponent(new GridFieldSortableRows('SortOrder'));

		$authorGridField = new GridField('Authors', 'Authors', $this->Authors(), $authorFieldConfig);
		$fields->addFieldToTab('Root.ArticleInfo', new LabelField('Search for an existing author (if they\'ve previously contributed to ILR) or add an author to the website.'));
		$fields->addFieldToTab('Root.ArticleInfo', $authorGridField);

		//Joint Author Notes field - ArticleInfo tab
		$fields->addFieldToTab('Root.ArticleInfo', HTMLEditorField::create('JointAuthorNotes', 'Joint Author Notes')->setRows(2));

		//Citation field - ArticleInfo tab
		$fields->addFieldToTab('Root.ArticleInfo', HTMLEditorField::create('Citation', 'Citation')->setRows(1));

		//Article summary/expanded/downloadable text - Article Text tab

		$fields->addFieldToTab('Root.ArticleText', new UploadField('PrintableArticle', 'Downloadable/printable version of the article'));
		$fields->addFieldToTab('Root.ArticleText', HTMLEditorField::create('Content', 'Article body')->setRows(50));

		//Footnotes field - Footnotes tab
		$footnoteFieldConfig = GridFieldConfig_RelationEditor::create();
		$footnoteGridField = new GridField('Footnotes', 'Footnotes', $this->Footnotes(), $footnoteFieldConfig);
		$fields->addFieldToTab('Root.Footnotes', $footnoteGridField);

		//Responses field - Responses tab
		$responseFieldConfig = GridFieldConfig_RelationEditor::create();
		$responseFieldConfig->removeComponentsByType($responseFieldConfig->getComponentByType(GridFieldAddNewButton::class));
		$responseGridField = new GridField('Responses', 'Responses', $this->Responses(), $responseFieldConfig);

		$fields->addFieldToTab('Root.Responses', $responseGridField);

		// Return fields
		return $fields;
	}

}
