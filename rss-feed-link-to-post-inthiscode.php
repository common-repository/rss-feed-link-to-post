<?php
/*
Plugin Name: RSS Feed Link to Post
Plugin URI:  https://www.inthiscode.com/
Description: Adds a link to your rss feed at the bottom of every post.
Version:     1.3.1
Author:      InThisCode
Author URI:  http://www.inthiscode.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: rfltp-itc
*/
defined( 'ABSPATH' ) or die( 'You are lost.' );

// Admin menu
add_action( 'admin_menu', 'rfltp_itc_add_admin_menu' ); // Add Admin Menu
if(!function_exists('rfltp_itc_add_admin_menu')){
	function rfltp_itc_add_admin_menu(  ) { 
		add_options_page( 'RSS Feed Link to Post', 'RSS Feed Link to Post', 'manage_options', 'rfltp_itc', 'rfltp_itc_options_page' );
	}
}

function rfltp_itc_options_page(  ) { 
	?>
	<form action='options.php' method='post'>
		<h1>RSS Feed Link to Post</h1>
		<?php
		settings_fields( 'rfltp_itc_pluginPage' );
		do_settings_sections( 'rfltp_itc_pluginPage' );
		submit_button();
		?>
	</form>
	<?php
}

// settings link
function rfltp_itc_plugin_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=rfltp_itc">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'rfltp_itc_plugin_settings_link' );

// Admin Settings
add_action( 'admin_init', 'rfltp_itc_settings_init' ); 
function rfltp_itc_settings_init() {
	register_setting( 'rfltp_itc_pluginPage', 'rfltp_itc_settings' );
	
	// Add section
	add_settings_section('rfltp_itc_pluginPage_section', __( 'Settings', 'rfltp-itc' ), 'rfltp_itc_settings_section_callback', 'rfltp_itc_pluginPage');
	
	// Enable plugin
	add_settings_field('rfltp_itc_enable', __( 'Enable Plugin', 'rfltp-itc' ), 'rfltp_itc_enable_render', 'rfltp_itc_pluginPage', 'rfltp_itc_pluginPage_section');	
	
	// Headings Type Options box
	add_settings_field('rfltp_itc_htype', __( 'Heading Type', 'rfltp-itc' ), 'rfltp_itc_htype_render', 'rfltp_itc_pluginPage', 'rfltp_itc_pluginPage_section');	
	
	// Headings Text
	add_settings_field('rfltp_itc_htext', __( 'Heading Text', 'rfltp-itc' ), 'rfltp_itc_htext_render', 'rfltp_itc_pluginPage', 'rfltp_itc_pluginPage_section');
	
	// Paragraph Text
	add_settings_field('rfltp_itc_ptext', __( 'Paragraph Text', 'rfltp-itc' ), 'rfltp_itc_ptext_render', 'rfltp_itc_pluginPage', 'rfltp_itc_pluginPage_section');	
	// Link Text
	add_settings_field('rfltp_itc_ltext', __( 'Link Text', 'rfltp-itc' ), 'rfltp_itc_ltext_render', 'rfltp_itc_pluginPage', 'rfltp_itc_pluginPage_section');
	
	// OUtput
	add_settings_field('rfltp_itc_output', __( 'Demo', 'rfltp-itc' ), 'rfltp_itc_output_render', 'rfltp_itc_pluginPage', 'rfltp_itc_pluginPage_section');	
	
}

// Callback
function rfltp_itc_settings_section_callback(  ) { 
	echo __( '', 'rfltp-itc' );
}

$rfltp_itc_options = get_option( 'rfltp_itc_settings' );

// Display enable checkbox
function rfltp_itc_enable_render() {
	global $rfltp_itc_options;
	?>
    <input type='checkbox' name='rfltp_itc_settings[rfltp_itc_enable]' <?php  if ( isset( $rfltp_itc_options['rfltp_itc_enable'] ) && $rfltp_itc_options['rfltp_itc_enable'] == '1' ) {echo 'Checked';} ?> value='1'>
    <?php
}

// Heading Type
function rfltp_itc_htype_render() {
	global $rfltp_itc_options;
	?>
    <select class="itc_htype" name="rfltp_itc_settings[rfltp_itc_htype]">
    <option value="h1" <?php selected( $rfltp_itc_options['rfltp_itc_htype'], 'h1' ); ?>>Heading 1 (h1)</option>
    <option value="h2" <?php selected( $rfltp_itc_options['rfltp_itc_htype'], 'h2' ); ?>>Heading 2 (h2)</option>
    <option value="h3" <?php selected( $rfltp_itc_options['rfltp_itc_htype'], 'h3' ); ?>>Heading 3 (h3)</option>
    <option value="h4" <?php selected( $rfltp_itc_options['rfltp_itc_htype'], 'h4' ); ?>>Heading 4 (h4)</option>
    <option value="h5" <?php selected( $rfltp_itc_options['rfltp_itc_htype'], 'h5' ); ?>>Heading 5 (h5)</option>
    <option value="h6" <?php selected( $rfltp_itc_options['rfltp_itc_htype'], 'h6' ); ?>>Heading 6 (h6)</option>    
    </select>

    <?php
}

// Heading Text
function rfltp_itc_htext_render() {
	global $rfltp_itc_options;
	?>
    <input type='text' class='widefat itc_htext' name='rfltp_itc_settings[rfltp_itc_htext]' value='<?php if(isset($rfltp_itc_options['rfltp_itc_htext'])) { echo $rfltp_itc_options['rfltp_itc_htext']; } else { echo 'Enjoyed this article?';} ?>'> 
    <?php
}

// Paragraph Text
function rfltp_itc_ptext_render() {
	global $rfltp_itc_options;
	?>
    <input type='text' class='widefat itc_ptext' name='rfltp_itc_settings[rfltp_itc_ptext]' value='<?php if(isset($rfltp_itc_options['rfltp_itc_ptext'])) { echo $rfltp_itc_options['rfltp_itc_ptext']; } else { echo 'Please consider subscribing to our ';} ?>'> 
    <?php
}

// Link Text
function rfltp_itc_ltext_render() {
	global $rfltp_itc_options;
	?>
    <input type='text' class='widefat itc_ltext' name='rfltp_itc_settings[rfltp_itc_ltext]' value='<?php if(isset($rfltp_itc_options['rfltp_itc_ltext'])) { echo $rfltp_itc_options['rfltp_itc_ltext']; } else { echo 'RSS feed!';} ?>'> 
    <?php
}

function rfltp_itc_heading_type($rfltp_heading) { 
	global $rfltp_itc_options;
	?>
		<<?php echo $rfltp_heading; ?>><?php if(isset($rfltp_itc_options['rfltp_itc_htext'])) { echo $rfltp_itc_options['rfltp_itc_htext']; } else { echo 'Enjoyed this article?';} ?></<?php echo $rfltp_heading; ?>>
    <?php }
	
	
// Demo
function rfltp_itc_output_render() {
	global $rfltp_itc_options;
	 ?> 
        <div> 
        <?php 
			if($rfltp_itc_options['rfltp_itc_htype'] == 'h1') {
				rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
			} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h2') {
				rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
			} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h3') {
				rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
			} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h4') {
				rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
			} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h5') {
				rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
			} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h6') {
				rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
			} else {
				rfltp_itc_heading_type('h3');
			}
		?>
        <p><?php if(isset($rfltp_itc_options['rfltp_itc_ptext'])) { echo $rfltp_itc_options['rfltp_itc_ptext']; } else { echo 'Please consider subscribing to our';} ?> <a href="<?php bloginfo('rss2_url'); ?>"  title="Subscribe via RSS"><?php if(isset($rfltp_itc_options['rfltp_itc_ltext'])) { echo $rfltp_itc_options['rfltp_itc_ltext']; } else { echo 'RSS eed!';} ?></a></p>
        <i><strong>Note:</strong> The above demo will be displayed at bottom of every post. You may change the text using above options</i>
    </div>
    <?php
}

// If checkbox checked
if ( isset( $rfltp_itc_options['rfltp_itc_enable'] ) && $rfltp_itc_options['rfltp_itc_enable'] == '1' ) {
	function rfltp_itc_promot_feed($rfltp_itc_content, $rfltp_itc_class = "promote") {
		global $rfltp_itc_options;
		echo $rfltp_itc_content;
		if (is_single() && is_singular( 'post' )) {
	?>
			<div class="<?php echo $rfltp_itc_class; ?>">
				<?php
				if($rfltp_itc_options['rfltp_itc_htype'] == 'h1') {
					rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
				} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h2') {
					rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
				} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h3') {
					rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
				} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h4') {
					rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
				} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h5') {
					rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
				} else if($rfltp_itc_options['rfltp_itc_htype'] == 'h6') {
					rfltp_itc_heading_type($rfltp_itc_options['rfltp_itc_htype']);
				} else {
					rfltp_itc_heading_type('h3');
				}
			?>
				<p><?php if(isset($rfltp_itc_options['rfltp_itc_ptext'])) { echo $rfltp_itc_options['rfltp_itc_ptext']; } else { echo 'Please consider subscribing to our ';} ?> <a class="feed" href="<?php bloginfo('rss2_url'); ?>" title="Subscribe via RSS"><?php if(isset($rfltp_itc_options['rfltp_itc_ltext'])) { echo $rfltp_itc_options['rfltp_itc_ltext']; } else { echo 'RSS eed!';} ?></a></p>
			</div>
	<?php
		}
	}
	add_filter('the_content','rfltp_itc_promot_feed');
}