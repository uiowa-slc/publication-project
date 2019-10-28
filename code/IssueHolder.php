<?php

use SilverStripe\ORM\ArrayList;
class IssueHolder extends Page {

	private static $db = array(

	);

	private static $has_one = array(

	);

	private static $allowed_children = array("Issue");

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		return $fields;
	}

	public function SortedChildren() {
		$list = $this->Children()->sort(array('Volume' => 'DESC', 'Number' => 'DESC'));
		return $list;
	}
	//needs to be in issue:
	public function getVolumes() {

		$volumeNumbers = array(); //this has to be an array
		$issues = Issue::get()->filter(array('ParentID' => $this->ID));
		$allVolumes = new ArrayList();

		//get all of the volume numbers
		foreach ($issues as $issue) {

			$volumeNumbers[] = $issue->Volume;
		}
		//$volumeNumbers->removeDuplicates();
		$volNumbers = array_unique($volumeNumbers); //-->use this for filtering once volnums is an array
		rsort($volNumbers); //sort volumes new->old
		//Debug::show($volNumbers);

		//create a volume object for each volume number
		//create an ArrayList of issues for each volume object
		foreach ($volNumbers as $number) {
			$volume = new Volume();
			$volume->Number = $number;
			$volume->Issues = new ArrayList();
			//add the issues in this volume to the correct volume object
			foreach ($issues as $issue) {
				if ($issue->Volume == $number) {
					$volume->Issues->add($issue);
				}
			}
			$allVolumes->add($volume);
			//Debug::show($volume);

		}
		//Debug::show($allVolumes);
		return $allVolumes;
	}

}
