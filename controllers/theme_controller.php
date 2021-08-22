<?php
if(!defined('ABSPATH')) exit; 
class Theme_Controller{
    public function __construct() {
        if (is_admin()){
            add_action( 'admin_menu', array( __CLASS__, 'add_admin_menu' ) );
            add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
        }
    }
    
    /**
     * Get Paged Query
     */
    public static function getPagedQuery(){
        if (get_query_var('paged')){
            $paged = get_query_var('paged');
        } 
        elseif (get_query_var('page')){
            $paged = get_query_var('page');
        } 
        else {
            $paged = 1;
        }
        return $paged;
    }

    /**
     * Get Post Date
     */
    public static function getPostDate($strPostDate){
        $strReturn = '';
        $strPostDate = strtotime($strPostDate);
        $strPostDate = date('d M, Y',$strPostDate);
        $strReturn = $strPostDate; 
        return $strPostDate;
    }

    /**
     * Get Post Image
     */
    public static function getPostImage($intPostId, $strSIze){
        $intAttachmentId = get_post_thumbnail_id($intPostId);
        $strImageUrl = wp_get_attachment_image_src($intAttachmentId, $strSIze);
        $strImageUrl = $strImageUrl[0];
        return $strImageUrl;
    }

    /**
     * Filter WP Content
     */
    public static function getFilteredContent($strcontent,$bolStripTags,$intLength=300){
        if($bolStripTags){
            $strcontent = strip_tags($strcontent); 
            $strcontent = substr($strcontent, 0, $intLength);
        }
        else{
            $strcontent = nl2br($strcontent);
        }
        return $strcontent;
    }

    /**
     * Get WP Posts or Custom Posts Type/
     */
    public static function getAllPosts($paged = 1, $strPostType, $intNumberOfPages){
        // Default Args
        $arrArgs =  array(
            'post_type'     => $strPostType, 
            'post_status'   =>'publish', 
            'posts_per_page'=> $intNumberOfPages,
            'paged'         => $paged,
        );
   
        $allPostsWPQuery = new WP_Query(
           $arrArgs
        );
        return $allPostsWPQuery;
    }

    /**
     * Get Args For Pagination
     */
    public static function getArgsForPagination($paged,$intMaxPages){
        $arrReturn  = array(
            'paged' => $paged,
            'max_num_pages' => $intMaxPages
        );
        return $arrReturn;
    }

    /**
     * Get Shake Error
     */
    public static function getShakeError($string){
        $strHtml = '';
        $strHtml .= 
            '<div class="animate__animated animate__fadeInDown alert alert-danger alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fa fa-hand-o-right" aria-hidden="true"></i> Failure! </strong>'.$string.'.
            </div>';
        return $strHtml;
    }

    /**
     * Get Shake Sucess
     */
    public static function getShakeSuccess($string){
        $strHtml = '';
        $strHtml .= 
            '<div class="animate__animated animate__fadeInDown alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fa fa-hand-o-right" aria-hidden="true"></i> Success! </strong>'.$string.'.
            </div>';
        return $strHtml;
    }

    /**
     * Get Shake Notice
     */
    public static function getShakeNotice($string){
        $strHtml = '';
        $strHtml .= 
            '<div class="animate__animated animate__fadeInDown alert alert-warning alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong><i class="fa fa-hand-o-right" aria-hidden="true"></i> '.$string.'.
            </div>';
        return $strHtml;
    }

    /**
     * Get Catefories Link
     */
    public static function getCategoriesLink($arrCategories){
        $strReturn = '';
        $arrCategoryName = array();
        if(!empty($arrCategories)){
            foreach($arrCategories as $objCategory){
                $arrCategoryName[] = '<a href="'.get_category_link($objCategory->term_id).'">'.$objCategory->name.'</a>';
            }
        }
        $strReturn = !empty($arrCategoryName) ? implode(', ', $arrCategoryName) : "" ;
        return $strReturn;
    }
    /**
    * 
    * Function to get Wordpress Menu By Name  
    */   
    public static function getMenuByName($strMenuName){
        $current_menu = wp_get_nav_menu_object($strMenuName);
        $array_menu = wp_get_nav_menu_items($current_menu);
        $menu = array();
        if(!empty($array_menu)){
            foreach ($array_menu as $m) {
                if (empty($m->menu_item_parent)) {
                    $intPageId = (int) get_post_meta($m->ID, '_menu_item_object_id', true );
                    $menu[$m->ID] = array();
                    $menu[$m->ID]['ID']      	 =   $m->ID;
                    $menu[$m->ID]['title']       =   $m->title;
                    $menu[$m->ID]['url']         =   $m->url;
                    $menu[$m->ID]['children']    =   array();
                    $menu[$m->ID]['page_id']  	 = $intPageId;
                }
            }
        }
        $submenu = array();
        if(!empty($array_menu)){
            foreach ($array_menu as $m) {
                if($m->menu_item_parent) {
                    $submenu[$m->ID] = array();
                    $submenu[$m->ID]['ID']       =   $m->ID;
                    $submenu[$m->ID]['title']    =   $m->title;
                    $submenu[$m->ID]['url']  =   $m->url;
                    $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
                }
            }
            return $menu;
        }
    }

    /**
     * Returns all theme options
     *
     * @since 1.0.0
     */
    public static function get_theme_options() {
        return get_option( 'theme_options' );
    }

    /**
     * Returns single theme option
     *
     * @since 1.0.0
     */
    public static function get_theme_option( $id ) {
        $options = self::get_theme_options();
        if ( isset( $options[$id] ) ) {
            return $options[$id];
        }
    }

    /**
     * Add sub menu page
     *
     * @since 1.0.0
     */
    public static function add_admin_menu() {
        add_menu_page(
            esc_html__( 'Theme Settings', 'text-domain' ),
            esc_html__( 'Theme Settings', 'text-domain' ),
            'manage_options',
            'theme-settings',
            array( __CLASS__, 'create_admin_page' )
        );
    }
    /**
     * Register a setting and its sanitization callback.
     *
     * We are only registering 1 setting so we can store all options in a single option as
     * an array. You could, however, register a new setting for each option
     *
     * @since 1.0.0
     */
    public static function register_settings() {
        register_setting( 'theme_options', 'theme_options', array( __CLASS__, 'sanitize' ) );
    }

    /**
     * Sanitization callback
     *
     * @since 1.0.0
     */
    public static function sanitize( $options ) {

        // If we have options lets sanitize them
        if ( $options ) {

            // Checkbox
            if ( ! empty( $options['checkbox_example'] ) ) {
                $options['checkbox_example'] = 'on';
            } else {
                unset( $options['checkbox_example'] ); // Remove from options if not checked
            }

            // Input
            if ( ! empty( $options['input_example'] ) ) {
                $options['input_example'] = sanitize_text_field( $options['input_example'] );
            } else {
                unset( $options['input_example'] ); // Remove from options if empty
            }

            // Select
            if ( ! empty( $options['select_example'] ) ) {
                $options['select_example'] = sanitize_text_field( $options['select_example'] );
            }

        }

        // Return sanitized options
        return $options;
    }

    public static function create_admin_page() { 
   
        $strFacebook  = self::get_theme_option('facebook'); 
        $strTwitter   = self::get_theme_option('twitter');
        $strYoutube   = self::get_theme_option('youtube'); 
        $strInstagram = self::get_theme_option('instagram');
        $strEmail     = self::get_theme_option('email');
        $strContact   = self::get_theme_option('contact');
        $strAddress   = self::get_theme_option('address');
    ?>
            
        <div>
            <h1><?php esc_html_e( 'Theme Options', 'text-domain' ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'theme_options' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Logo', 'text-domain' ); ?></th>
                        <td>
                            <?php $strLogo = self::get_theme_option( 'site_logo' ); ?> 
                            <?php $strLogoWidth = self::get_theme_option( 'logo_width' ); ?> 

                            <div class="settings-site-logo-input">
                                <input type="text" class="settings-input" name="theme_options[site_logo]" value="<?php echo $strLogo; ?>">
                                <input type="number" placeholder="Width in Pixels" class="settings-number" name="theme_options[logo_width]" value="<?php echo $strLogoWidth; ?>">
                            </div>
                            <?php if(!empty($strLogo)){?>
                               <div class="settings-site-logo">
                                    <img src="<?php echo esc_attr($strLogo); ?>">
                                </div>
                            <?php }?>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Theme Primary Color', 'text-domain' ); ?></th>
                        <td>
                            <?php $strHeaderColor = self::get_theme_option('primary_color'); ?> 
                            <div class="settings-site-header-input">
                                <input type="color" name="theme_options[primary_color]" value="<?php echo $strHeaderColor; ?>">
                                <?php if(!empty($strHeaderColor)){?>
                                    <div class="header-color" style="background-color:<?php echo $strHeaderColor;?>"></div>
                                <?php }?>
                            </div>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Theme Secondary Color', 'text-domain' ); ?></th>
                        <td>
                            <?php $strHeaderColor = self::get_theme_option( 'secondary_color' ); ?> 
                            <div class="settings-site-header-input">
                                <input type="color" name="theme_options[secondary_color]" value="<?php echo $strHeaderColor; ?>">
                                <?php if(!empty($strHeaderColor)){?>
                                    <div class="header-color" style="background-color:<?php echo $strHeaderColor;?>"></div>
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                    
                    <!--Define Number of Slides-->
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Number of Slides', 'text-domain' ); ?></th>
                        <td>
                            <?php $strNumberOfSlides = self::get_theme_option( 'number_of_slides' ); ?> 
                            <div class="settings-site-input-number">
                                <input type="number" class="settings-input-number" name="theme_options[number_of_slides]" value="<?php echo $strNumberOfSlides; ?>">
                            </div>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Slider Speed', 'text-domain' ); ?></th>
                        <td>
                            <?php $intSliderSpeed = self::get_theme_option( 'slider_speed' ); ?> 
                            <div class="settings-site-input-number">
                                <input type="number" class="settings-input-number-speed" name="theme_options[slider_speed]" value="<?php echo $intSliderSpeed; ?>">
                                <div class="description">2000 is approximately 1 second</div>
                            </div>
                        </td>
                    </tr>

                    <!--Add Slides-->
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Slider', 'text-domain' ); ?></th>
                        <td>
                            <?php
                            // Slider Loop
                            if($strNumberOfSlides > 0){
                                for ($i=1; $i<=$strNumberOfSlides; $i++){
                                    $strImageUrl = self::get_theme_option('slider_image_'.$i);
                                    $strCaptionText = self::get_theme_option('slider_caption_'.$i);
                                ?>
                                <h4 class="slider-label">Slider <?php echo $i;?></h4 >
                                    <!--Input-->
                                    <div class="settings-site-slider-input">
                                        <input placeholder="Paste Slider Image Url Here" type="text" class="settings-input" name="theme_options[slider_image_<?php echo $i;?>]" value="<?php echo $strImageUrl;?>">
                                        <input placeholder="Write Your Captions Here" type="text" class="settings-input" name="theme_options[slider_caption_<?php echo $i;?>]" value="<?php echo $strCaptionText;?>">
                                    </div>

                                    <!--Show Image-->
                                    <?php if(!empty($strImageUrl)){?>
                                        <div class="settings-slider-image">
                                            <img src="<?php echo $strImageUrl; ?>">
                                        </div>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        </td>
                    </tr>

                    <?php /* ?>
                    <?php // Checkbox example ?>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Checkbox Example', 'text-domain' ); ?></th>
                        <td>
                            <?php $value = self::get_theme_option( 'checkbox_example' ); ?>
                            <input type="checkbox" name="theme_options[checkbox_example]" <?php checked( $value, 'on' ); ?>> <?php esc_html_e( 'Checkbox example description.', 'text-domain' ); ?>
                        </td>
                    </tr>
                    <?php */?>
                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Home Section 1', 'text-domain' ); ?></th>
                        <td>
                            <?php $value = self::get_theme_option( 'home_section_1' ); ?>
                            <select name="theme_options[home_section_1]">
                                <?php

                                $args = array(
                                    'post_type' => 'page',
                                    'posts_per_page' => -1,
                                    'numberposts' => -1
                                );

                                $arrpages = get_posts($args);

                                foreach($arrpages as $key => $objPages){
                                    $arrPageOptions[$objPages->ID] = $objPages->post_title;
                                }

                                foreach ( $arrPageOptions as $id => $label ) { ?>
                                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
                                        <?php echo strip_tags( $label ); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php esc_html_e( 'Home Section 2', 'text-domain' ); ?></th>
                        <td>
                            <?php $value = self::get_theme_option( 'home_section_2' ); ?>
                            <select name="theme_options[home_section_2]">
                                <?php

                                $args = array(
                                    'post_type' => 'page',
                                    'posts_per_page' => -1,
                                    'numberposts' => -1
                                );

                                $arrpages = get_posts($args);

                                foreach($arrpages as $key => $objPages){
                                    $arrPageOptions[$objPages->ID] = $objPages->post_title;
                                }

                                foreach ( $arrPageOptions as $id => $label ) { ?>
                                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected( $value, $id, true ); ?>>
                                        <?php echo strip_tags( $label ); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                </table>

                <div class="settings-social-information">
                    <div class="settings-social-information-to-click">
                        <h1>Contact Information</h1>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="settings-social-information-to-open hide-div">
                        <h2> Facebook</h2>
                        <input type="text" name="theme_options[facebook]" value="<?php echo $strFacebook;?>">

                        <h2> Twitter</h2>
                        <input type="text" name="theme_options[twitter]" value="<?php echo $strTwitter;?>">        

                        <h2> Youtube</h2>
                        <input type="text" name="theme_options[youtube]" value="<?php echo $strYoutube;?>">

                        <h2> Instagram</h2>
                        <input type="text" name="theme_options[instagram]" value="<?php echo $strInstagram;?>">

                        <h2> Email</h2>
                        <input type="email" name="theme_options[email]" value="<?php echo $strEmail;?>">

                        <h2> Contact</h2>
                        <input type="text" name="theme_options[contact]" value="<?php echo $strContact;?>">

                        <h3> Address</h3>
                        <textarea class="settings-input-textarea" name="theme_options[address]"><?php echo $strAddress;?></textarea>
                    </div>
                </div>
                <?php submit_button(); ?>
            </form>
        </div>
    <?php }
}
new Theme_Controller();
?>


