<?php

/**
 * Main plugin file
 */

/**
 * Plugin Name:       JMWP: Insert postmeta tool
 * Author:            Jan Macario
 * Plugin URI:        https://github.com/janmacario/jmwp-plugin-tool-insert-postmeta
 * Description:       Insert postmeta tool
 * Version:           0.9
 */


// Exit if this file is not called directly.
if (!defined('WPINC')) {
	die;
}

// Set up auto-updates
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
'https://github.com/janmacario/jmwp-plugin-tool-insert-postmeta/',
__FILE__,
'jmwp-plugin-tool-insert-postmeta'
);

// admin menu
include('php/admin-menu.php');

// admin page
include('php/admin-page.php');
