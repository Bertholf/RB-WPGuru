<div class="wrap">
  <div id="rb-overview-icon" class="icon32"></div>
  <h2>WordPress Guru Dashboard</h2>
  <p>You are using version <b><?php echo rb_wpguru_version; ?></b></p>

  <div class="boxblock-holder">
    <div class="boxblock-container" style="width: 46%;">
 
     <div class="boxblock">
        <h3>Design Configuration</h3>
        <div class="inner">
		<?php
		// Identify Paths
		$templateFolderName = "twentyten_child";
		$filetemplate = "../wp-content/plugins/rb-wpguru/style/template.css";
		$filetheme = "../wp-content/themes/".$templateFolderName."/style.css";
		
		// Unpack the theme
        if (is_dir("../wp-content/plugins/rb-wpguru/".$templateFolderName)) {
			rename("../wp-content/plugins/rb-wpguru/".$templateFolderName,"../wp-content/themes/".$templateFolderName); 
			echo "Theme has been copied over.<br />\n";
		}

		// Handle Post
		if (isset($_POST['Action'])) {
			// Read the CSS doc as a string
			$str=implode("\n",file($filetemplate));
			
			// Font Types
			$fonttype_body = $_POST['fonttype_body'];
				$str=str_replace('[*fonttype_body*]',$fonttype_body,$str);
			$fonttype_header = $_POST['fonttype_header'];
				$str=str_replace('[*fonttype_header*]',$fonttype_header,$str);
				
			// Font Color
			$fontcolor_body = $_POST['fontcolor_body'];
				$str=str_replace('[*fontcolor_body*]',$fontcolor_body,$str);
			$fontcolor_content = $_POST['fontcolor_content'];
				$str=str_replace('[*fontcolor_content*]',$fontcolor_content,$str);
			
			// Font Size
			$fontsize_body = $_POST['fontsize_body'];
				$str=str_replace('[*fontsize_body*]',$fontsize_body,$str);
			$fontsize_content = $_POST['fontsize_content'];
				$str=str_replace('[*fontsize_content*]',$fontsize_content,$str);
			
			// Background Color
			$backgroundcolor_body = $_POST['backgroundcolor_body'];
				$str=str_replace('[*backgroundcolor_body*]',$backgroundcolor_body,$str);
			$backgroundcolor_wrapper = $_POST['backgroundcolor_wrapper'];
				$str=str_replace('[*backgroundcolor_wrapper*]',$backgroundcolor_wrapper,$str);


			//rewrite the file
			$fp=fopen($filetheme,'w');
			fwrite($fp,$str,strlen($str));
		};
		
		
      	?>
		 <form method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
         	<div id="config" class="config">
              <h3>Font Type</h3>
              <div class="inner">
                <label>Body Font:
                    <span><input type="text" id="fonttype_body" name="fonttype_body" class="regular-text" value="<?php echo $fonttype_body; ?>" /></span></label>
                <label>Header Font:
                    <span><input type="text" id="fonttype_header" name="fonttype_header" class="regular-text" value="<?php echo $fonttype_header; ?>" /></span></label>
              </div>
             
              <h3>Font Color</h3>
              <div class="inner">
                <label>Body:
                    <span><input type="text" id="fontcolor_body" name="fontcolor_body" class="regular-text" value="<?php echo $fontcolor_body; ?>" /></span></label>
                <label>Content:
                    <span><input type="text" id="fontcolor_content" name="fontcolor_content" class="regular-text" value="<?php echo $fontcolor_content; ?>" /></span></label>
              </div>

              <h3>Font Size</h3>
              <div class="inner">
                <label>Body:
                    <span><input type="text" id="fontsize_body" name="fontsize_body" class="regular-text" value="<?php echo $fontsize_body; ?>" /></span></label>
                <label>Content:
                    <span><input type="text" id="fontsize_content" name="fontsize_content" class="regular-text" value="<?php echo $fontsize_content; ?>" /></span></label>
              </div>
                    
              <h3>Background Color</h3>
              <div class="inner">
                <label>Body:
                    <span><input type="text" id="backgroundcolor_body" name="backgroundcolor_body" class="regular-text" value="<?php echo $backgroundcolor_body; ?>" /></span></label>
                <label>Wrapper:
                    <span><input type="text" id="backgroundcolor_wrapper" name="backgroundcolor_wrapper" class="regular-text" value="<?php echo $backgroundcolor_wrapper; ?>" /></span></label>
              </div>

              <p class="submit">
                <input type="hidden" name="Action" value="Update" />
                <input type="submit" value="Submit" class="button-primary" name="Submit" />
              </p>
         	</div>
          </form>
        
        </div>
     </div>
    
    </div><!-- .container -->
  
    <div class="boxblock-container" style="width: 46%;">
 
     <div class="boxblock">
        <h3>Sample</h3>
        <div class="inner">
        	<iframe src="../wp-content/themes/<?php echo $templateFolderName; ?>/style.css" style="width: 400px; height: 300px;"></iframe>
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
<?php 
		/*  RESET THEME 

		// This does not currently work:
        if(is_dir("../wp-content/themes/".$templateFolderName."/")) {
			add_action("switch_theme", "../wp-content/themes/".$templateFolderName."/");

			echo "Theme has activated.<br />\n";
		}




		/*  RESET THEME 
        delete_option('your_theme_options');
        update_option('template', 'default');
        update_option('stylesheet', 'default');
        delete_option('current_theme');
        $theme = get_current_theme();
        do_action('switch_theme', $theme);
        $redirect = 'themes.php';
		*/


		/*  RESET THEME 
		function my_activation_settings($theme) {
			if ( 'Your Theme Name' == $theme ) {
				// do something
			}
			return;
		}
		add_action('switch_theme', 'my_activation_settings');
			
		/*
		// Install the theme
		echo get_template_directory();
		
		
		
		
		
		global $pagenow;
		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			 // When theme is activated this code runs.
			 // Still be defensive if you need to be, and check if
			 // your baby is already born
		}

		include_once ABSPATH . 'wp-admin/includes/theme-install.php'; //for themes_api..
		
		$theme = "thematic";

		check_admin_referer('install-theme_' . $theme);
		$api = themes_api('theme_information', array('slug' => $theme, 'fields' => array('sections' => false) ) ); //Save on a bit of bandwidth.

		wp_enqueue_script('theme-preview');
		$title = __('Install Themes');
		$parent_file = 'themes.php';
		$submenu_file = 'themes.php';
		require_once('./admin-header.php');

		$title = sprintf( __('Installing Theme: %s'), $api->name . ' ' . $api->version );
		$nonce = 'install-theme_' . $theme;
		$url = 'update.php?action=install-theme&theme=' . $theme;
		$type = 'web'; //Install theme type, From Web or an Upload.

		$upgrader = new Theme_Upgrader( new Theme_Installer_Skin( compact('title', 'url', 'nonce', 'plugin', 'api') ) );
		$upgrader->install($api->download_link);
		*/


?>
</div>
</div>
