<?php
defined('ABSPATH') || exit;

if ( ! class_exists( 'ET_Builder_Element' ) ) {
	return;
}

$module_files = glob( __DIR__ . '/modules/*/*.php' );

// Load custom Divi Builder modules
foreach ( (array) $module_files as $module_file ) {
	if ( $module_file ) {
		require_once $module_file;
	}
}