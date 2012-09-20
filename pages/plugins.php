<?php
$PluginNames = 
"Admin Management Xtended
CMS Tree Page View
Google Analytics for WordPress
WordPress SEO
jQuery Lightbox Balupton Edition
Contact Form 7
Redirection
Widget Logic
Search and Replace
WordPress.com Stats
Google Sitemap Generator
Link to Post
Page Links To
Clean Notifications
WP Super Cache
Category Posts Widget
Really Simple CAPTCHA
WP Facebook Open Graph protocol";

// Unpack the theme
if (is_dir("../wp-content/plugins/rb-wpguru/plugins/gravityforms")) {
	rename("../wp-content/plugins/rb-wpguru/plugins/gravityforms","../wp-content/plugins/gravityforms/"); 
	echo "Gravity forms has been copied over.<br />\n";
}

?>
<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>WordPress Guru Dashboard</h2>
  <p>You are using version <b><?php echo rb_wpguru_version; ?></b></p>

  <div class="boxblock-holder">
    <div class="boxblock-container" style="width: 95%;">
 
     <div class="boxblock">
        <h3>Super Plugin Installer</h3>
        <div class="inner">
		<?php
		add_filter('install_plugins_nonmenu_tabs', 'ipi_extra_tabs');
		add_action('install_plugins_ipi_url', 'ipi_url');
		?>
        <h4><?php _e('Install plugins from URL/name', 'improved_plugin_installation') ?></h4>
        <p><?php _e('Type the plugin names, the wordpress plugin page URLs, or the direct URLs to the zip files. (One on each line)', 'improved_plugin_installation') ?></p>
        <form method="post" action="<?php echo admin_url('plugin-install.php?tab=ipi_url') ?>">
            <?php wp_nonce_field( 'plugin-ipi_url') ?>
            <textarea name="pluginurls" rows="10" cols="100"><?php echo $PluginNames; ?></textarea>
            <input type="submit" class="button" value="<?php _e('Install Now') ?>" style="display:block;margin-top:5px;" />
        </form>
        </div>
     </div>
    
    </div><!-- .container -->
  
    <div class="boxblock-container" style="width: 46%;">
 
    
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
