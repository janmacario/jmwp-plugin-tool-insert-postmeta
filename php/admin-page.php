<?php

/**
 * Summary: php file which implements the plugin WP admin page interface
 */


/**
 * Generates the plugin 'insert postmeta tool' page
 */
function jmwp_admin_page_postmeta_insert_tool() {

	// Only continue if this user has the 'manage options' capability
	if (!current_user_can('manage_options')) return;

	// Begin HTML output
	echo "<div class='wrap'>";

	// Page title
	echo "<h1>" . esc_html(get_admin_page_title()) . "</h1>";

	// start form
	echo '<form name="post_select" method="post" action="?page=jmwp_postmeta_insert_tool">';

	// get current post data
	$import_data = isset($_POST['import-data']) ? $_POST['import-data'] : '';
	$import_data_meta_key = isset($_POST['import-data-meta-key']) ? $_POST['import-data-meta-key'] : '';
	$import_data_acf_field_id = isset($_POST['import-data-acf-field-id']) ? $_POST['import-data-acf-field-id'] : '';

	// data to import
	echo '<h2>Enter Data to Import</h2>';
	
	echo '<p>2 fields. Tab separated.<br />Field 1: Post ID<br />Field 2: Postmeta value</p>';

	echo '<textarea id="textarea-import-data" name="import-data" placeholder="data to import" style="width:100%; height:10em;">'.$import_data.'</textarea>';

	echo '<p>meta_key: <input type="text" name="import-data-meta-key" placeholder="import data meta key" style="width:25%;"value="'.$import_data_meta_key.'" /></p>';
	echo '<p>ACF field ID?: <input type="text" name="import-data-acf-field-id" placeholder="ACF field ID" style="width:25%;"value="'.$import_data_acf_field_id.'" /></p>';

	// action buttons
	echo '<p><input type="submit" name="submit" value="Generate Postmeta Insert Script" /></p>';


	// do we have a form submission?
	if (isset($_POST['submit'])) {

		echo '<h2>Script Output</h2>';

		// are we missing import data?
		if (empty($import_data)) {

			// show message
			echo '<div class="notice notice-error is-dismissible"><p>No import data provided.</p></div>';

		}

		// are we missing a meta key?
		if (empty($import_data_meta_key)) {

			// show message
			echo '<div class="notice notice-error is-dismissible"><p>No meta key specified.</p></div>';

		}

		// are we good to go?
		if (!empty($import_data) && !empty($import_data_meta_key)) {

			/*
			// show messages
			echo '<div class="notice notice-info is-dismissible">';
			echo '<p>Meta key: '.$import_data_meta_key.'</p>';
			echo '<p>ACF field ID: '.$import_data_acf_field_id.'</p>';
			echo '<p>Import data:</p><pre>'.$import_data.'.</pre>';
			echo '</div>';
			*/

			// store import data text
			$import_data = $_POST['import-data'];

			// initialize variables 
			$output_script ='';

			// get lines of import data
			$import_data_lines = explode(PHP_EOL, $import_data);

			// loop through lines of import data and store to arrays
			foreach($import_data_lines as $import_data_line) {

				// extract data from input lines using regex

				//set up pattern
				$pattern = "/(.*)\t(.*)/";

				// get matches
				preg_match($pattern, $import_data_line, $matches);
				//print_r($matches);

				//trim and store matches
				$match1 = trim($matches[1]);
				$match2 = trim($matches[2]);

				$output_script_line_1 = 'INSERT INTO wp_postmeta (post_id,meta_key,meta_value) VALUES (' . $match1 . ', \''.$import_data_meta_key.'\', \'' . $match2 . '\');';
				$output_script_line_2 = 'INSERT INTO wp_postmeta (post_id,meta_key,meta_value) VALUES (' . $match1 . ', \'_'.$import_data_meta_key.'\', \''.$import_data_acf_field_id.'\');';

				$output_script .= $output_script_line_1 . PHP_EOL . $output_script_line_2 . PHP_EOL . PHP_EOL;

			}

			//begin output
			echo '<textarea id="textarea-output-data-script" name="output-data-script" placeholder="output script" style="width:100%; height:10em;">';
			echo $output_script;
			echo '</textarea>';

		}

	}

	// finish form
	echo '</form>';

	// Finish HTML output
	echo "</div>";

}
