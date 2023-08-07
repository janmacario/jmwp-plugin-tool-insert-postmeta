<?php

/**
 * Summary: php file which implements the plugin WP admin menu changes
 */


/**
 * Adds CPME admin menu item to Wordpress admin menu as a top-level item
 */
add_action('admin_menu', 'jmwp_add_admin_menu');

// Function to add CPME admin menu item. If this shared function does not exist already, define it now.
if (!function_exists('jmwp_add_admin_menu')) {

	function jmwp_add_admin_menu() {

		// Add Wordpress admin menu item for jmwp stuff

		// If the JMWP top-level admin menu item does not exist already, add it.
		if (menu_page_url('jmwp', false) == false) {

			// Add top admin menu page
			add_menu_page(
				'JM WordPress',
				'JM WordPress',
				'manage_options',
				'jmwp',
				function(){
					echo "<div class='wrap'>";
					echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>';
					echo '<p>Please use the links at left to access JMWP WordPress platform features.</p>';
					echo "</div>";
				},
				'dashicons-admin-generic',
				1
			);

		}

	}

}

/**
 * Adds link to 'insert postmeta tool' page to Wordpress admin menu as a sub-menu item under JMWP
 */
add_action('admin_menu', 'jmwp_add_sublevel_menu_insert_postmeta_tool');
function jmwp_add_sublevel_menu_insert_postmeta_tool() {

	// Add Wordpress admin menu item under JMWP
	add_submenu_page(
		'jmwp',
		'Postmeta Insert Tool',
		'Postmeta Insert Tool',
		'manage_options',
		'jmwp_postmeta_insert_tool',
		'jmwp_admin_page_postmeta_insert_tool',
		1
	);

}
