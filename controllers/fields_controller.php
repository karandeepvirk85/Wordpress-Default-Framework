<?php
if(!defined('ABSPATH')) exit; 
class Fields_Controller{
    public function __construct(){

    }
    
    /**
     * Returns all theme options
     *
     * @since 1.0.0
     */
    public static function get_theme_options() {
        return get_option('theme_options');
    }

    /**
     * Returns single theme option
     *
     * @since 1.0.0
     */
    public static function get_theme_option($id){
        $options = self::get_theme_options();
        if(isset( $options[$id])){
            return $options[$id];
        }
    }
    /** 
     * Get Input Type Text Input
     * @args 
     * 'theme_option_key', 'placeholder' 
     */
    public static function getTextFieldInput($strKey, $strPlaceholder = null){
        // Set empty return
        $strHtml = '';
        
        // Set option Value
        $strValue = self::get_theme_option($strKey);
        
        // Load html
        $strHtml = '<input 
            type="text" 
            placeholder="'.$strPlaceholder.'" 
            class="settings-input" 
            name="theme_options['.$strKey.']" 
            value="'.$strValue.'"
        >';

        // return html
        return $strHtml;
    }
}