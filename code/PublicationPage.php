<?php
class PublicationPage extends DataExtension {

	private static $db = array(
	);

	private static $has_one = array(
	);

	private static $has_many = array(

	);

	function getCMSFields() {
		$fields = parent::getCMSFields();
		return $fields;
	}

	public function NextPage() {
		$page = Page::get()->filter(array(
			'ParentID' => $this->ParentID,
			'Sort:GreaterThan' => $this->Sort,
		))->First();

		return $page;
	}
	public function PreviousPage() {
		$page = Page::get()->filter(array(
			'ParentID' => $this->ParentID,
			'Sort:LessThan' => $this->Sort,
		))->Last();

		return $page;
	}

}

