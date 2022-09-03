<?php

namespace BreadcrumbsBlock;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

class Breadcrumbs_Block {
	/**
	 * Loading all dependencies
	 * @return void
	 */
	public function load() {
		include_once 'includes/class-breadcrumb.php';
		include_once 'includes/class-linkbuilder.php';
		include_once 'includes/class-trail.php';
	}
}
