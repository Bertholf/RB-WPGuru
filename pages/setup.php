<?php
	global $wpdb;
	$rb_wpguru_options_arr = get_option('rb_wpguru_options');
?>
<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>WordPress Guru Initial Setup</h2>
  <p>You are using version <b><?php echo $rb_wpguru_options_arr['databaseVersion']; ?></b></p>

  <div class="boxblock-holder">
    <div class="boxblock-container" style="width: 46%;">
 
     <div class="boxblock">
        <h3>Standard Configuration</h3>
        <div class="inner">
		<?php
		if ($rb_wpguru_options_arr['initialSetup'] != true) {
			global $wpdb;
			$table = $wpdb->prefix."options";
			$results = $wpdb->get_results("SELECT * FROM $table WHERE option_name = 'blogdescription'");
				foreach($results as $optiondata){
					if (isset($optiondata->option_value)) {
						
						$wpdb->query("UPDATE $table SET option_value = '' WHERE option_name = 'blogdescription'");
	
					} elseif ($optiondata->option_value == "Just another WordPress weblog") {
					
						$wpdb->query("UPDATE $table SET option_value = '' WHERE option_name = 'blogdescription'");
	
					}
				}
	
			// Change the start of the week to Monday
			$wpdb->query("UPDATE $table SET option_value = '0' WHERE option_name = 'start_of_week'");
			echo "Start Day of the Week is now Sunday<br />\n";
	
			// Change Permalinks
			$wpdb->query("UPDATE $table SET option_value = '/%category%/%postname%/' WHERE option_name = 'permalink_structure'");
			echo "Permalink Structure is updated to <strong>/%category%/%postname%/</strong><br />\n";
	
			// Update Page
			$wpdb->query("UPDATE $table SET option_value = 'page' WHERE option_name = 'show_on_front'");
			  //  IDENTIFY PAGE  $wpdb->query("UPDATE $table SET option_value = 'page' WHERE option_name = 'page_on_front'");
			echo "Make homepage a page<br />\n";
	
			// Kill Avatars
			$wpdb->query("UPDATE $table SET option_value = '0' WHERE option_name = 'show_avatars'");
			$wpdb->query("UPDATE $table SET option_value = 'blank' WHERE option_name = 'avatar_defaults'");
			echo "Avatars killed<br />\n";
	
			// Update Default Post
			//$defaultPost = "New website launched."; 
			//$wpdb->query("UPDATE wp_posts SET post_title = 'Website Relaunched!', post_content = '" . $defaultPost . "', post_name  = 'seo-expert' WHERE ID = '1'");
	
			// Update Page
			//$defaultPage = "New website launched."; 
			//$wpdb->query("UPDATE wp_posts SET post_title = 'Home', post_content = '" . $defaultPage . "', post_name = 'home', menu_order = '1' WHERE ID = '2'");
			//echo "Page content reset<br />\n";
	
			// Update Static Home Page
			$wpdb->query("UPDATE $table SET option_value = 'page' WHERE option_name = 'show_on_front'");
			$wpdb->query("UPDATE $table SET option_value = '2' WHERE option_name = 'page_on_front'");
			echo "Set Static Homepage<br />\n";
	
			// Update Page
			$user_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users;"));
			echo '<p>User count is ' . $user_count . '</p>';
	
			// Set Initial Setup to Complete
			$rb_wpguru_options_arr = array("initialSetup" => true);
			update_option('rb_wpguru_options', $rb_wpguru_options_arr);
      	} else {
			echo "WordPress is setup according to RB standards.<br />";
		}
      	?>
        </div>
     </div>
    
    </div><!-- .container -->
  
    <div class="boxblock-container" style="width: 46%;">
 
     <div class="boxblock">
        <h3>Actions</h3>
        <div class="inner">
		   <?php
            ?>
        </div>
     </div>

    </div><!-- .container -->


    <div class="clear"></div>

    <div class="boxblock-container" style="width: 93%;">

     <div class="boxblock">
        <div class="inner">
            <p>WordPress Plugins by <a href="http://rbplugin.com/wordpress/rb-wpguru/" target="_blank">ClearlyM</a>.</p>
        </div>
     </div>
     
    </div><!-- .container -->

</div>
</div>
