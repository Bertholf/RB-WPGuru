<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>Settings</h2>
  <a class="button-primary" href="?page=rb_wpguru_settings&ConfigID=0" title="Overview">Overview</a>

<?php
if( isset($_REQUEST['action']) && !empty($_REQUEST['action']) ) {
	if($_REQUEST['action'] == 'douninstall') {
		rb_wpguru_uninstall();
	}
}

if(!isset($_REQUEST['ConfigID']) && empty($_REQUEST['ConfigID'])){ $ConfigID=0;} else { $ConfigID=$_REQUEST['ConfigID']; }

if ($ConfigID == 0) {
?>

  <div class="boxlinkgroup">
    <h2>Settings</h2>
    <p>Set options</p>
      <div class="boxlink">
        <a class="button-primary" href="?page=rb_wpguru_settings&ConfigID=1" title="Settings">Configure Settings</a><br />
      </div>
  </div>

  <div class="boxlinkgroup">
    <h2>Uninstall</h2>
    <p>Caution, uninstalling will remove ALL DATA and files!</p>
      <div class="boxlink">
        <a class="button-primary" href="?page=rb_wpguru_settings&ConfigID=99" title="Uninstall">Uninstall</a><br />
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
                <th scope="row"><?php _e('Quicklinks', 'rb_wpguru-plugin'); ?></th>
                <td><textarea style="height: 400px;; width: 100%; " name="rb_wpguru_options[dashboardQuickLinks]"><?php echo $rb_wpguru_options_arr['dashboardQuickLinks']; ?></textarea></td>
              </tr>
            </table>
            
            <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'rb_wpguru'); ?>" />
        </form>
    
<?php
}	 // End	
elseif ($ConfigID == 99) {
?>
    <h3>Uninstall</h3>
    <div>Are you sure you want to uninstall?</div>
	<div><a href="?page=rb_wpguru_settings&action=douninstall">Yes! Uninstall</a></div>
<?php
}	 // End	
?>
</div>