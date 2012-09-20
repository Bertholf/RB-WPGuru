<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>Social</h2>
  <a class="button-primary" href="?page=rb_wpguru_social&ConfigID=0" title="Overview">Overview</a>

<?php
if(!isset($_REQUEST['ConfigID']) && empty($_REQUEST['ConfigID'])){ $ConfigID=0;} else { $ConfigID=$_REQUEST['ConfigID']; }

if ($ConfigID == 0) {
?>

  <div class="boxlinkgroup">
    <h2>Settings</h2>
    <p>Set options</p>
      <div class="boxlink">
        <a class="button-primary" href="?page=rb_wpguru_social&ConfigID=1" title="Settings">Configure Social Icons</a><br />
      </div>
  </div>


<?php
}
elseif ($ConfigID == 1) {
//////////////////////////////////////////////////////////////////////////////////// ?>
  <h3>Settings</h3>
    	<?php
		$rb_wpguru_options_arr = get_option('rb_wpguru_options');
		?>

        <form method="post" action="options.php">
        <?php settings_fields('rb_wpguru-settings-group'); ?>
            <table class="form-table">
              <tr valign="top">
                <th scope="row"><?php _e('Facebook Link', 'rb_wpguru-plugin'); ?></th>
                <td><input type="text" name="rb_wpguru_options[linkSocialFacebook]" value="<?php echo $rb_wpguru_options_arr['linkSocialFacebook']; ?>" /><br />
                <code>&lt;?php if(function_exists('rb_wpguru_getsociallink')) { echo rb_wpguru_getsociallink("facebook"); } ?&gt;</code></td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php _e('Twitter Link', 'rb_wpguru-plugin'); ?></th>
                <td><input type="text" name="rb_wpguru_options[linkSocialTwitter]" value="<?php echo $rb_wpguru_options_arr['linkSocialTwitter']; ?>" /><br />
                <code>&lt;?php if(function_exists('rb_wpguru_getsociallink')) { echo rb_wpguru_getsociallink("twitter"); } ?&gt;</code></td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php _e('YouTube Link', 'rb_wpguru-plugin'); ?></th>
                <td><input type="text" name="rb_wpguru_options[linkSocialYouTube]" value="<?php echo $rb_wpguru_options_arr['linkSocialYouTube']; ?>" /><br />
                <code>&lt;?php if(function_exists('rb_wpguru_getsociallink')){  echo rb_wpguru_getsociallink("youtube"); } ?&gt;</code></td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php _e('RSS Link', 'rb_wpguru-plugin'); ?></th>
                <td><input type="text" name="rb_wpguru_options[linkSocialRSS]" value="<?php echo $rb_wpguru_options_arr['linkSocialRSS']; ?>" /><br />
                <code>&lt;?php if(function_exists('rb_wpguru_getsociallink')) { echo rb_wpguru_getsociallink("rss"); } ?&gt;</code></td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php _e('LinkedIn', 'rb_wpguru-plugin'); ?></th>
                <td><input type="text" name="rb_wpguru_options[linkSocialLinkedIn]" value="<?php echo $rb_wpguru_options_arr['linkSocialLinkedIn']; ?>" /><br />
                <code>&lt;?php if(function_exists('rb_wpguru_getsociallink')) { echo rb_wpguru_getsociallink("linkedin"); } ?&gt;</code></td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php _e('Custom 1', 'rb_wpguru-plugin'); ?></th>
                <td><input type="text" name="rb_wpguru_options[linkCustom1]" value="<?php echo $rb_wpguru_options_arr['linkCustom1']; ?>" /><br />
                <code>&lt;?php if(function_exists('rb_wpguru_getsociallink')) { echo rb_wpguru_getsociallink("custom1"); } ?&gt;</code></td>
              </tr>
              <tr valign="top">
                <th scope="row"><?php _e('Custom 2', 'rb_wpguru-plugin'); ?></th>
                <td><input type="text" name="rb_wpguru_options[linkCustom2]" value="<?php echo $rb_wpguru_options_arr['linkCustom2']; ?>" /><br />
                <code>&lt;?php if(function_exists('rb_wpguru_getsociallink')) { echo rb_wpguru_getsociallink("custom2"); } ?&gt;</code></td>
              </tr>
            </table>
            
            <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'rb_wpguru'); ?>" />
        </form>
    
<?php
}	 // End	
?>
</div>