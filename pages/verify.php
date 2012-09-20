<?php

// *************************************************************************************************** //
// Hook
add_action('rb_wpguru_options_update', 'rb_wpguru_verify_validate_fields',1);
add_action('wp_head', 'rb_wpguru_verify_add_meta',99);

// *************************************************************************************************** //
// Update

function rb_wpguru_options_update_process() {
	update_option( 'rb_wpguru_verification_codes[google]' , $_POST['rb_wpguru_verification_codes']['google'] );
	update_option( 'rb_wpguru_verification_codes[yahoo]' , $_POST['rb_wpguru_verification_codes']['yahoo'] );
	update_option( 'rb_wpguru_verification_codes[bing]' , $_POST['rb_wpguru_verification_codes']['bing'] );
}
add_action('rb_wpguru_options_update', 'rb_wpguru_options_update_process');

// *************************************************************************************************** //
// Page Output Functions

function rb_wpguru_verify_add_meta() {
	if (get_option('rb_wpguru_verification_codes[google]') != '') { ?>
	<meta name="google-site-verification" content="<?php echo get_option('rb_wpguru_verification_codes[google]'); ?>" />
	<?php } if (get_option('rb_wpguru_verification_codes[yahoo]') != '') { ?>
	<meta name="y_key" content="<?php echo get_option('rb_wpguru_verification_codes[yahoo]'); ?>" />
	<?php } if (get_option('rb_wpguru_verification_codes[bing]') != '') { ?>
	<meta name="msvalidate.01" content="<?php echo get_option('rb_wpguru_verification_codes[bing]'); ?>" />
	<?php } 
}

// Test the string in case someone submits the entire string. We just want the value of content
function rb_wpguru_verify_validate_fields() {
	$_POST['rb_wpguru_verification_codes']['google'] = str_replace("<meta name=\'google-site-verification\' content=\'",'',$_POST['rb_wpguru_verification_codes']['google']);
	$_POST['rb_wpguru_verification_codes']['google'] = str_replace("\'>",'',$_POST['rb_wpguru_verification_codes']['google']);
	
	$_POST['rb_wpguru_verification_codes']['yahoo'] = str_replace("<meta name=\'y_key\' content=\'",'',$_POST['rb_wpguru_verification_codes']['yahoo']);
	$_POST['rb_wpguru_verification_codes']['yahoo'] = str_replace("\'>",'',$_POST['rb_wpguru_verification_codes']['yahoo']);
	
	$_POST['rb_wpguru_verification_codes']['bing'] = str_replace("<meta name=\'msvalidate.01\' content=\'",'',$_POST['rb_wpguru_verification_codes']['bing']);
	$_POST['rb_wpguru_verification_codes']['bing'] = str_replace("\'>",'',$_POST['rb_wpguru_verification_codes']['bing']);
}

// *************************************************************************************************** //
// Output Functions

function rb_wpguru_verify_settings() {
	
	$rb_wpguru_options_arr = get_option('rb_wpguru_options');
	if ($_POST['action'] == 'update') { do_action( 'rb_wpguru_options_update' ); }
	
	?>
<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>Webmaster Tools Verification</h2>
  <p>Enter your meta key "content" value to verify your blog with <a href="https://www.google.com/webmasters/tools/">Google Webmaster Tools</a>, <a href="https://siteexplorer.search.yahoo.com/">Yahoo Site Explorer</a>, and <a href="http://www.bing.com/webmaster">Bing Webmaster Center</a>

	<form method="post">
	  <input type="hidden" name="action" value="update" />
	  <?php wp_nonce_field('rb_wpguru-settings-group'); ?>
      <table class="form-table">
        <tr valign='top'>
        <th scope='row'>Google Webmaster Tools</th>
          <td><input size='50' name='rb_wpguru_verification_codes[google]' type='text' value="<?php echo get_option('rb_wpguru_verification_codes[google]'); ?>" /></td>
        </tr><tr>
          <td colspan='2'><label for='rb_wpguru_verification_codes[google]'>Example: <code>&lt;meta name='google-site-verification' content='<strong><font color="red">dBw5CvburAxi537Rp9qi5uG2174Vb6JwHwIRwPSLIK8</font></strong>'&gt;</code></label> </td>
        </tr>
        <tr valign='top'>
          <th scope='row'>Yahoo Site Explorer</th>
          <td><input size='50' name='rb_wpguru_verification_codes[yahoo]' type='text' value="<?php echo get_option('rb_wpguru_verification_codes[yahoo]'); ?>" /></td>
        </tr>
        <tr>
          <td colspan='2'><label for='rb_wpguru_verification_codes[yahoo]'>Example: <code>&lt;meta name='y_key' content='<strong><font color="red">3236dee82aabe064</font></strong>'&gt;</code></label></td>
        </tr>
        <tr valign='top'>
          <th scope='row'>Bing Webmaster Center</th>
          <td><input size='50' name='rb_wpguru_verification_codes[bing]' type='text' value="<?php echo get_option('rb_wpguru_verification_codes[bing]'); ?>" /></td>
        </tr>
        <tr>
          <td colspan='2'><label for='rb_wpguru_verification_codes[bing]'>Example: <code>&lt;meta name='msvalidate.01' content='<strong><font color="red">12C1203B5086AECE94EB3A3D9830B2E</font></strong>'&gt;</code></label></td>
        </tr>
      </table>
	  <p class="submit"><input type="submit" class="button-primary" value="Save Changes" /></p>
	</form>
</div>
	<?php
}

