<?php

use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\CMS\Search\SearchForm;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Control\Session;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\Core\Extension;
class PublicationPage_Controller extends Extension {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>ff
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
	public function SearchForm() {
		$searchText =  _t('SearchForm.SEARCH', 'Search');

		if($this->owner->getRequest() && $this->owner->getRequest()->getVar('Search')) {
			$searchText = $this->owner->getRequest()->getVar('Search');
		}

		$fields = new FieldList(
			new TextField('Search', false, $searchText)
		);
		$actions = new FieldList(
			new FormAction('results', _t('SearchForm.GO', 'Go'))
		);
		$form = SearchForm::create($this->owner, SearchForm::class, $fields, $actions);
		$form->classesToSearch(array(SiteTree::class));
		return $form;
	}
	public function results($data, $form, $request) {
		$templateData = array();
		if(!$form->getSearchQuery()){
			return $this->owner->renderWith(array('Page_results', 'Page'));

		}
			$keyword = DBField::create_field('Text', $form->getSearchQuery());
			
			$contributors = new ArrayList();

			$keywordTrimmed = trim($keyword->getValue());


			$contributors = $this->contributorSearch($keywordTrimmed);

			$templateData = array(
				'Contributors' => $contributors,
				'Results' => $form->getResults(),
				'Query' => DBField::create_field('Text', $form->getSearchQuery()),
				'Title' => _t('SearchForm.SearchResults', 'Search Results'),
			);

			// Debug::show($data);
			return $this->owner->customise($templateData)->renderWith(array('Page_results', 'Page'));
		
	}

	public function contributorSearch($keyword) {

		$contributors = Contributor::get()->filterAny(array(
			'Name:PartialMatch' => $keyword,
		));

		//Debug::show($contributors);

		return $contributors;

	}	
	function StatusMessage() {
		if (Session::get('ActionMessage')) {
			$message = Session::get('ActionMessage');
			$status  = Session::get('ActionStatus');

			Session::clear('ActionStatus');
			Session::clear('ActionMessage');

			return new ArrayData(array('Message' => $message, 'Status' => $status));
		}

		return false;
	}

	public function getBlog() {
		return NewsHolder::get()->First();
	}

	public function Pages() {
		$pages = Page::get();

		if ($pages) {
			return $pages;
		} else {
			return false;
		}

	}

	public function FeaturedIssue() {
		$homePage = HomePage::get()->First();
		if (isset($homePage)) {
			return $homePage->FeaturedIssue();
		}
	}
	public function getCurrentIssue() {
		$sessionIssue = Session::get('issue');
		if (empty($sessionIssue)) {
			$currentIssue = HomePage::get()->First();
			$sessionIssue = $currentIssue->FeaturedIssue();
		}
		return $sessionIssue;
	}

	public function getAllIssues() {
		$issueArray = Issue::get();
		return $issueArray;
	}

	public function getEmblem() {
		$two  = 'one';
		$page = Director::get_current_page();

		while (($page) && ($page->ClassName != "Issue")) {
			$page = $page->Parent;
		}
		if ($page) {
			return $page;
		}

	}
}