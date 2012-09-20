<?php
	global $wpdb;
	$rb_wpguru_options_arr = get_option('rb_wpguru_options');
?>
<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>WordPress Guru Overview</h2>
  <p>You are using version <b><?php echo $rb_wpguru_options_arr['databaseVersion']; ?></b></p>

  <div class="boxblock-holder">
    <div class="boxblock-container" style="width: 46%;">
 
     <div class="boxblock">
        <h3>Actions</h3>
        <div class="inner">

            <p class="sub"></p>
            <div id="pledgers_list">
            </div>
        </div>
     </div>
    
    </div><!-- .container -->
  
    <div class="boxblock-container" style="width: 46%;">
 
     <div class="boxblock">
        <h3>Actions</h3>
        <div class="inner">
		   <?php
            //echo "<a href='?page=pledge_pledges'>Manage Pledges</a> - Manage various types of pledges.<br>";
            ?>
        </div>
     </div>
    
     <div class="boxblock">
        <h3>Steps</h3>
        <div class="inner">
            <p class="sub"></p>
            <div id="pledgers_list">

            </div>
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
