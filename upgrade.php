<?php
$rb_wpguru_options_arr = get_option('rb_wpguru_options');

// Upgrade from 1.0
if ($rb_wpguru_options_arr["databaseVersion"] == "1.1") {


	// Updating version number!
	$rb_wpguru_options_arr = array("databaseVersion" => "2.0");
	update_option('rb_wpguru_options', $rb_wpguru_options_arr);
	
// Upgrade from 1.0
} elseif ($rb_wpguru_options_arr["databaseVersion"] == "2.1") {




} 
?>