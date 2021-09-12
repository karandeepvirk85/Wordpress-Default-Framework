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
        $strFacebook            = self::get_theme_option('facebook'); 
        $strTwitter             = self::get_theme_option('twitter');
        $strYoutube             = self::get_theme_option('youtube'); 
        $strInstagram           = self::get_theme_option('instagram');
        $strEmail               = self::get_theme_option('email');
        $strContact             = self::get_theme_option('contact');
        $strAddress             = self::get_theme_option('address');
        $strNumberOfSlides      = self::get_theme_option('number_of_slides'); 
        $intSliderSpeed         = self::get_theme_option( 'slider_speed' ); 
        $strPrimaryColor        = self::get_theme_option('primary_color');  
        $strSecondaryColor      = self::get_theme_option( 'secondary_color' ); 
        $strLogo                = self::get_theme_option( 'site_logo' );
        $strLogoWidth           = self::get_theme_option('logo_width');
        $strFooterText          = self::get_theme_option('footer_text');
        $strMapIframeHtml       = self::get_theme_option('google_map');
        $strLogoTitle           = self::get_theme_option('logo_title');
        $strNotificationText    = self::get_theme_option('notification_text');
        $strNotificationLink    = self::get_theme_option('notification_link');
        $strNotificationValue    = self::get_theme_option('notification_turn_on');
        
        // Build Posts Options Array
        $arrPostOptions = array();
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'numberposts' => -1
        );
        $arrPosts = get_posts($args);

        if(!empty($arrPosts)){
            foreach($arrPosts as $key => $objPosts){
                $arrPostOptions[$objPosts->ID] = $objPosts->post_title;
            }
        }

        $arrPageOptions = array();
        $args = array(
            'post_type' => 'page',
            'posts_per_page' => -1,
            'numberposts' => -1
        );

        $arrPages = get_posts($args);

        if(!empty($arrPages)){
            foreach($arrPages as $key => $objPages){
                $arrPageOptions[$objPages->ID] = $objPages->post_title;
            }
        }
    ?>
    <div class="settings-container">
        <h1>Theme Settings</h1>
        <form method="post" action="options.php">    
            <?php settings_fields( 'theme_options' ); ?>
            <!--Logo Information-->
            <div class="settings-information-header">
                <h1>Site Logo Options</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">
                <div class="settings-site-logo-input">
                    <h3>Logo URL</h3>
                    <input type="text" class="settings-input" name="theme_options[site_logo]" value="<?php echo $strLogo; ?>">
                    <?php if(!empty($strLogo)){?>
                        <div class="settings-site-logo">
                            <img src="<?php echo esc_attr($strLogo); ?>">
                        </div>
                    <?php }?>
                    <h3>Logo Width</h3>
                    <input type="number" placeholder="Width in Pixels" class="settings-number" name="theme_options[logo_width]" value="<?php echo $strLogoWidth; ?>">
                    <h3> Logo Text</h3>
                    <input type="text" class="settings-input" name="theme_options[logo_title]" value="<?php echo $strLogoTitle;?>">
                </div>
            </div>
            
            <!--Theme Color Options-->
            <div class="settings-information-header">
                <h1>Theme Color Options</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">   
                <div class="settings-site-header-input">
                    <h3>Primary Color</h3>
                    <input type="color" name="theme_options[primary_color]" value="<?php echo $strPrimaryColor; ?>">
                    <?php if(!empty($strPrimaryColor)){?>
                        <div class="header-color" style="background-color:<?php echo $strPrimaryColor;?>"></div>
                    <?php }?>
                </div>

                <div class="settings-site-header-input">
                    <h3>Secondary Color</h3>
                    <input type="color" name="theme_options[secondary_color]" value="<?php echo $strSecondaryColor; ?>">
                    <?php if(!empty($strSecondaryColor)){?>
                        <div class="header-color" style="background-color:<?php echo $strSecondaryColor;?>"></div>
                    <?php }?>
                </div>
            </div>

            <!--Slider Information-->
            <div class="settings-information-header">
                <h1>Home Page Slider</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">            
                
                <h3>Number of Slides</h3>
                <input type="number" class="settings-input-number" name="theme_options[number_of_slides]" value="<?php echo $strNumberOfSlides; ?>">
                
                <h3>Slider Transition Speed</h3>
                <input type="number" class="settings-input-number-speed" name="theme_options[slider_speed]" value="<?php echo $intSliderSpeed; ?>">
                <div class="description">2000 is approximately 1 second</div>
                
                <?php
                    if($strNumberOfSlides > 0){
                        for ($i=1; $i<=$strNumberOfSlides; $i++){
                            $strImageUrl = self::get_theme_option('slider_image_'.$i);
                            $strCaptionText = self::get_theme_option('slider_caption_'.$i);
                            $strButtonTitle = self::get_theme_option('slider_button_title_'.$i);
                            $strButtonLink = self::get_theme_option('slider_button_link_'.$i);
                            $strImageCredit = self::get_theme_option('slider_image_credit_'.$i);
                            ?>

                            <div class="settings-information-header inner-slider">
                                <h1>Slide <?php echo $i?> </h1>
                                <i class="fas fa-chevron-down"></i>
                            </div>

                            <div class="settings-information hide-div">
                                <h3>Image <?php echo $i?> URL</h3>
                                <input placeholder="Paste Slider Image Url Here" type="text" class="settings-input" name="theme_options[slider_image_<?php echo $i;?>]" value="<?php echo $strImageUrl;?>">
                                <h3>Image <?php echo $i?> Caption </h3>
                                <input placeholder="Write Your Captions Here" type="text" class="settings-input" name="theme_options[slider_caption_<?php echo $i;?>]" value="<?php echo $strCaptionText;?>">
                                <h3>Image <?php echo $i?> Credit </h3>
                                <input placeholder="Image Credit If Any" type="text" class="settings-input" name="theme_options[slider_image_credit_<?php echo $i;?>]" value="<?php echo $strImageCredit;?>">
                                
                                <?php if(!empty($strImageUrl)){?>
                                    <div class="settings-slider-image">
                                        <img src="<?php echo $strImageUrl; ?>">
                                    </div>
                                    <?php }?>
                                <h3>Image Caption  Button Title <?php echo $i?> </h3>
                                <input placeholder="Write Your Button Title Here" type="text" class="settings-input" name="theme_options[slider_button_title_<?php echo $i;?>]" value="<?php echo $strButtonTitle;?>">
                                <h3>Image Caption  Button Link <?php echo $i?> </h3>
                                <input placeholder="Write Your Button Link Here" type="text" class="settings-input" name="theme_options[slider_button_link_<?php echo $i;?>]" value="<?php echo $strButtonLink;?>"> 
                            </div>
                        <?php }?>
                    <?php }
                ?>
            </div> 
                
            <!--Home Page Blog Information-->
            <div class="settings-information-header">
                <h1>Home Blogs Section</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">
                <?php for($i = 1; $i<=3; $i++){?>
                <?php $intBlogId = self::get_theme_option( 'home_section_blog_'.$i); ?>
                    <h3>Blog Post <?php echo $i?></h3>
                    <p>
                        <select name="theme_options[home_section_blog_<?php echo $i;?>]">
                            <option value="">Select Post</option>
                            <?php
                                foreach ($arrPostOptions as $id => $label) { ?>
                                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected($intBlogId, $id, true); ?>>
                                        <?php echo strip_tags( $label ); ?>
                                    </option>
                                <?php } 
                            ?>
                        </select>
                    </p>
                    <hr/>
                <?php }?>
            </div>

            <!--Home Page Section-->
            <div class="settings-information-header">
                <h1>Notification Bar</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">
                <h3>Notification Text</h3>
                <input type="text" name="theme_options[notification_text]" value="<?php echo $strNotificationText;?>">
                <h3>Notification Link</h3>
                <input type="text" placeholder="Notification Link" name="theme_options[notification_link]" value="<?php echo $strNotificationLink;?>">
                <h3>Check to Turn On</h3>
                <input type="checkbox" value="on" name="theme_options[notification_turn_on]" <?php echo ($strNotificationValue  == "on")     ? "checked" : "";?>>
            </div>

            <!--Home Page Section-->
            <div class="settings-information-header">
                <h1>Home Two Pages Settings</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">
                <?php for($i = 1; $i<=2; $i++){?>
                <?php 
                    $intPageId = self::get_theme_option('home_section_page_'.$i); 
                    $strButtonTitle = self::get_theme_option('page_button_title_'.$i);
                    ?>
                    <h3>Page <?php echo $i?></h3>
                    <p>
                        <select name="theme_options[home_section_page_<?php echo $i;?>]">
                            <option value="">Select Page</option>
                            <?php
                                foreach ($arrPageOptions as $id => $label) { ?>
                                    <option value="<?php echo esc_attr( $id ); ?>" <?php selected($intPageId, $id, true); ?>>
                                        <?php echo strip_tags( $label ); ?>
                                    </option>
                                <?php } 
                            ?>
                        </select>
                        <hr/>
                        <input placeholder="Write your button title here" type="text" name="theme_options[page_button_title_<?php echo $i;?>]" value="<?php echo $strButtonTitle;?>">
                    </p>
                    <hr/>
                <?php }?>
            </div>

            <!--Contact Information-->
            <div class="settings-information-header">
                <h1>Contact Information</h1>
                <i class="fas fa-chevron-down"></i>
            </div>
            
            <div class="settings-information hide-div">
                <h3> Facebook</h3>
                <input type="text" name="theme_options[facebook]" value="<?php echo $strFacebook;?>">

                <h3> Twitter</h3>
                <input type="text" name="theme_options[twitter]" value="<?php echo $strTwitter;?>">        

                <h3> Youtube</h3>
                <input type="text" name="theme_options[youtube]" value="<?php echo $strYoutube;?>">

                <h3> Instagram</h3>
                <input type="text" name="theme_options[instagram]" value="<?php echo $strInstagram;?>">

                <h3> Email</h3>
                <input type="email" name="theme_options[email]" value="<?php echo $strEmail;?>">

                <h3> Contact</h3>
                <input type="text" name="theme_options[contact]" value="<?php echo $strContact;?>">

                <h3> Address</h3>
                <textarea class="settings-input-textarea" name="theme_options[address]"><?php echo $strAddress;?></textarea>
            </div>

            <div class="settings-information-header">
                <h1>Google Map IFrame</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">
                <h3>Iframe HTML</h3>
                <textarea name="theme_options[google_map]"><?php echo $strMapIframeHtml;?></textarea>
            </div>

            <div class="settings-information-header">
                <h1>Footer Settings</h1>
                <i class="fas fa-chevron-down"></i>
            </div>

            <div class="settings-information hide-div">
                <h3>Footer Text</h3>
                <textarea name="theme_options[footer_text]"><?php echo $strFooterText;?></textarea>
            </div>
            <?php submit_button('Update Changes'); ?>
        </form>
    </div>
    <?php }

    /**
     * Check Notification Status
     */
    public static function isNotificationOn(){
        // Set Initial Value
        $bolReturn = false;
        // Get Value
        $strValue = self::get_theme_option('notification_turn_on');
        // if Value is On set Variable to true
        if($strValue == 'on'){
            $bolReturn = true;
        }
        return $bolReturn;
    } 

    /**
     * Add HTTP In front of URL if it does not exist
     *  
     */
    public static function getURLwithHttpIfNotadded($urlString){
        // Default Value to return
        $strReturn = $urlString;
        // if Not Matched the following pattern then add HTTP
        if(!preg_match("~^(?:f|ht)tps?://~i", $urlString)){
            $strReturn = 'http://'.$urlString;
        }
        return $strReturn;
    }
}

new Theme_Controller();
?>

