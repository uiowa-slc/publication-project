<?php
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

	function StatusMessage() {
		if (Session::get('ActionMessage')) {
			$message = Session::get('ActionMessage');
			$status = Session::get('ActionStatus');

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
		return $homePage->FeaturedIssue();
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
		$two = 'one';
		$page = Director::get_current_page();

		while (($page) && ($page->ClassName != "Issue")) {
			$page = $page->Parent;
		}
		if ($page) {
			return $page;
		}

	}
}