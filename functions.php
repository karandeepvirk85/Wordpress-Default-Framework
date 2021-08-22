<?php
/**
 * Functions and definitions
 * Next Page It Theme
 */

// This theme requires WordPress 5.3 or later.
add_action('init', 'includeThemeControllers');
add_action('wp_enqueue_scripts', 'themeStyles');
add_action('wp_enqueue_scripts', 'themeScripts');
add_action('wp_head', 'setAjaxUrl');
add_action('wp_head','setHomeUrl');
add_action('admin_head','adminCss');
add_action('after_setup_theme', 'gThemeSupport');
add_action('admin_enqueue_scripts', 'loadSettingsScripts');
add_action('admin_enqueue_scripts', 'loadSettingsFontAwesome5');

function loadSettingsFontAwesome5(){
	if(isset($_GET['page'])){
		if($_GET['page'] != 'theme-settings'){
			return;
		}
	}
    wp_enqueue_script('font-awesome-5', 'https://kit.fontawesome.com/92f8084012.js');
}

function loadSettingsScripts(){
	if($_GET['page'] != 'theme-settings'){
		return;
	}
    wp_enqueue_script('settings_scripts', get_template_directory_uri() . '/scripts/admin-scripts.js', array(), '1.0');
    wp_enqueue_script('font-awesome-5', 'https://kit.fontawesome.com/92f8084012.js');

}
function gThemeSupport(){
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1568, 9999 );
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);
	register_nav_menus(
		array(
		'primary-menu' => __( 'Primary Menu' ),
		'secondary-menu' => __( 'Secondary Menu' )
		)
	);
}

/**
 * Load Theme Controllers
 */
function includeThemeControllers(){
	include_once(get_template_directory().'/controllers/theme_controller.php');
}

/**
 * Load Theme Styles
 */
function themeStyles() {
	wp_enqueue_style('animate','https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
	wp_enqueue_style('bootstrap-4', get_template_directory_uri().'/bootstrap4/bootstrap-4.0.0/dist/css/bootstrap.min.css');
	wp_enqueue_style('theme-style', get_template_directory_uri().'/style.css');
}

/**
 * Load Theme Scripts
 */
function themeScripts() {
	wp_enqueue_script('font-awesome-5-front', 'https://kit.fontawesome.com/92f8084012.js');
	wp_enqueue_script('jquery-script','https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js');
    wp_enqueue_script('theme-style', get_template_directory_uri().'/bootstrap4/bootstrap-4.0.0/dist/js/bootstrap.min.js');
	wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/scripts/theme-scripts.js');
}

/**
 * Add Custom css to Admin Area
 */
function adminCss(){
	echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/admin-style.css" type="text/css" media="all">'; 
}
/**
 * Set Ajax URL
 */
function setAjaxUrl() {
   echo '<script type="text/javascript"> 
		var globalObject = {
			"admin_url":"'.admin_url('admin-ajax.php').'",
			"home_url":"'.home_url().'",
			"home_slider_speed":"'.Theme_Controller::get_theme_option( 'slider_speed' ).'"
		};
	</script>';
}

/**
 * Set Home Url 
 */
function setHomeUrl() {
	echo '<script type="text/javascript"> var homeurl = "' .home_url(). '";</script>';
}