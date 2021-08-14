<?php
/**
 * Functions and definitions
 * Next Page It Theme
 */

// This theme requires WordPress 5.3 or later.
add_action('init', 'includeThemeControllers');
add_action( 'wp_enqueue_scripts', 'themeStyles');
add_action( 'wp_enqueue_scripts', 'themeScripts');
add_action('wp_head', 'setAjaxUrl');
add_action('wp_head','setHomeUrl');

function includeThemeControllers(){
	include_once(get_template_directory().'/controllers/theme_controller.php');
}

function themeStyles() {
	wp_enqueue_style('font-awesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('bootstrap-style','https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css',false, '1.0', 'all');
	wp_enqueue_style('animate','https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
	wp_enqueue_style('theme-style', get_template_directory_uri().'/style.css');
}

function themeScripts() {
	wp_enqueue_script('jquery-script','https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js');
    wp_enqueue_script('bootstrap-scripts', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js', false, '1.0', 'all' );
	wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/scripts/theme-scripts.js', false, '1.0', 'all' );
}

function setAjaxUrl() {
   echo '<script type="text/javascript"> var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}

function setHomeUrl() {
	echo '<script type="text/javascript"> var homeurl = "' .home_url(). '";</script>';
}

function addHomeSection1(){
	add_settings_section ('home_section_1', 'Home Section 1','getHomeSectionContent1', 'reading');
	add_settings_field('first_field_section_1','First Section','getSettingsField','reading','home_section_1');
}

function getHomeSectionContent1(){
	echo "<p>This is the new Reading section.</p>";
}

function getSettingsField(){
	echo "<p>This is Settings Field</p>";
}

function registerHomeSection1Settings(){
	register_setting('Reading','first_field_section_1');
}

add_action('admin_init','addHomeSection1');
add_action('admin_init','registerHomeSection1Settings');