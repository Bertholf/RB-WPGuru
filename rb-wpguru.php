<?php 
/*
  Plugin Name: RB WPGuru
  Plugin URI: http://code.bertholf.com/wordpress/rb-wpguru/
  Description: Let the WordPress Guru setup your site quickly!
  Author: Rob Bertholf
  Author URI: http://rob.bertholf.com/
  Version: 1.0
*/

if ( ! isset($GLOBALS['wp_version']) || version_compare($GLOBALS['wp_version'], '2.8', '<') ) { // if less than 2.8 ?>
<div class="error" style="margin-top:30px;">
<p><?php _e('This plugin requires WordPress version 2.8 or newer. Please upgrade your WordPress installation', 'tadv'); ?></p>
</div>
<?php
return;
}

// Plugin configuration variables
define('rb_wpguru_version', '2.1');
if (!defined('rb_wpguru_URL'))
	define('rb_wpguru_URL', get_option('siteurl').'/wp-content/plugins/rb-wpguru');
// Default Settings
if (!defined("rb_wpguru_uploaddir"))
	define("rb_wpguru_uploaddir", "/wp-content/uploads/");

// Call default functions
include_once(dirname(__FILE__).'/functions.php');
// Do we need a diaper change?
include_once(dirname(__FILE__).'/upgrade.php');
// Call Pages
include_once(dirname(__FILE__).'/pages/verify.php');

// *************************************************************************************************** //

// Creating tables on plugin activation
function rb_wpguru_install() {
	// Required for all WordPress database manipulations
	global $wpdb;
	
	// Set Options
	$rb_wpguru_options_arr = array(
		"databaseVersion" => rb_wpguru_version,
		"initialSetup" => false,
		"dashboardQuickLinks" => ""
		);
	// Update the options in the database
	update_option('rb_wpguru_options', $rb_wpguru_options_arr);

}

//Activate Install Hook
register_activation_hook(__FILE__,'rb_wpguru_install');

// *************************************************************************************************** //

// Action hook to register our option settings
add_action('admin_init', 'rb_wpguru_register_settings');

// Register our Array of settings
function rb_wpguru_register_settings() {
	register_setting('rb_wpguru-settings-group', 'rb_wpguru_options');
}
// *************************************************************************************************** //

//Activate Menu Hook
add_action('admin_menu','set_rb_wpguru_menu');

//Create Admin Menu
function set_rb_wpguru_menu(){
	add_menu_page("RB WPGuru","WPGuru",1,"rb_wpguru_menu","rb_wpguru_dashboard","div",3);
	add_submenu_page("rb_wpguru_menu","RB WPGuru Overview","Overview",1,"rb_wpguru_menu","rb_wpguru_dashboard");
	add_submenu_page("rb_wpguru_menu","RB WPGuru Initial Setup","Initial Setup",7,"rb_wpguru_setup","rb_wpguru_setup");
	//add_submenu_page("rb_wpguru_menu","RB WPGuru Design Setup","Design Setup",7,"rb_wpguru_design","rb_wpguru_design");
	add_submenu_page("rb_wpguru_menu","RB WPGuru Plugin Setup","Plugin Setup",7,"rb_wpguru_plugins","rb_wpguru_plugins");
	add_submenu_page("rb_wpguru_menu","RB WPGuru Navigation Setup","Navigation Setup",7,"rb_wpguru_pages","rb_wpguru_pages");
	add_submenu_page("rb_wpguru_menu","RB WPGuru Verify Sites","Verify Sites",7,"rb_wpguru_verify","rb_wpguru_verify");
	add_submenu_page("rb_wpguru_menu","RB WPGuru Social","Social",7,"rb_wpguru_social","rb_wpguru_social");
	add_submenu_page("rb_wpguru_menu","RB WPGuru Settings","Settings",7,"rb_wpguru_settings","rb_wpguru_settings");
}


//Pages
function rb_wpguru_dashboard(){
	include_once('pages/overview.php');
}
function rb_wpguru_setup(){
	include_once('pages/setup.php');
}
function rb_wpguru_design(){
	include_once('pages/design.php');
}
function rb_wpguru_plugins(){
	include_once('pages/plugins.php');
}
function rb_wpguru_pages(){
	include_once('pages/pages.php');
}
function rb_wpguru_settings(){
	include_once('pages/settings.php');
}
function rb_wpguru_social(){
	include_once('pages/social.php');
}
function rb_wpguru_verify(){
	include_once('pages/verify.php');
}


//Uninstall
function rb_wpguru_uninstall() {
	
	register_uninstall_hook(__FILE__, 'rb_wpguru_uninstall_hook');
	function rb_wpguru_uninstall_hook() {
		
		//delete_option('create_my_taxonomies');
	}

	// Final Cleanup
	$thepluginfile="rb-wpguru/rb-wpguru.php";
	$current = get_settings('active_plugins');
	array_splice($current, array_search( $thepluginfile, $current), 1 );
	update_option('active_plugins', $current);
	do_action('deactivate_' . $thepluginfile );

	echo "<div style=\"padding:50px;font-weight:bold;\"><p>Almost done...</p><h1>One More Step</h1><a href=\"plugins.php?deactivate=true\">Please click here to complete the uninstallation process</a></h1></div>";
	die;
}
?>