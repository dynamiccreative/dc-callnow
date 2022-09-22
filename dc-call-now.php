<?php
/**
 * Plugin Name: DC Call now
 * Description: Bloc Call Now
 * Version: 0.1
 * Author: Dynamic Creative
 * Author URI: http://www.dynamic-creative.com
 */


add_action('init', 'dccallnow_init');

function dccallnow_init(){
	wp_enqueue_style ( 'dccallnow', plugins_url() . '/dc-callnow/css/dccallnow.css');
	wp_enqueue_script( 'dccallnow', plugins_url() . '/dc-callnow/js/dccallnow.js',array('jquery'),'0.1',true );
}


/**
 * Adds a page in the settings menu
 */
function dccallnow_menu() {
	add_options_page( 'DcCallNow Options', 'DcCallNow', 'manage_options', 'dccallnow-options', 'dccallnow_options' );
}
add_action( 'admin_menu', 'dccallnow_menu' );

/**
 * Content for the settings page
 */
function dccallnow_options() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

	// variables for the field and option names
	$hidden_field_name 		= 'st_submit_hidden';
	$st_opt_name1 			= 'st_phone';
	$st_data_field_name1 	= 'st_phone';
    $st_opt_name2 			= 'st_form';
	$st_data_field_name2 	= 'st_form';

	// Read in existing option value from database
  	$st_opt_val1 		= get_option( $st_opt_name1 );
    $st_opt_val2 		= get_option( $st_opt_name2 );

	// See if the user has posted us some information
  	// If they did, this hidden field will be set to 'Y'
  	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
  		// Read their posted value
      	$st_opt_val1 		= $_POST[ $st_data_field_name1 ];
        $st_opt_val2 		= $_POST[ $st_data_field_name2 ];

      	// Save the posted value in the database
     	update_option( $st_opt_name1, $st_opt_val1 );
        update_option( $st_opt_name2, $st_opt_val2 );

     	// Put an settings updated message on the screen
	?>
	<div class="updated"><p><strong><?php _e('Your settings have been saved.', 'dccallnow-updated' ); ?></strong></p></div>
	<?php
	}
	// Now display the settings editing screen
    echo '<div class="cn_container">';

    // header
    echo "<h2>" . __( 'DC Call Now Settings', 'dccallnow-header' ) . "</h2>";
    echo "<p>" . __( 'Ce plugin rajoute un bloc contact flottant.', 'dccallnow-headerdescription' ) . "</p>";

    // left part
    echo '<div class="bloc">';

    // settings form
    echo '<form method="post" action="">';

    // register settings
	settings_fields( 'dccallnow_settings' );
	register_setting( 'dccallnow_settings', 'st_menu_customwidth' );  
	?>
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	
    <div class="cn_margin cn_code">
        <p>Exemple code CF7</p>
        <code>&lt;div id="formcallnow"&gt;&lt;div class="form-group"&gt;[email* your-email class:form-control "Votre email"]&lt;/div&gt;<br>
&lt;div class="submit"&gt;[submit class:btn class:btn-call "Envoyer"]&lt;/div&gt;&lt;/div&gt;</code>
    </div>
	
	<div class="cn_margins">
		<div>
			<label for="dcccallnow_phone"><?php _e("Phone number:", 'dccallnow' ); ?></label>
			<?php $st_opt_val1 = get_option( 'st_phone' ); ?>
			<input type="text" id="dcccallnow_phone" name="<?php echo $st_data_field_name1; ?>" value="<?php echo $st_opt_val1; ?>">
		</div>
		<div>
			<label for="dcccallnow_form"><?php _e("Form ID:", 'dccallnow' ); ?></label>
			<?php $st_opt_val2 = get_option( 'st_form' ); ?>
			<input type="text" id="dcccallnow_form" name="<?php echo $st_data_field_name2; ?>" value="<?php echo $st_opt_val2; ?>">
		</div>	
	</div>
	<?php submit_button(); ?>
	<?php

	echo "</form>";
	echo "</div><!-- end .admin_left -->";
	?>
	<div class="admin_right">
			<h3>A propos de Dynamic Creative</h3>
			<?php echo "<p>Agence Web cr&eacute;e en 1999. Conception de sites Internet, Mobile, d&eacute;veloppement et bien d'autres...</p>"; ?>
			<p><a href="http://www.dynamic-creative.com" target="_blank">dynamic-creative.com</a></p>
			
			<hr />

		</div><!-- end .admin_right -->
	</div><!-- end .wrap -->
	<?php

    echo "</div>";
}

/**
 * Add settings link on plugin page
 * @author c.bavota (http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/)
 */

function dccallnow_settings_link($links) { 
	  $settings_link = '<a href="options-general.php?page=dccallnow-options">Settings</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'dccallnow_settings_link' );

/**
 * Adds CSS on the admin side
 */
function DcCallNow_admin_addCSS(){
	echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'admin.css' , __FILE__ ) . '" />';
	echo "\n";
}
add_action('admin_head','DcCallNow_admin_addCSS');

/**
 * shortcode
 */
function dccallnow_sc(){
    $st_phone = get_option( 'st_phone' );
    $st_form = get_option( 'st_form' );
    $sortie = '<div id="callnow"><div id="btcall"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25" height="25" viewBox="0 0 578.106 578.106" style="enable-background:new 0 0 578.106 578.106;" xml:space="preserve"><g><path class="pathcall" d="M577.83,456.128c1.225,9.385-1.635,17.545-8.568,24.48l-81.396,80.781 c-3.672,4.08-8.465,7.551-14.381,10.404c-5.916,2.857-11.729,4.693-17.439,5.508c-0.408,0-1.635,0.105-3.676,0.309 c-2.037,0.203-4.689,0.307-7.953,0.307c-7.754,0-20.301-1.326-37.641-3.979s-38.555-9.182-63.645-19.584 c-25.096-10.404-53.553-26.012-85.376-46.818c-31.823-20.805-65.688-49.367-101.592-85.68 c-28.56-28.152-52.224-55.08-70.992-80.783c-18.768-25.705-33.864-49.471-45.288-71.299 c-11.425-21.828-19.993-41.616-25.705-59.364S4.59,177.362,2.55,164.51s-2.856-22.95-2.448-30.294 c0.408-7.344,0.612-11.424,0.612-12.24c0.816-5.712,2.652-11.526,5.508-17.442s6.324-10.71,10.404-14.382L98.022,8.756 c5.712-5.712,12.24-8.568,19.584-8.568c5.304,0,9.996,1.53,14.076,4.59s7.548,6.834,10.404,11.322l65.484,124.236 c3.672,6.528,4.692,13.668,3.06,21.42c-1.632,7.752-5.1,14.28-10.404,19.584l-29.988,29.988c-0.816,0.816-1.53,2.142-2.142,3.978 s-0.918,3.366-0.918,4.59c1.632,8.568,5.304,18.36,11.016,29.376c4.896,9.792,12.444,21.726,22.644,35.802 s24.684,30.293,43.452,48.653c18.36,18.77,34.68,33.354,48.96,43.76c14.277,10.4,26.215,18.053,35.803,22.949 c9.588,4.896,16.932,7.854,22.031,8.871l7.648,1.531c0.816,0,2.145-0.307,3.979-0.918c1.836-0.613,3.162-1.326,3.979-2.143 l34.883-35.496c7.348-6.527,15.912-9.791,25.705-9.791c6.938,0,12.443,1.223,16.523,3.672h0.611l118.115,69.768 C571.098,441.238,576.197,447.968,577.83,456.128z"/></g></svg></div><div class="tit">Contactez-nous</div><div class="pho"><a href="tel:'.$st_phone.'">'.$st_phone.'</a></div>';
    $sortie .= do_shortcode("[contact-form-7 id=$st_form]")."</div>";
    return $sortie;
}
add_shortcode( 'dccallnow','dccallnow_sc' );

