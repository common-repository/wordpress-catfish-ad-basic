<?php
/*
Plugin Name: Catfish Advertisement (Basic)
Plugin URI: http://fluiditystudio.com/wpplugins/catfishad/
Description: This plugin provides a basic catfish style advertisement that comes up from the bottom of the screen. The user can enter whatever text they like and change the color of the background and text styles. They can also choose a location to where the ad will click through to.
Version: 0.7
Author: Tyler Robinson
Author URI: http://www.fluiditystudio.com/

This plugin inherits the GPL license from it's parent system, WordPress.

*/


define("MY_PLUGIN_VERSION", "1.0" ); //Declare the plugin version. This way we know the tables are always up to date. I usually declare this in my main plugin file.
include("catscript.php");
register_activation_hook(__FILE__,'my_plugin_data_tables_install');


add_action('admin_init', 'editor_admin_init');
add_action('admin_head', 'editor_admin_head');

function editor_admin_init() {
  wp_enqueue_script('word-count');
  wp_enqueue_script('post');
  wp_enqueue_script('editor');
  wp_enqueue_script('media-upload');
}

function editor_admin_head() {
  wp_tiny_mce();
}



/*
///////////////////////////////////////////////
This section defines the variables that
will be used throughout the plugin
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/
//	define our defaults (filterable)
$wp_catfish_basic_defaults = apply_filters('wp_catfish_basic_defaults', array(
	'enableAd' => 0,
	'adcontent' => 'Content goes here',
	'mainbcolor' => '#000000',
	'cbtcolor' => '#ffffff',
	'adheight' => 'auto',
	'clientweb' => 'http://',
	'cookietime' => 600000,
));

//	pull the settings from the db
$wp_catfish_basic_settings = get_option('wp_catfish_basic_settings');
$wp_catfish_basic_images = get_option('wp_catfish_basic_images');

//	fallback
$wp_catfish_basic_settings = wp_parse_args($wp_catfish_basic_settings, $wp_catfish_basic_defaults);


/*
///////////////////////////////////////////////
This section hooks the proper functions
to the proper actions in WordPress
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/

//	this function registers our settings in the db
add_action('admin_init', 'wp_catfish_basic_register_settings');
function wp_catfish_basic_register_settings() {
	register_setting('wp_catfish_basic_images', 'wp_catfish_basic_images', 'wp_catfish_basic_images_validate');
	register_setting('wp_catfish_basic_settings', 'wp_catfish_basic_settings', 'wp_catfish_basic_settings_validate');
}
//	this function adds the settings page to the Media tab
add_action('admin_menu', 'add_wp_catfish_basic_menu');
function add_wp_catfish_basic_menu() {
	//add_submenu_page('admin.php', 'Catfish-Ad Settings', 'Catfish-Ad', 'upload_files', 'Catfish-Ad', 'wp_catfish_basic_admin_page');
	$appName = "Catfish Ad (Basic)";
	$appID = "Catfish-Ad";
	$icon_path = get_option('siteurl').'/wp-content/plugins/'.basename(dirname(__FILE__)).'/icon';
	add_menu_page($appName .'admin.php', $appName, 'administrator', $appID, 'wp_catfish_basic_admin_page',$icon_path.'/admin_menu_icon.png');
}

//	add "Settings" link to plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__) , 'wp_catfish_basic_plugin_action_links');
function wp_catfish_basic_plugin_action_links($links) {
	$wp_catfish_basic_settings_link = sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=Catfish-Ad' ), __('Settings') );
	array_unshift($links, $wp_catfish_basic_settings_link);
	return $links;
}


/*
///////////////////////////////////////////////
this function is the code that gets loaded when the
settings page gets loaded by the browser.  It calls 
functions that handle image uploads and image settings
changes, as well as producing the visible page output.
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/
function wp_catfish_basic_admin_page() {
	echo '<div class="wrap">';
	
		//	handle image upload, if necessary
		if($_REQUEST['action'] == 'wp_handle_upload')
			wp_catfish_basic_handle_upload();
		
		//	delete an image, if necessary
		if(isset($_REQUEST['delete']))
			wp_catfish_basic_delete_upload($_REQUEST['delete']);
		
		//	the settings management form
		wp_catfish_basic_settings_admin();
		

	echo '</div>';
}



//	this function checks to see if we just updated the settings
//	if so, it displays the "updated" message.
function wp_catfish_basic_settings_update_check() {
	global $wp_catfish_basic_settings;
	if(isset($wp_catfish_basic_settings['update'])) {
		echo '<div class="updated fade" id="message"><p>Catfish-Ad Settings <strong>'.$wp_catfish_basic_settings['update'].'</strong></p></div>';
		unset($wp_catfish_basic_settings['update']);
		update_option('wp_catfish_basic_settings', $wp_catfish_basic_settings);
	}
}


//	display the settings administration code
function wp_catfish_basic_settings_admin() { ?>

	<?php wp_catfish_basic_settings_update_check(); ?>
	<h2><?php _e('Catfish-Ad Settings', 'Catfish-Ad'); ?></h2>
    <hr />
	<form method="post" action="options.php">
	<?php settings_fields('wp_catfish_basic_settings'); ?>
	<?php global $wp_catfish_basic_settings; $options = $wp_catfish_basic_settings; ?>
    <div style="margin-top:40px;">
    Here is the video tutorial for this plugin if you should need it. <a href="#" onclick="popitup1()">VIDEO</a>

    <script type="text/javascript">
	function popitup1() {
	newwindow1=window.open('','name','height=355,width=430');
	var tmp = newwindow1.document;
	tmp.write('<html><head><title>Wordpress Catfish Ad Basic Tutorial Video</title></head>');
	tmp.write('<body>');
	tmp.write('<iframe width="425" height="349" src="http://www.youtube.com/embed/iegsNfJhZQY?hl=en&fs=1" frameborder="0" allowfullscreen></iframe>');
	tmp.write('</body>');
	tmp.write('</html>');
	tmp.close();
	}
	</script>
    </div>
    
	<table class="form-table">
    
    	<tr valign="top"><th scope="row">Catfish Enabled</th>
		<td><input name="wp_catfish_basic_settings[enableAd]" type="checkbox" value="1" <?php checked('1', $options['enableAd']); ?> /> <label for="wp_cycle_settings[enableAd]">Check this box if you want to enable the Catfish Ad</label></td>
		</tr>
        
        <tr><th scope="row">Ad Text Content</th>
		<td>Enter text/content of your ad here (do not hit retrun or your ad will not show up, just type the sentences all together. You can change text color and boldness:<br />
			<div id="poststuff">
<?php
  the_editor($options['adcontent'], $name = 'wp_catfish_basic_settings[adcontent]', "", $media_buttons = false);
  //the_editor($options['adcontent'], $name ='wp_catfish_basic_settings[adcontent]', $media_buttons = false, $tab_index = 2 );
?>
</div>
		</td></tr>
        
        <tr><th scope="row">Catfish Background Color:</th>
		<td>Enter the color for the background of the ad (Hex code ex: #00000):<br />
			<input type="text" name="wp_catfish_basic_settings[mainbcolor]" value="<?php echo $options['mainbcolor'] ?>" size="25" />
		</td></tr>
        
        <tr><th scope="row">Catfish Ad Height:</th>
		<td>Ad height (ex: "79px" or "auto" - auto will adjust to content):<br />
			<input type="text" name="wp_catfish_basic_settings[adheight]" value="<?php echo $options['adheight'] ?>" size="25" />
		</td></tr>
        
        <tr><th scope="row">Clickthrough Address</th>
		<td>Enter the website to click through to:<br />
			<input type="text" name="wp_catfish_basic_settings[clientweb]" value="<?php echo $options['clientweb'] ?>" size="45" />
		</td></tr>
        
        <tr><th scope="row">Ad Cookie Time</th>
		<td>You may change the cookie time in milliseconds:<br />
        Once the ad is displayed, if the user closes the ad or goes to another page, the ad will not show again for the set time. Default is 10 min. and format must be in milliseconds. (ex: 1 second = 1000 milliseconds)<br />
			<input type="text" name="wp_catfish_basic_settings[cookietime]" value="<?php echo $options['cookietime'] ?>" size="25" />
            <label for="wp_catfish_basic_settings[cookietime]">ms</label>
		</td></tr>
        
        <tr><td colspan="2"><h2>Close Button Settings</h2><hr/></td></tr>
        
        <tr><th scope="row">Ad Close Button Text Color</th>
		<td>Change Text color of the close button for the ad (Hex code ex: #00000):<br />
			<input type="text" name="wp_catfish_basic_settings[cbtcolor]" value="<?php echo $options['cbtcolor'] ?>" size="25" />
		</td></tr>
        
        <input type="hidden" name="wp_catfish_basic_settings[update]" value="UPDATED" />

	
	</table>
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Settings') ?>" />
	</form>
	
	<!-- The Reset Option -->
	<form method="post" action="options.php">
	<?php settings_fields('wp_catfish_basic_settings'); ?>
	<?php global $wp_catfish_basic_defaults; // use the defaults ?>
	<?php foreach((array)$wp_catfish_basic_defaults as $key => $value) : ?>
	<input type="hidden" name="wp_catfish_basic_settings[<?php echo $key; ?>]" value="<?php echo $value; ?>" />
	<?php endforeach; ?>
	<input type="hidden" name="wp_catfish_basic_settings[update]" value="RESET" />
	<input type="submit" class="button" value="<?php _e('Reset Settings') ?>" />
	</form>
	<!-- End Reset Option -->
	</p>
	<div style="margin-top:40px;">
    This plugin is the basic version. Get the FULL VERSION which uses images and custom tracking system <a href="http://www.fluiditystudio.com/wpplugins/catfishad/" target="_blank">HERE</a>. <a href="#" onclick="popitup2()">VIDEO</a>

    <script type="text/javascript">
	function popitup2() {
	newwindow2=window.open('','name','height=325,width=565');
	var tmp = newwindow2.document;
	tmp.write('<html><head><title>Wordpress Catfish Ad Plugin Video</title></head>');
	tmp.write('<body>');
	tmp.write('<iframe width="550" height="309" src="http://www.youtube.com/embed/wO1LZkSkEVY?rel=0" frameborder="0" allowfullscreen></iframe>');
	tmp.write('</body>');
	tmp.write('</html>');
	tmp.close();
	}
	</script>
    </div>
<?php
}// end of: admin display 
	  

/*
///////////////////////////////////////////////
these two functions sanitize the data before it
gets stored in the database via options.php
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
*/
//	this function sanitizes our settings data for storage
function wp_catfish_basic_settings_validate($input) {
	$input['enableAd'] = ($input['enableAd'] == 1 ? 1 : 0);
	return $input;
}


add_action('wp_print_scripts', 'wp_catfish_basic_scripts');
function wp_catfish_basic_scripts() {
	if(!is_admin())
	wp_enqueue_script('catfish', WP_CONTENT_URL.'/plugins/wordpress-catfish-ad-basic/jquery-1.6.4.js', array('jquery'), '', true);
}

add_action('wp_footer', 'wp_catfish_basic_js', 15);
function wp_catfish_basic_js() {?>
	<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-content/plugins/wordpress-catfish-ad-basic/catjs.php"></script>
<?php
}

add_action( 'wp_footer', 'wp_catfish_basic_style' );
function wp_catfish_basic_style() { 
	global $wp_catfish_basic_settings;

	
}
?>