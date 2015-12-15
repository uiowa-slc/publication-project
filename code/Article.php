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
		'Footnotes' => 'Footnote'
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

		//Main Content tab.
		$fields->removeByName('Content');
		$fields->removeByName('Metadata');
		$titleField = new HTMLEditorField('FormattedTitle', 'Formatted Article Title (only fill out if the article title uses bold, italics, etc.)');
		$titleField->setRows(1);
		$fields->addFieldToTab('Root.Main', $titleField);

		//Tag and Featured tag fields - ArticleInfo tab
		$tagField = TagField::create('Tags', 'Tags', ArticleTag::get(), $this->Tags())->setShouldLazyLoad(true);
		$catField = DropdownField::create(
			'FeaturedTagID',
			'Featured tag (shows above the article\'s title)',
			$this->Tags()->map('ID', 'Title')
		)->setEmptyString('(No featured tag)');

		$fields->addFieldToTab('Root.Main', new UploadField('Image', 'Image (1920x1080 or 1280x720)'));

		if ($this->Tags()->First()) {
			$fields->addFieldToTab('Root.ArticleInfo', $catField);
		} else {
			$fields->addFieldToTab('Root.ArticleInfo', new ReadonlyField('FeaturedTagReadonly', 'Featured tag (shows above article title)'));
			$fields->addFieldToTab('Root.ArticleInfo', new LabelField('FeaturedTagLabel', ' Note: You must add tags and save this article before adding a featured tag.'));
		}
		$fields->addFieldToTab('Root.ArticleInfo', $tagField);

		//Author field - ArticleInfo tab
		$authorFieldConfig = GridFieldConfig_RelationEditor::create();
		$authorGridField   = new GridField('Authors', 'Authors', $this->Authors(), $authorFieldConfig);
		$fields->addFieldToTab('Root.ArticleInfo', new LabelField('Search for an existing author (if they\'ve previously contributed to ILR) or add one below.'));
		$fields->addFieldToTab('Root.ArticleInfo', $authorGridField);

		//Citation field - ArticleInfo tab
		$fields->addFieldToTab('Root.ArticleInfo', HTMLEditorField::create('Citation', 'Citation')->setRows(1));

		//Article summary/expanded/downloadable text - Article Text tab
		$fields->addFieldToTab('Root.ArticleText', new UploadField('PrintableArticle', 'Downloadable/printable version of the article'));
		$fields->addFieldToTab('Root.ArticleText', new HTMLEditorField('Content', 'Article summary text or an entire short article'));
		$fields->addFieldToTab('Root.ArticleText', HTMLEditorField::create('ExpandedText', 'Article full text (don\'t include the summary from the field above)')->setRows(40));

		//Footnotes field - Footnotes tab
		$footnoteFieldConfig = GridFieldConfig_RelationEditor::create();
		$footnoteGridField   = new GridField('Footnotes', 'Footnotes', $this->Footnotes(), $footnoteFieldConfig);
		$fields->addFieldToTab('Root.Footnotes', $footnoteGridField);

		//Responses field - Responses tab
		$responseFieldConfig = GridFieldConfig_RelationEditor::create();
		$responseFieldConfig->removeComponentsByType($responseFieldConfig->getComponentByType('GridFieldAddNewButton'));
		$responseGridField = new GridField('Responses', 'Responses', $this->Responses(), $responseFieldConfig);

		$fields->addFieldToTab('Root.Responses', $responseGridField);

		// Return fields
		return $fields;
	}
	//Old Parser, keeping for reference.
	// protected function parseSuperscriptFootnotes($content) {
	// 	$dom              = new DOMDocument;
	// 	$contentConverted = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
	// 	@$dom->loadHTML($contentConverted);
	// 	foreach ($dom->getElementsByTagName('sup') as $node) {

	// 		$nodeInitValue = $node->nodeValue;
	// 		$node->setAttribute('id', 'fnref:'.$nodeInitValue);

	// 		$node->nodeValue = null;

	// 		$newANode = $dom->createElement('a', $nodeInitValue);
	// 		$newANode->setAttribute('href', '#fn:'.$nodeInitValue);
	// 		$newANode->setAttribute('rel', 'footnote');

	// 		$node->appendChild($newANode);

	// 		$dom->saveXML($node);

	// 	}
	// 	return $dom->saveXML();
	// }
	protected function parseSuperscriptFootnotes($content) {

		$dom              = new DOMDocument;
		$contentConverted = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
		@$dom->loadHTML($contentConverted);

		$xpath = new DOMXPath($dom);
		
		//Parse the superscripts
		$wordSuperscripts = $xpath->query('//a[contains(@href,"#_ftn")]/@href');
		foreach($wordSuperscripts as $wordSuperscript){
			//$wordSuperscript->removeChild();
			$parentNode = $wordSuperscript->parentNode;

			$parentNodeInitValue = $parentNode->nodeValue;
			$parentNodeFormattedVal = str_replace(array('[',']'), array('',''), $parentNode->nodeValue);

			$wordSuperscript->nodeValue = '#fn:'.$parentNodeFormattedVal;
			$parentNode->setAttribute('rel', 'footnote');
			$parentNode->nodeValue = $parentNodeFormattedVal;

			//print_r($parentNode);

	// 		$newANode->setAttribute('rel', 'footnote');
		}

		//Parse the footnotes at the end of the document.
		$footnotes = $xpath->query('//*[contains(@class, "FootNote")]');
		foreach($footnotes as $footnote){
			//$fnAnchor = $footnote->parentNode;
			//$fnAnchorParent = $fnAnchor->parentNode;

			//$fnText = $fnAnchorParent->nodeValue;
			$footnoteValue = $footnote->nodeValue;

			preg_match_all("^\[(.*?)\]\\.^.", $footnoteValue, $footnoteNumbers);

			foreach($footnoteNumbers[1] as $footnoteNumber){
				echo $footnoteNumber.'<br />';
				if(is_numeric($footnoteNumber)){
					
					$footnoteContent = str_replace(array('['.$footnoteNumber.'].','&nbsp;'),array('',''), $footnoteValue);
					$footnoteTest = Footnote::get()->filter(array('Number' => $footnoteNumber, 'ArticleID' => $this->ID))->First();

					if(!isset($footnoteTest)){
						$footnoteObject = new Footnote();
						$footnoteObject->ArticleID = $this->ID;
						$footnoteObject->Number = $footnoteNumber;
						$footnoteObject->Content = $footnoteContent;
						$footnoteObject->write();
						echo "wrote ".$footnoteObject->Number." <br />";
					}

				}
			}
			//print_r($footnoteValue.'<br />');
			

			//$footnoteTest = Footnote::get()->filter(array('Name' -> $))

			//$fnAnchorParent->parentNode->removeChild($fnAnchorParent);

		}
		




		//echo $dom->saveXML();
		//return $dom->saveXML();
	}

	protected function onBeforeWrite() {

		$summary = $this->Content;
		$full    = $this->ExpandedText;

		// $this->Content      = $this->parseSuperscriptFootnotes($summary);
		// $this->ExpandedText = $this->parseSuperscriptFootnotes($full);

		parent::onBeforeWrite();
	}

}

class Article_Controller extends Page_Controller {


	public function init() {

		echo $this->parseSuperscriptFootnotes($this->Content);


		parent::init();
	}

}
