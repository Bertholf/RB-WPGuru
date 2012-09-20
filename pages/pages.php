<?php
	global $wpdb;

if (isset($_POST['action'])) {
	
	$PageNames = $_POST['PageNames'];
	$PageNames_array = split("\n", $PageNames);
	$ParentPageID = 0;
	
	// Loop Through Pages
	$table = $wpdb->prefix."posts";
	$results = $wpdb->get_results("SELECT menu_order FROM $table ORDER BY menu_order DESC LIMIT 1");
	foreach($results as $optiondata){
		$PageOrderNumber = $optiondata->menu_order;
	}

	// Loop Through Pages
	foreach ($PageNames_array as &$PageItem) {
		// Step up a notch
		$PageOrderNumber++;
		
		if (substr($PageItem, 0, 1) == "-") {
			$PageItem = substr($PageItem, 1);
			$SetParentSkip = true; 
		} else {
			$ParentPageID = 0;	
		}
		
		// Create post object
		global $user_ID;
		$new_post = array(
			'post_title' => $PageItem,
			'post_content' => 'Add Content Here',
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => $user_ID,
			'post_parent' => $ParentPageID,
			'post_type' => 'page',
			'menu_order' => $PageOrderNumber,
			'post_category' => array(0)
		);
		// Insert the post into the database
		$PageID = wp_insert_post($new_post);
		wp_publish_post($PageID);
		
		if (!$SetParentSkip) {
			$ParentPageID = $PageID;
		}

	}	
	
} else {
	
 $PageNames = "About Us\nServices\nLocations\nContact";
 
?>
<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>WordPress Guru Dashboard</h2>
  <p>You are using version <b><?php echo rb_wpguru_version; ?></b></p>

  <div class="boxblock-holder">
    <div class="boxblock-container" style="width: 46%;">
 
     <div class="boxblock">
        <h3>Setup Navigation</h3>
        <div class="inner">
            <form method="post" action="<?php echo str_replace('%7E', '~', $_SERVER['SCRIPT_NAME']) . "?page=" . $_GET['page']; ?>">
            <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Page Names:<br />(One per line)</th>
                    <td>
                        <textarea id="PageNames" name="PageNames" rows="10" cols="100"><?php echo $PageNames; ?></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit">
                <input type="hidden" value="addRecord" name="action" />
                <input type="submit" value="Submit" class="button-primary" name="Create Message Record"  />
            </p>
            </form>
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
            <p>WordPress Plugins by <a href="http://code.bertholf.com/wordpress/wp-guru/" target="_blank">Rob Bertholf</a>.</p>
        </div>
     </div>
     
    </div><!-- .container -->

</div>
</div>

<?php

}

