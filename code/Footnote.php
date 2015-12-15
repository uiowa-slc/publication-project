<?php

class Footnote extends DataObject {

	private static $db = array(
		'Number' => 'Int',
		'Content' => 'HTMLText',
	);


	private static $has_one = array(
		'Article' => 'Article',
	);

	private static $summary_fields = array(
		'Number',
		'Content',
	);


}