<?php
class Article extends Page {
	private static $db = array(
		'FormattedTitle' => 'HTMLText',
		'Citation'       => 'HTMLText',
		'ExpandedText'   => 'HTMLText',
	);

	private static $has_one = array(
		'Image'            => 'Image',
		'PrintableArticle' => 'File',
		'ResponseTo'       => 'Article',
		'FeaturedTag'      => 'ArticleTag',
	);
	private static $has_many = array(
		'Responses' => 'Article',
	);

	private static $plural_name = 'Articles';

	private static $belongs_many_many = array(
		'Authors' => 'Author',
	);
	private static $many_many = array(
		'Categories' => 'ArticleCategory',
		'Tags'       => 'ArticleTag',
		'Footnotes'  => 'Footnote',
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
		$fields->removeByName('Content');
		$titleField = new HTMLEditorField('FormattedTitle', 'Formatted Article Title (if the title has formatting)');
		$titleField->setRows(1);
		$fields->addFieldToTab('Root.Main', $titleField);

		//Article summary/expanded/downloadable text - Article Text
		$fields->addFieldToTab('Root.ArticleText', new UploadField('PrintableArticle', 'Downloadable/printable version of the article'));
		$fields->addFieldToTab('Root.ArticleText', new HTMLEditorField('Content', 'Article summary text or an entire short article'));
		$fields->addFieldToTab('Root.ArticleText', HTMLEditorField::create('ExpandedText', 'Article full text (don\'t include the summary from the field above)')->setRows(40));

		//Author field - ArticleInfo
		$authorFieldConfig = GridFieldConfig_RelationEditor::create();
		$authorGridField   = new GridField('Authors', 'Authors', $this->Authors(), $authorFieldConfig);
		$fields->addFieldToTab('Root.ArticleInfo', new LabelField('Search for an existing author (if they\'ve previously contributed to ILR) or add one below'));
		$fields->addFieldToTab('Root.ArticleInfo', $authorGridField);

		//Citation field - ArticleInfo
		$fields->addFieldToTab('Root.ArticleInfo', HTMLEditorField::create('Citation', 'Citation')->setRows(1));

		//Responses field - ArticleInfo
		$responseFieldConfig = GridFieldConfig_RelationEditor::create();
		$responseFieldConfig->removeComponentsByType($responseFieldConfig->getComponentByType('GridFieldAddNewButton'));
		$responseGridField = new GridField('Responses', 'Responses', $this->Responses(), $responseFieldConfig);

		if ($this->ID == 0) {
			$fields->addFieldToTab('Root.ArticleInfo', new LabelField('<strong>Note: You need to save a draft of this article before adding an author</strong><br />'));
		}

		$tagField = TagField::create('Tags', 'Tags', ArticleTag::get(), $this->Tags())->setShouldLazyLoad(true);

		$catField = DropdownField::create(
			'ArticleTagID',
			'Featured tag (You must add tags and save this article before adding tags)',
			$this->Tags()->map('ID', 'Title')
		);

		$fields->addFieldToTab('Root.Main', new UploadField('Image', 'Image (1920x1080 or 1280x720)'));

		$fields->addFieldToTab('Root.ArticleInfo', $tagField);
		$fields->addFieldToTab('Root.ArticleInfo', $catField);

		$fields->addFieldToTab('Root.ArticleInfo', $responseGridField);

		$footnoteFieldConfig = GridFieldConfig_RelationEditor::create();
		$footnoteGridField   = new GridField('Footnotes', 'Footnotes', $this->Footnotes(), $footnoteFieldConfig);
		$fields->addFieldToTab('Root.Footnotes', $footnoteGridField);

		return $fields;
	}

	protected function parseSuperscriptFootnotes($content) {
		$dom              = new DOMDocument;
		$contentConverted = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
		@$dom->loadHTML($contentConverted);
		foreach ($dom->getElementsByTagName('sup') as $node) {

			$nodeInitValue = $node->nodeValue;
			$node->setAttribute('id', 'fnref:'.$nodeInitValue);

			$node->nodeValue = null;

			$newANode = $dom->createElement('a', $nodeInitValue);
			$newANode->setAttribute('href', '#fn:'.$nodeInitValue);
			$newANode->setAttribute('rel', 'footnote');

			$node->appendChild($newANode);

			$dom->saveXML($node);

		}
		return $dom->saveXML();
	}

	protected function onBeforeWrite() {

		$summary = $this->Content;
		$full    = $this->ExpandedText;

		$this->Content      = $this->parseSuperscriptFootnotes($summary);
		$this->ExpandedText = $this->parseSuperscriptFootnotes($full);

		parent::onBeforeWrite();
	}
	public static function footnoteHandler($arguments, $content, $parser = null, $Footnotes) {

		$number = $arguments['#'];
		return '<sup id="fnref:'.$number.'">
        		<a href="#fn:'.$number.'" rel="footnote">'.$number.'</a>
   		 </sup>';

	}
}

class Article_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}

}
