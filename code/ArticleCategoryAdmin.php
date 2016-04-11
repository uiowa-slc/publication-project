<?php

class ArticleCategoryAdmin extends ModelAdmin {

	private static $menu_title = 'Categories';

	private static $url_segment = 'categories';

	private static $managed_models = array(
		'ArticleCategory',
	);

}