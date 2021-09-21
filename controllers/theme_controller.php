<?php
if(!defined('ABSPATH')) exit; 
class Theme_Controller{
    public function __construct() {
        if (is_admin()){
            add_action( 'admin_menu', array( __CLASS__, 'add_admin_menu' ));
            add_action( 'admin_init', array( __CLASS__, 'register_settings'));
        }
        add_action('wp_ajax_close-notification', array(__CLASS__,'updateNotificationSession'));
        add_action('wp_ajax_nopriv_close-notification', array(__CLASS__,'updateNotificationSession'));

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
        var_dump($options);
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

    /**
     * Build HMTL Based on array  
     */
    public static function loadSettingsFields($arrOptions){

        $strCompleteHTML = '';

        if(!empty($arrOptions)){
            $arrHtmlTypes = array_keys($arrOptions);
            foreach($arrHtmlTypes as $key => $strHtmlType){
                // If HTML Type is Accordians
                if($strHtmlType == 'accordians'){
                   if(!empty($arrOptions['accordians']['options'])){
                        foreach($arrOptions['accordians']['options'] as $arrInputOptions){
                            $strSubComplete = '';
                            $strHeaderHtml  = '';
                            $strHeaderHtml .= '<div class="settings-information-header">';
                            $strHeaderHtml .= '<h1>'.$arrInputOptions['title'].'</h1>';
                            $strHeaderHtml .= '<i class="fas fa-chevron-down"></i>';
                            $strHeaderHtml .= '</div>';
                            $strHeaderHtml .= '<div class="settings-information hide-div">';
                            // Fields Array
                            foreach ($arrInputOptions['fields'] as $arrFields){
                                $strBodyHtml = '';
                                
                                // If Field Title is set
                                if (isset($arrFields['field_title'])){
                                    $strBodyHtml .= '<h3>'.$arrFields['field_title'].'</h3>';
                                }
                                
                                // If Input Type is Text
                                if($arrFields['field_type'] == 'text'){
                                    $strBodyHtml .= '<input type="text" placeholder="'.$arrFields['placeholder'].'" class="settings-input" name="theme_options['.$arrFields['field_key'].']" value="'.self::get_theme_option($arrFields['field_key']).'">';
                                    if(isset($arrFields['sub_type'])){
                                        if($arrFields['sub_type'] == 'image'){
                                            if(!empty(self::get_theme_option($arrFields['field_key']))){
                                                $strBodyHtml .= '<div class="settings-site-logo"><img src="'.esc_attr(self::get_theme_option($arrFields['field_key'])).'"></div>';
                                            }
                                        }
                                    }
                                }

                                // If Input Type is Number
                                if($arrFields['field_type'] == 'number'){
                                    $strBodyHtml .= '<input type="number" placeholder="'.$arrFields['placeholder'].'" class="settings-input" name="theme_options['.$arrFields['field_key'].']" value="'.self::get_theme_option($arrFields['field_key']).'">';
                                }

                                // If Input Type is Checkbox
                                if($arrFields['field_type'] == 'checkbox'){
                                    $strChecked = '';
                                    if(self::get_theme_option($arrFields['field_key']) == 'on'){
                                        $strChecked = 'checked';
                                    }
                                    $strBodyHtml .= '<input '.$strChecked.' type="checkbox" value="'.$arrFields['value'].'" name="theme_options['.$arrFields['field_key'].']">';
                                }

                                // If Input Type is Color
                                if($arrFields['field_type'] == 'color'){
                                    $strBodyHtml .= '<input type="color" class="settings-input" name="theme_options['.$arrFields['field_key'].']" value="'.self::get_theme_option($arrFields['field_key']).'">';
                                }

                                // If Input Type is Textarea
                                if($arrFields['field_type'] == 'textarea'){
                                    $strBodyHtml .= '<textarea placeholder="'.$arrFields['placeholder'].'" name="theme_options['.$arrFields['field_key'].']">'.self::get_theme_option($arrFields['field_key']).'</textarea>';
                                }

                                // If Input Type is Function
                                if($arrFields['field_type'] == 'function'){
                                    $arrParameters = array('repeat' => $arrFields['repeat']);
                                    $strBodyHtml .= call_user_func('Theme_Controller::' . $arrFields['function_name'], $arrParameters);
                                }

                                // If Input Type is select
                                if($arrFields['field_type'] == 'select'){
                                    $strBodyHtml .= '<select name="theme_options['.$arrFields['field_key'].']">';

                                    if(isset($arrFields['default_option'])){
                                        $strBodyHtml .= '<option value="">'.$arrFields['default_option'].'</option>';
                                    }

                                    foreach ($arrFields['select_options'] as $id => $strLabel){  
                                        $strSelected = self::get_theme_option($arrFields['field_key']) == $id ? "selected" : "";
                                        $strBodyHtml .= '<option value="'.esc_attr($id).'" '.$strSelected.'>';
                                        $strBodyHtml .= strip_tags($strLabel);
                                        $strBodyHtml .= '</option>';
                                    }

                                    $strBodyHtml .= '</select>';
                                }

                                // If description is set
                                if(isset($arrFields['description'])){
                                    $strBodyHtml .= '<div class="description">'.$arrFields['description'].'</div>';
                                }

                                $strSubComplete .= $strBodyHtml;
                            }
                            $strBodyEnd = '</div>';
                            $strCompleteHTML .= $strHeaderHtml.$strSubComplete.$strBodyEnd;
                        }
                    }
               }
           }
       }
       return $strCompleteHTML;
    }

    /**
     * This function return HTML to make accordians
     */
    public static function getSlidesLoop($arrParameters){
        $strHtml = '';

        for ($i=1; $i<=$arrParameters['repeat']; $i++){
            $strImageUrl    = self::get_theme_option('slider_image_'.$i);
            $strCaptionText = self::get_theme_option('slider_caption_'.$i);
            $strButtonTitle = self::get_theme_option('slider_button_title_'.$i);
            $strButtonLink  = self::get_theme_option('slider_button_link_'.$i);
            $strImageCredit = self::get_theme_option('slider_image_credit_'.$i);
            ob_start();
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
            <?php 
            $strHtml .= ob_get_clean();
            ob_end_flush();
        }
        return $strHtml;
    }

    /**
     * Get Post Options For Select or Other Pusposes
     * 
     */

    public static function getPostOptions($strPostType){
        $arrReturn = array();
        $args = array(
            'post_type' => $strPostType,
            'posts_per_page' => -1,
            'numberposts' => -1
        );

        $arrPosts = get_posts($args);

        if(!empty($arrPosts)){
            foreach($arrPosts as $key => $objPosts){
                $arrReturn[$objPosts->ID] = $objPosts->post_title;
            }
        }
        return $arrReturn;
    }

    public static function addThemeOptions(){
        // Get Post Options
        $arrPostOptions = self::getPostOptions('post');
        $arrPageOptions = self::getPostOptions('page');
        
        // Set Array for accordians fields
        $arrReturn = array(
            'accordians' => array(
                'options' => array(
                    array(
                        'title' => 'Notification Bar',
                        'fields' => array(
                            array(
                                'field_title' => 'Notification Text',
                                'field_type' => 'text',
                                'field_key' => 'notification_text',
                                'placeholder' => 'Write Notification Text Here'     
                            ),
                            array(
                                'field_title' => 'Notification Link',
                                'field_type' => 'text',
                                'field_key' => 'notification_link',
                                'placeholder' => 'Paste Notification Link Here'
                            ),
                            array(
                                'field_title' => 'Check to Turn On',
                                'field_type' => 'checkbox',
                                'field_key' => 'notification_turn_on',
                                'placeholder' => 'Paste Notification Link Here',
                                'description' => 'UnCheck to turn off',
                                'value' => 'on'
                            ),
                        ),
                    ),

                    array(
                        'title' => 'Site Logo Options',
                        'fields' => array(
                            array(
                                'field_title' => 'Logo URL',
                                'field_type' =>'text',
                                'field_key' => 'site_logo',
                                'sub_type' => 'image',
                                'placeholder' => 'Logo URL'       
                            ),
                            array(
                                'field_title' => 'Logo Width',
                                'field_type' =>'number',
                                'field_key' => 'logo_width',  
                                'placeholder' => 'Logo Width'     
                            ),
                            array(
                                'field_title' => 'Logo Text',
                                'field_type' =>'text',
                                'field_key' => 'logo_title',
                                'placeholder' => 'Logo Title'
                            ),
                        ),
                    ),

                    array(
                        'title' => 'Theme Color Options',
                        'fields' => array(
                            array(
                                'field_title' => 'Primary Color',
                                'field_type' => 'color',
                                'field_key' => 'primary_color',     
                            ),
                            array(
                                'field_title' => 'Secondary Color',
                                'field_type' => 'color',
                                'field_key' => 'secondary_color',     
                            ),
                        ),
                    ),

                    array(
                        'title' => 'Home Page Slider',
                        'fields' => array(
                            array(
                                'field_title' => 'Number Of Slides',
                                'field_type' => 'number',
                                'field_key' => 'number_of_slides',
                                'placeholder' => 'Number of Slides'
                            ),
                            array(
                                'field_title' => 'Slider Speed',
                                'field_type' => 'number',
                                'field_key' => 'slider_speed',
                                'description' => '2000 is approximately 1 second',
                                'placeholder' => 'Slider Duration'
                            ),
                            array(
                                'field_title' => 'Slides',
                                'repeat' => self::get_theme_option('number_of_slides'),
                                'field_type' => 'function',
                                'function_name' => 'getSlidesLoop'
                            )
                        ),
                    ),

                    array(
                        'title' => 'Home Page Section',
                        'fields' => array(
                            array(
                                'field_title' => 'Page 1',
                                'field_type' => 'select',
                                'field_key' => 'home_section_page_1',
                                'default_option' => 'Select Page',
                                'select_options' => $arrPageOptions
                            ),
                            array(
                                'field_title' => 'Button Title 1',
                                'field_type' => 'text',
                                'field_key' => 'page_button_title_1',
                                'placeholder' => 'Write Button Title Here'     
                            ),
                            array(
                                'field_title' => 'Page 2',
                                'field_type' => 'select',
                                'field_key' => 'home_section_page_2',
                                'default_option' => 'Select Page',
                                'select_options' => $arrPageOptions
                            ),
                            array(
                                'field_title' => 'Button Title 2',
                                'field_type' => 'text',
                                'field_key' => 'page_button_title_2',
                                'placeholder' => 'Write Button Title Here'     
                            ),
                        ),
                    ),

                    array(
                        'title' => 'Home Blogs Section',
                        'fields' => array(
                            array(
                                'field_title' => 'Blog Post 1',
                                'field_type' => 'select',
                                'field_key' => 'home_section_blog_1',
                                'default_option' => 'Select Post',
                                'select_options' => $arrPostOptions
                            ),
                            array(
                                'field_title' => 'Blog Post 2',
                                'field_type' => 'select',
                                'field_key' => 'home_section_blog_2',
                                'default_option' => 'Select Post',
                                'select_options' => $arrPostOptions
                            ),
                            array(
                                'field_title' => 'Blog Post 3',
                                'field_type' => 'select',
                                'field_key' => 'home_section_blog_3', 
                                'default_option' => 'Select Post',
                                'select_options' => $arrPostOptions
                            ),
                        ),
                    ),

                    array(
                        'title' => 'Contact Information',
                        'fields' => array(
                            array(
                                'field_title' => 'Facebook',
                                'field_type' => 'text',
                                'field_key' => 'facebook',
                                'placeholder' => 'Paste Your Facebook Link Here'     
                            ),
                            array(
                                'field_title' => 'Twitter',
                                'field_type' => 'text',
                                'field_key' => 'twitter',
                                'placeholder' => 'Paste Your Twitter Link Here'     
                            ),
                            array(
                                'field_title' => 'Youtube',
                                'field_type' => 'text',
                                'field_key' => 'youtube',
                                'placeholder' => 'Paste Your Youtube Link Here'     
                            ),
                            array(
                                'field_title' => 'Instagram',
                                'field_type' => 'text',
                                'field_key' => 'instagram',
                                'placeholder' => 'Paste Your Instagram Link Here'     
                            ),
                            array(
                                'field_title' => 'Email',
                                'field_type' => 'text',
                                'field_key' => 'email',
                                'placeholder' => 'Paste Your Email Here'     
                            ),
                            array(
                                'field_title' => 'Contact',
                                'field_type' => 'text',
                                'field_key' => 'contact',
                                'placeholder' => 'Paste Your Contact Link Here'     
                            ),
                            array(
                                'field_title' => 'Address',
                                'field_type' => 'textarea',
                                'field_key' => 'address',
                                'placeholder' => 'Write Your Address Here'     
                            ),
                        ),
                    ),

                    array(
                        'title' => 'Google Map',
                        'fields' => array(
                            array(
                                'field_title' => 'Google Map IFRAME',
                                'field_type' => 'textarea',
                                'field_key' => 'google_map',
                                'placeholder' => 'Paste Google IFrame'     
                            ),
                        ),
                    ),

                    array(
                        'title' => 'Footer Settings',
                        'fields' => array(
                            array(
                                'field_title' => 'Footer Text',
                                'field_type' => 'textarea',
                                'field_key' => 'footer_text',
                                'placeholder' => 'Footer Text'     
                            ),
                        ),
                    ),
                ),
            ),
        );

        return $arrReturn;
    }

    /**
     * Create Theme Settings 
     * 
     */
    public static function create_admin_page() {?>
        <div class="settings-container">
            <h1>Theme Settings</h1>
            <form method="post" action="options.php">    
                <?php settings_fields('theme_options'); ?>
                <?php echo self::loadSettingsFields(self::addThemeOptions());?>
                <?php submit_button('Update Settings'); ?>
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

    /**
     * Update Notification Session 
     * 
     */
    public static function updateNotificationSession(){
        $strCurrentDate = strtotime(date('Y-m-d'));
        $_SESSION['notification_close_date'] = $strCurrentDate;
        die;
    }
    
    /**
     * Update Notification Session 
     * why my ears sound pi pi why did you create this piece of human shit.
     */ 
    public static function showNotification(){
        // Default Return
        $intReturn = false;
        $strNotificationClose = '';
        // Get Close Date
        if(isset($_SESSION['notification_close_date'])){
            $strNotificationClose = $_SESSION['notification_close_date'];
        }
        
        // If empty notification closed date 
        if(empty($strNotificationClose)){
           $intReturn = true; 
        }
        else{
            // We compare if its older date | if its equal to today's date default false will be returned by function
            if(strtotime(date('Y-m-d')) > $strNotificationClose){
                $intReturn = true;
            }
        }
        return $intReturn;
    }
}
new Theme_Controller();
?>