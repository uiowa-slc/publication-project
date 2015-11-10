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

	public function updateURLSegment($url, $title) {
		return "guhh";

	}

	public function NextPage() {
		$page = Page::get()->filter(array(
				'ParentID'         => $this->owner->ParentID,
				'Sort:GreaterThan' => $this->owner->Sort,
			))->First();

		return $page;
	}
	public function PreviousPage() {
		$page = Page::get()->filter(array(
				'ParentID'      => $this->owner->ParentID,
				'Sort:LessThan' => $this->owner->Sort,
			))->Last();

		return $page;
	}

}
