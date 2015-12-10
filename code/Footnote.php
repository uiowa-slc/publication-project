<?php

class Footnote extends DataObject {

	private static $db = array(
		'Number' => 'Int',
		'Content' => 'HTMLText',
	);


	private static $belongs_many_many = array(
		'Articles' => 'Article',
	);

	private static $summary_fields = array(
		'Number',
		'Content',
	);


}