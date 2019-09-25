<?php

use SilverStripe\Admin\ModelAdmin;

class AuthorAdmin extends ModelAdmin {

	private static $menu_title = 'Authors';

	private static $url_segment = 'authors';

	private static $managed_models = array(
		'Contributor',
	);

}