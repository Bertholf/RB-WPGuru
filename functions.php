<?php

/* Admin Head Section */
function rb_wpguru_admin_head(){
  if( is_admin() ) {
	echo "<link rel=\"stylesheet\" href=\"". rb_wpguru_URL ."/style/admin.css\" type=\"text/css\" media=\"screen\" />\n";
  }
}
add_action('admin_head', 'rb_wpguru_admin_head');


// ******************************  General Functions  ******************************** //

function rb_wpguru_random() {
	return preg_replace("/([0-9])/e","chr((\\1+112))",rand(100000,999999));
}

function rb_wpguru_safename($filename) {
	$filename =  rb_wpguru_whitespace($filename);
	$filename = str_replace(' ', '-', $filename); 
	$filename = preg_replace('/[^a-z0-9-.]/i','',$filename);
	$filename = str_replace('--', '-', $filename);	
	return strtolower($filename);
}

function rb_wpguru_getextension($filename) {
	$pos = strrpos($filename, '.');
	if($pos===false) {
		return false;
	} else {
		return substr($filename, $pos+1);
	}
}

function rb_wpguru_whitespace($string) {
	return preg_replace('/\s+/', ' ', $string);
}

// Format a string in proper case.
function rb_wpguru_propercase($someString) {
	return ucwords(strtolower($someString));
}

function rb_wpguru_convertdatetime($datetime) {
  if (isset($timestamp)) {
	// Convert
	list($date, $time) = explode(' ', $datetime);
	list($year, $month, $day) = explode('-', $date);
	list($hours, $minutes, $seconds) = explode(':', $time);
	
	$UnixTimestamp = mktime($hours, $minutes, $seconds, $month, $day, $year);
	return $UnixTimestamp;
  } else {
	//return "--";
  }
}

function rb_wpguru_makeago($timestamp){
  if (isset($timestamp) && !empty($timestamp)) {
	// Offset
	$timezone_offset = -7; // Server Time
	$time_altered = time() + $timezone_offset *60 *60;

	// Math
	$difference = $time_altered - $timestamp;
	
	//printf("\$timestamp: %d, \$difference: %d\n", $timestamp, $difference);
	$periods = array("sec", "min", "hr", "day", "week", "month", "year", "decade");
	$lengths = array("60","60","24","7","4.35","12","10");
	for($j = 0; $difference >= $lengths[$j]; $j++)
	$difference /= $lengths[$j];
	$difference = round($difference);
	if($difference != 1) $periods[$j].= "s";
	$text = "$difference $periods[$j] ago";
	return $text;
  } else {
	return "--";
  }
}

function rb_wpguru_makeagox($timestamp){

	return rb_empire_makeago(rb_empire_convertdatetime($timestamp), 7);
}



function rb_wpguru_formatcurrency($amount) {
	setlocale(LC_MONETARY, 'en_US');
	return number_format($amount, 2, '.', ',');
}

function rb_wpguru_formatdate($date) {
	$formattedDate = date("M j, Y", strtotime($date));
	return $formattedDate;
}

function rb_wpguru_formatdateshort($date) {
	$formattedDate = date("M j", strtotime($date));
	return $formattedDate;
}

function rb_wpguru_offsetdate($date) {
	$timezone_offset = -10; // Hawaii Time
	$date = strtotime($date);
	$date = gmdate('F d, Y h:mA', $date + $timezone_offset *60 *60);
	return $date;
}

function rb_wpguru_date($offset) {
	if ($offset) {
		$timezone_offset = $offset;
	} else {
		$timezone_offset = -10; // Hawaii Time
	}
	$date = gmdate('Y-m-d H:i:s', time() + $timezone_offset *60 *60);
	return $date;
}

function rb_wpguru_dateAdd($offset,$addDay) {
	if ($offset) {
		$timezone_offset = $offset;
	} else {
		$timezone_offset = -10; // Hawaii Time
	}
	$date = mktime(date("H"),date("i"),date("s"),date("m"),date("d")+$addDay,date("Y"));	
	$date = gmdate('Y-m-d H:i:s', $date + $timezone_offset *60 *60);
	return $date;
}

function rb_wpguru_getAge($p_strDate) {
	list($Y,$m,$d) = explode("-",$p_strDate);
	return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

// ******************************  Post Excerpt  ******************************** //

function rb_wpguru_contentexcerpt($PageID){

	if (!empty($post->post_excerpt)) {
	// If there is an excerpt for the post, show it...
	the_excerpt();
	// echo "<a href=\"". get_permalink($post->ID) ."\">Read More</a>";
	} else {
	// Otherwise lets strip images and truncate the post
	$truncate = $post->post_content;
	$truncate = preg_replace('@\[caption[^\]]*?\].*?\[\/caption]@si', '', $truncate);

	if ( strlen($truncate) <= $amount ) $echo_out = ''; else $echo_out = '... <a href="'. get_permalink($post->ID) .'">Read More</a>';
	$truncate = apply_filters('the_content', $truncate);
	$truncate = preg_replace('@<script[^>]*?>.*?</script>@si', '', $truncate);
	$truncate = preg_replace('@<style[^>]*?>.*?</style>@si', '', $truncate);
	$truncate = strip_tags($truncate);
	$truncate = substr($truncate, 0, 200);
	echo ($truncate . $echo_out);
	}


}

// ******************************  Admin Edit  ******************************** //

function rb_wpguru_pageedit($PageID){
	global $user_ID; 
	if( $user_ID ) {
	  if( current_user_can('level_10') ) {
		  echo "<div class=\"wpguru-panel-edit transparent\"><a href=\"". admin_url() ."post.php?post=". $PageID ."&action=edit\">Edit Area</a></div>\n";
	  }
	}
}

function rb_wpguru_pageshow($PageID){
  //  if(function_exists('rb_wpguru_pageshow')) rb_wpguru_pageshow(4);
  if (isset($PageID)) {
	$Page = get_page($PageID);
	echo "<div class=\"wpguru-panel pageid-". $PageID ."\">\n";
	echo apply_filters('the_content', $Page->post_content);
	rb_wpguru_pageedit($PageID);
	echo "</div>\n";
  }
}

// ******************************  Required for Plugin Install  ******************************** //

if (is_admin()) {	
	global $wp_version;
	
	if (strpos($wp_version, '-')) { //beta versions, etc
		define('IPI_WP_VERSION', substr($wp_version, 0, strpos($wp_version, '-')));
	} else {
		define('IPI_WP_VERSION', $wp_version);
	}
	
	register_activation_hook(__FILE__, 'ipi_activate');

	add_filter('install_plugins_nonmenu_tabs', 'ipi_extra_tabs');
	add_action('install_plugins_ipi_url', 'ipi_url');
		
}

function ipi_activate() {
	if (version_compare(IPI_WP_VERSION, '2.7', '<')) {
		deactivate_plugins(__FILE__); 
		wp_die(__('Wordpress 2.7 or greater is required for this plugin to function.'));		
	}
	
	add_option('ipi_code', wp_rand());
}

function ipi_extra_tabs($tabs) {
	$tabs[] = 'ipi_url';
	
	return $tabs;
}

function ipi_url() {
	check_admin_referer('plugin-ipi_url');
	
	if (!is_user_logged_in()) {
		wp_die(__('You are not logged in.', 'improved_plugin_installation')); 	
	} else if (!current_user_can('install_plugins')) {
		wp_die(__('You do not have the necessary administrative rights to be able to install plugins.', 'improved_plugin_installation'));
	} 
	
	if (!empty($_REQUEST['pluginurls'])) {
		if (is_array($_REQUEST['pluginurls'])) {
			$urls = $_REQUEST['pluginurls'];
		} else {
			$urls = explode("\n", $_REQUEST['pluginurls']);
		}
	} else if (!empty($_REQUEST['pluginurl'])) {
		$urls = array($_REQUEST['pluginurl']);
	} else {
		wp_die(__('No data supplied.'));
	}
	
	$urls = array_unique($urls);
	
	$correct = $errors = 0;
	
	if (get_filesystem_method() != 'direct') {
		global $wp_filesystem;
		
		$credentials_url = 'plugin-install.php?tab=ipi_url&';
		
		foreach ($urls as $url) {
			$credentials_url .= '&pluginurls[]=' . urlencode($url);
		}
				
		$credentials_url = wp_nonce_url($credentials_url, 'plugin-ipi_url');
				
		if ( false === ($credentials = request_filesystem_credentials($credentials_url)) ) //preload the credentials in $_POST.. 
			return;
					
		if ( ! WP_Filesystem($credentials) ) {
			request_filesystem_credentials($credentials_url, '', true); //Failed to connect, Error and request again
			return;
		}
		
		if ( $wp_filesystem->errors->get_error_code() ) {
			foreach ( $wp_filesystem->errors->get_error_messages() as $message )
				show_message($message);
			return;
		}
	}
		
	foreach ($urls as $url) {
		if (!$url = trim(stripslashes(trim($url, "\r")))) {
			continue;
		}
		
		//name of plugin
		if (!preg_match('/http:\/\//i', $url, $match)) {
			$plugin_name = $url;
		//url of plugin on wordpress.org	
		} else if (preg_match('/downloads\.wordpress\.org\/plugin\/([^\.]+)(.*)\.zip/i', $url, $match) || preg_match('/wordpress\.org\/extend\/plugins\/([^\/]*)\/?/i', $url, $match)) {
			$plugin_name = stripslashes($match[1]);
		} else {
			$plugin_name = false;
		}
		
		if ($plugin_name) {
			$plugin = ipi_get_plugin_information($plugin_name);
			
			if (is_wp_error($plugin)) {
				$errors++;
				
				$code    = $plugin->get_error_code();
				$message = $plugin->get_error_message();
				
			
				if (count($urls) == 1) {
					if ($code == 'plugins_api_failed') {
						echo '<p>' . __('Couldn\'t install plugin, perhaps you misspelled the name?', 'improved_plugin_installation') . '</p>';
					} else {
						echo '<p>' . $message . '</p>';
					}
				} else {
					echo '<div class="wrap">';
					echo '<h2>', sprintf( __('Installing Plugin: %s'), attribute_escape($url)), '</h2>';
				
					if ($code == 'plugins_api_failed') {
						echo '<p>' . __('Couldn\'t install plugin, perhaps you misspelled the name?', 'improved_plugin_installation') . '</p>';
					} else {
						echo '<p>' . $message . '</p>';
					}
					echo '</div>';
				}
			} else {
				$correct++;
				
				$_REQUEST['plugin_name']  = $plugin->name;
				$_REQUEST['download_url'] = $plugin->download_link;

				echo '<div class="wrap">';
				echo '<h2>', sprintf( __('Installing Plugin: %s'), $plugin->name . ' ' . $plugin->version ), '</h2>';

				ipi_do_plugin_install($plugin->download_link, $plugin);
				echo '</div>';
			}
		//URL of plugin on third party site
		} else {
			$correct++;
			
			echo '<div class="wrap">';
			echo '<h2>', sprintf( __('Installing Plugin: %s'), attribute_escape($url)), '</h2>';

			ipi_do_external_plugin_install($url);
			echo '</div>';
		} 
	}
	
	if (!$correct && !$errors) {
		echo '<p>' . __('No valid data supplied.', 'improved_plugin_installation') . '</p>';
	}
}

function ipi_get_plugin_information($plugin) {
	$plugin = strtolower(trim(preg_replace("/\s+/", ' ', $plugin)));
			
	$api = plugins_api('plugin_information', array('slug' => $plugin, 'fields' => array('sections' => false, 'description' => false) ) ); 
	
	if (is_wp_error($api)) {
		$api = plugins_api('query_plugins', array('search' => $plugin, 'per_page' => 1, 'fields' => array('sections' => false, 'description' => false ) ) ); 
		
		if (!is_wp_error($api)) {
			if (!empty($api->plugins[0])) {	
				$api = $api->plugins[0];
				
				if (preg_match('/^' . preg_quote(trim($plugin), '/') . '/i', trim($api->name) )) {		
					/*
					//cant use this, download link not always in the same format.. Have to do another request.
					if (strpos($api->version, '.') === 0) {
						$api->version = '0' . $api->version;
					}
					
					$api->download_link = 'http://downloads.wordpress.org/plugin/' . $api->slug . '.' . trim($api->version, '.') . '.zip';
					*/
					
					$plugin = $api->slug;
										
					$api = plugins_api('plugin_information', array('slug' => $plugin, 'fields' => array('sections' => false, 'description' => false) ) ); 
				} else {
					$api = new WP_Error('plugins_api_failed');
				}
			} else {
				$api = new WP_Error('plugins_api_failed' );
			}
		}
	}
		
	return $api;
}

function ipi_do_plugin_install($download_url, $api) {
	if (function_exists('do_plugin_install')) {
		do_plugin_install($download_url, $api);
	} else {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	
		$upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin( compact('title', 'nonce', 'url', 'plugin') ) );
		$success = $upgrader->install($download_url);
	}
}

function ipi_do_external_plugin_install($download_url) {
	global $wp_filesystem;

	if ( empty($download_url) ) {
		show_message( __('No plugin Specified') );
		return;
	}
	
	if (function_exists('wp_install_plugin')) {
		$result = wp_install_plugin( $download_url, 'show_message' );
	} else {
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		
		$upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin( compact('title', 'nonce', 'url', 'plugin') ) );
	 	$upgrader->install($download_url);
	}
	
	if ( is_wp_error($result) ) {
		show_message($result);
		show_message( __('Installation Failed') );
	} else {
		show_message( sprintf(__('Successfully installed the plugin <strong>%s </strong>.'), $download_url) );
	}
}


// ******************************  Custom Dashboard  ******************************** //

// Create the function to output the contents of our Dashboard Widget
function rb_wpguru_dashboard_tutorial() {
	// Tutorial Widget
	$update = true;
	$num_items = isset($widget_options['rb_wpguru_dashboard_tutorial']['items']) ? $widget_options['rb_wpguru_dashboard_tutorial']['items'] : 10;
	$widget_options['rb_wpguru_dashboard_tutorial'] = array(
		'home' => get_option('home'),
		'link' => apply_filters( 'rb_wpguru_dashboard_tutorial_link', 'http://blogsearch.google.com/blogsearch?scoring=d&partner=wordpress&q=link:' . trailingslashit( get_option('home') ) ),
		'url' => isset($widget_options['rb_wpguru_dashboard_tutorial']['url']) ? apply_filters( 'rb_wpguru_dashboard_tutorial_feed', $widget_options['rb_wpguru_dashboard_tutorial']['url'] ) : apply_filters( 'rb_wpguru_dashboard_tutorial_feed', 'http://vimeo.com/channels/wordpresswalkthrough/videos/rss' ),
		'items' => $num_items,
		'show_date' => isset($widget_options['rb_wpguru_dashboard_tutorial']['show_date']) ? $widget_options['rb_wpguru_dashboard_tutorial']['show_date'] : false
	);
	// Display Tutorial

	$rss = fetch_feed($widget_options['rb_wpguru_dashboard_tutorial']['url']);
	// Checks that the object is created correctly 
	if (!is_wp_error( $rss ) ) : 
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity($num_items); 
	
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items(0, $maxitems); 
	endif;
		echo "<div class=\"video-tutorials\">\n";
		if ($maxitems == 0) {
        	echo "Empty Feed\n";
        } else {
		  // Loop through each feed item and display each item as a hyperlink.
		  foreach ( $rss_items as $item ) {
			echo "  <div class=\"video-tutorial\">\n";
			echo "    <h4><a href='". $item->get_permalink() ."' title='Posted ". $item->get_date('j F Y | g:i a') ."'>". $item->get_title() ."</a></h4>\n";
			echo "    <div class=\"description\">". $item->get_description() ."</div>\n";
			echo "    <div class=\"clear\"></div>\n";
			echo "  </div>\n";
		  }
		}
		echo "</div>\n";
} 
function rb_wpguru_dashboard_tutorial_control() {
	wp_dashboard_rss_control( 'rb_wpguru_dashboard_tutorial', array( 'title' => false, 'show_summary' => false, 'show_author' => false ) );
}

 // Create the function to output the contents of our Dashboard Widget
function rb_wpguru_dashboard_quicklinks() {
	// Display Quicklinks
	$rb_wpguru_options_arr = get_option('rb_wpguru_options');
	if (isset($rb_wpguru_options_arr['dashboardQuickLinks'])) {
	  echo $rb_wpguru_options_arr['dashboardQuickLinks'];
	}
	$rss = fetch_feed("http://clearlym.com/feed/");
	// Checks that the object is created correctly 
		if (!is_wp_error($rss)) { 
		// Figure out how many total items there are, but limit it to 5. 
		$maxitems = $rss->get_item_quantity($num_items); 
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items(0, $maxitems); 
		}
		echo "<div class=\"feed-searchsocial\">\n";
		if ($maxitems == 0) {
        	echo "Empty Feed\n";
        } else {
		  // Loop through each feed item and display each item as a hyperlink.
		  foreach ( $rss_items as $item ) {
			echo "  <div class=\"blogpost\">\n";
			echo "    <h4><a href='". $item->get_permalink() ."' title='Posted ". $item->get_date('j F Y | g:i a') ."' target=\"_blank\">". $item->get_title() ."</a></h4>\n";
			echo "    <div class=\"description\">". $item->get_description() ."</div>\n";
			echo "    <div class=\"clear\"></div>\n";
			echo "  </div>\n";
		  }
		}
		echo "</div>\n";
		echo "<hr />\n";
		//echo "Need <a href=\"http://clearlym.com/services/seo-search-engine-optimization/\" target=\"_blank\" title=\"SEO Resource\">SEO Advice</a>?<br />";
} 

// Create the function use in the action hook
function rb_wpguru_add_dashboard() {
	global $wp_meta_boxes;
	// Create Dashboard Widgets
	wp_add_dashboard_widget('rb_wpguru_dashboard_quicklinks', 'Search meets Social', 'rb_wpguru_dashboard_quicklinks');
	wp_add_dashboard_widget('rb_wpguru_dashboard_tutorial', 'WordPress Tutorials', 'rb_wpguru_dashboard_tutorial', 'rb_wpguru_dashboard_tutorial_control');

	// reorder the boxes - first save the left and right columns into variables
	$left_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
	$right_dashboard = $wp_meta_boxes['dashboard']['side']['core'];
	
	// take a copy of the new widget from the left column
	$rb_wpguru_dashboard_merge_array = array("rb_wpguru_dashboard_quicklinks" => $left_dashboard["rb_wpguru_dashboard_quicklinks"], "rb_wpguru_dashboard_tutorial" => $left_dashboard["rb_wpguru_dashboard_tutorial"]);
	
	unset($left_dashboard['rb_wpguru_dashboard_quicklinks']); // remove the new widget from the left column
	unset($left_dashboard['rb_wpguru_dashboard_tutorial']); // remove the new widget from the left column
	$right_dashboard = array_merge($rb_wpguru_dashboard_merge_array, $right_dashboard); // use array_merge so that the new widget is pushed on to the beginning of the right column's array  
	
	// finally replace the left and right columns with the new reordered versions
	$wp_meta_boxes['dashboard']['normal']['core'] = $left_dashboard; 
	$wp_meta_boxes['dashboard']['side']['core'] = $right_dashboard;
}
// Hoook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'rb_wpguru_add_dashboard' );


function rb_wpguru_current_user_role() {
    global $current_user;
    get_currentuserinfo();
    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);
    return $user_role;
};


// ******************************  Cleanup Dashboard  ******************************** //
function rb_wpguru_dashboardcleanup() {
  // Globalize the metaboxes array, this holds all the widgets for wp-admin
  global $wp_meta_boxes;
  if(rb_wpguru_current_user_role() == 'subscriber') {
	//Right Now - Comments, Posts, Pages at a glance
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  }
	//Recent Comments
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	//Incoming Links
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	//Quick Press Form
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	//Plugins - Popular, New and Recently updated Wordpress Plugins
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	//Recent Drafts List
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);  
	//Wordpress Development Blog Feed
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	//Other Wordpress News Feed
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
//add our function to the dashboard setup hook
add_action('wp_dashboard_setup', 'rb_wpguru_dashboardcleanup');

// ******** END ****** //

// ******************************  Pagination  ******************************** //

class rb_wpguru_pagination {
		/*Default values*/
		var $total_pages = -1;//items
		var $limit = null;
		var $target = ""; 
		var $page = 1;
		var $adjacents = 2;
		var $showCounter = false;
		var $className = "pagination";
		var $parameterName = "page";
		var $urlF = false;//urlFriendly

		/*Buttons next and previous*/
		var $nextT = "Next";
		var $nextI = "&#187;"; //&#9658;
		var $prevT = "Previous";
		var $prevI = "&#171;"; //&#9668;

		/*****/
		var $calculate = false;
		
		#Total items
		function items($value){$this->total_pages = (int) $value;}
		
		#how many items to show per page
		function limit($value){$this->limit = (int) $value;}
		
		#Page to sent the page value
		function target($value){$this->target = $value;}
		
		#Current page
		function currentPage($value){$this->page = (int) $value;}
		
		#How many adjacent pages should be shown on each side of the current page?
		function adjacents($value){$this->adjacents = (int) $value;}
		
		#show counter?
		function showCounter($value=""){$this->showCounter=($value===true)?true:false;}

		#to change the class name of the pagination div
		function changeClass($value=""){$this->className=$value;}

		function nextLabel($value){$this->nextT = $value;}
		function nextIcon($value){$this->nextI = $value;}
		function prevLabel($value){$this->prevT = $value;}
		function prevIcon($value){$this->prevI = $value;}

		#to change the class name of the pagination div
		function parameterName($value=""){$this->parameterName=$value;}

		#to change urlFriendly
		function urlFriendly($value="%"){
				if(eregi('^ *$',$value)){
						$this->urlF=false;
						return false;
					}
				$this->urlF=$value;
			}
		
		var $pagination;

		function pagination(){}
		function show(){
				if(!$this->calculate)
					if($this->calculate())
						echo "<div class=\"$this->className\">$this->pagination</div>\n";
			}
		function getOutput(){
				if(!$this->calculate)
					if($this->calculate())
						return "<div class=\"$this->className\">$this->pagination</div>\n";
			}
		function get_pagenum_link($id){
				if(strpos($this->target,'?')===false)
						if($this->urlF)
								return str_replace($this->urlF,$id,$this->target);
							else
								return "$this->target?$this->parameterName=$id";
					else
						return "$this->target&$this->parameterName=$id";
			}
		
		function calculate(){
				$this->pagination = "";
				$this->calculate == true;
				$error = false;
				if($this->urlF and $this->urlF != '%' and strpos($this->target,$this->urlF)===false){
						//Es necesario especificar el comodin para sustituir
						echo "Especificaste un wildcard para sustituir, pero no existe en el target<br />";
						$error = true;
					}elseif($this->urlF and $this->urlF == '%' and strpos($this->target,$this->urlF)===false){
						echo "Es necesario especificar en el target el comodin % para sustituir el número de página<br />";
						$error = true;
					}

				if($this->total_pages < 0){
						echo "It is necessary to specify the <strong>number of pages</strong> (\$class->items(1000))<br />";
						$error = true;
					}
				if($this->limit == null){
						echo "It is necessary to specify the <strong>limit of items</strong> to show per page (\$class->limit(10))<br />";
						$error = true;
					}
				if($error)return false;
				
				$n = trim($this->nextT.' '.$this->nextI);
				$p = trim($this->prevI.' '.$this->prevT);
				
				/* Setup vars for query. */
				if($this->page) 
					$start = ($this->page - 1) * $this->limit;             //first item to display on this page
				else
					$start = 0;                                //if no page var is given, set start to 0
			
				/* Setup page vars for display. */
				$prev = $this->page - 1;                            //previous page is page - 1
				$next = $this->page + 1;                            //next page is page + 1
				$lastpage = ceil($this->total_pages/$this->limit);        //lastpage is = total pages / items per page, rounded up.
				$lpm1 = $lastpage - 1;                        //last page minus 1
				
				/* 
					Now we apply our rules and draw the pagination object. 
					We're actually saving the code to a variable in case we want to draw it more than once.
				*/
				
				if($lastpage > 1){
						if($this->page){
								//anterior button
								if($this->page > 1)
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($prev)."\" class=\"prev\">$p</a>";
									else
										$this->pagination .= "<span class=\"disabled\">$p</span>";
							}
						//pages	
						if ($lastpage < 7 + ($this->adjacents * 2)){//not enough pages to bother breaking it up
								for ($counter = 1; $counter <= $lastpage; $counter++){
										if ($counter == $this->page)
												$this->pagination .= "<span class=\"current\">$counter</span>";
											else
												$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
									}
							}
						elseif($lastpage > 5 + ($this->adjacents * 2)){//enough pages to hide some
								//close to beginning; only hide later pages
								if($this->page < 1 + ($this->adjacents * 2)){
										for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++){
												if ($counter == $this->page)
														$this->pagination .= "<span class=\"current\">$counter</span>";
													else
														$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
											}
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//in middle; hide some front and some back
								elseif($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)){
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($lastpage)."\">$lastpage</a>";
									}
								//close to end; only hide early pages
								else{
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_pagenum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++)
											if ($counter == $this->page)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_pagenum_link($counter)."\">$counter</a>";
									}
							}
						if($this->page){
								//siguiente button
								if ($this->page < $counter - 1)
										$this->pagination .= "<a href=\"".$this->get_pagenum_link($next)."\" class=\"next\">$n</a>";
									else
										$this->pagination .= "<span class=\"disabled\">$n</span>";
									if($this->showCounter)$this->pagination .= "<div class=\"pagination_data\">($this->total_pages Pages)</div>";
							}
					}

				return true;
			}
	}


// ******************************  Sub Menu Links  ******************************** //
function rb_wpguru_submenu($post) {
    $top_post = $post;
    // If the post has ancestors, get its ultimate parent and make that the top post
    if ($post->post_parent && $post->ancestors) {
        $top_post = get_post(end($post->ancestors));
    }
    // Always start traversing from the top of the tree
    return rb_wpguru_submenu_getchildren($top_post, $post);
}

function rb_wpguru_submenu_haschildren($post) {
	$children = get_pages('child_of='.$post->ID);
	if( count( $children ) != 0 ) { return true; } else { return false; }
}

function rb_wpguru_submenu_getchildren($post, $current_page) {
    $menu = '';
    // Get all immediate children of this page
    $children = get_pages('child_of=' . $post->ID . '&parent=' . $post->ID . '&sort_column=menu_order&sort_order=ASC');
    if ($children) {
        $menu = "\n<ul>\n";
        foreach ($children as $child) {
            // If the child is the viewed page or one of its ancestors, highlight it
            if (in_array($child->ID, get_post_ancestors($current_page)) || ($child->ID == $current_page->ID)) {
                $menu .= '<li class="active"><a href="' . get_permalink($child) . '" class="active"><strong>' . $child->post_title . '</strong></a>';
            } else {
                $menu .= '<li><a href="' . get_permalink($child) . '">' . $child->post_title . '</a>';
            }
            // If the page has children and is the viewed page or one of its ancestors, get its children
            if (get_children($child->ID) && (in_array($child->ID, get_post_ancestors($current_page)) || ($child->ID == $current_page->ID))) {
                $menu .= rb_wpguru_submenu_getchildren($child, $current_page);
            }
            $menu .= "</li>\n";
        }
        $menu .= "</ul>\n";
    }
    return $menu;
}


// ******************************  Get Links  ******************************** //
function rb_wpguru_getsociallink( $type ) {
	$rb_wpguru_options_arr = get_option('rb_wpguru_options');
	$GLOBALS['comment'] = $type;
	switch($type) {
	  case 'facebook':
		return $rb_wpguru_options_arr['linkSocialFacebook']; 
	  break;

	  case 'twitter':
		return $rb_wpguru_options_arr['linkSocialTwitter']; 
	  break;

	  case 'youtube':
		return $rb_wpguru_options_arr['linkSocialYouTube']; 
	  break;

	  case 'rss':
		return $rb_wpguru_options_arr['linkSocialRSS']; 
	  break;

	  case 'linkedin':
		return $rb_wpguru_options_arr['linkSocialLinkedIn']; 
	  break;

	  case 'custom1':
		return $rb_wpguru_options_arr['linkCustom1']; 
	  break;

	  case 'custom2':
		return $rb_wpguru_options_arr['linkCustom2']; 
	  break;
	}
	
}


?>