<? 

define('WP_SHORTNAME', 'mini_cinema');
define('OPTIONS_BASENAME', 'mini_cinema_options');

add_action('admin_menu', 'add_options_menu');
add_action('admin_init', 'register_options');

require_once(TEMPLATEPATH . '/optionSettings.php');

function add_options_menu(){
	$options_page = add_theme_page(__('Mini Cinema Options'), __('Mini Cinema Options', 'mini_textdomain'), 'manage_options', OPTIONS_BASENAME, 'create_options_page');
}

function options_get_settings(){
	$output = array();
	
	$output['options_name']			= "mini_options";
	$output['options_title']		= __("Mini Cinema Theme Options", "mini_textdomain");
	$output['options_sections']		= options_get_page_sections();
	$output['options_fields']		= "";
	$output['options_help']			= "";
	
	return $output;
}

function create_option_section(){
	echo "<p>" . __('Settings for this section','mini_textdomain') . "</p>"; 
}

function register_options(){
	$settings = options_get_settings();
	$option_name = $settings['options_name'];
	
	register_setting($option_name, $option_name, 'validate_options');
	
	if(!empty($settings['options_sections'])){
		foreach( $settings['options_sections'] as $id => $title ){
			add_settings_section($id, $title, 'create_option_section', __FILE__);
		}
	}
}

function validate_options($input){
	$output = array();
	
	return $output;
}

function create_options_page(){
	
	$settings = options_get_settings();
	?>
	
	<div class="wrap">
		<div class="icon32" id="icon-options-general"></div>
		<h2><? echo $settings['options_title']; ?></h2>
		
		<form action="options.php" method="post">
			<?
				settings_fields($settings['options_name']);
				do_settings_sections(__FILE__);
			?>
			<p class="submit">  
                <input name="Submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes','mini_textdomain'); ?>" />  
            </p>
		</form>
	</div>
	
	<?
}?>