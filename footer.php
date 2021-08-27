<?php 
    $strFacebook            = Theme_Controller::get_theme_option('facebook'); 
    $strTwitter             = Theme_Controller::get_theme_option('twitter');
    $strYoutube             = Theme_Controller::get_theme_option('youtube'); 
    $strInstagram           = Theme_Controller::get_theme_option('instagram');
    $strEmail               = Theme_Controller::get_theme_option('email');
    $strContact             = Theme_Controller::get_theme_option('contact');
    $strAddress             = Theme_Controller::get_theme_option('address');
    $arrFooterMenu          = Theme_Controller::getMenuByName('Footer Menu');
    $strLogoWidth 	        = Theme_Controller::get_theme_option('logo_width');
    $strSiteLogo 	        = Theme_Controller::get_theme_option('site_logo');
    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
    $strFooterText          = Theme_Controller::get_theme_option('footer_text');
?>
<div class="footer-container container-fluid">
    <div class="inner-footer">
        <div class="row footer-row">
            <div class="col-md-6 footer-col footer-first-col">
                <div class="footer-logo">
                    <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-canadian-maple-leaf"></i>
                    <p class="footer-logo-text" style="color:<?php echo $strThemeSecondaryColor;?>"> Travel & Immigration</p>
                </div>

                <div class="footer-text">
                    <?php echo $strFooterText;?>
                </div>
                <div class="footer-info">
                    <p class="footer-address"><?php echo $strAddress;?></p>
                    <p class="footer-contact"><i class="fas fa-phone-square"></i> <strong>Contact: </strong> <a href="tel:<?php echo $strContact;?>"><?php echo $strContact;?></a></p>
                    <p class="footer-email"><i class="fas fa-envelope"></i> <strong>Email: </strong> <a href="mailto:<?php echo $strEmail;?>"><?php echo $strEmail;?></a></p>
                </div>
            </div>
            <div class="col-md-3 footer-col footer-menu">
                <h3>Important Links</h3>
                <ul>
                <?php 
                if(!empty($arrFooterMenu)){
                    foreach($arrFooterMenu as $arrFooterMenuItems){?>
                        <li><a href="<?php echo $arrFooterMenuItems['url'];?>"><?php echo $arrFooterMenuItems['title'];?></a></li>
                    <?php }?>
                <?php }?>
                <ul>
            </div>
            <div class="col-md-3 footer-col footer-social">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <a target="_blank" href="<?php echo $strFacebook?>">
                                <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-facebook-square"></i>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <a target="_blank" href="<?php echo $strTwitter?>">
                                <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-twitter-square"></i>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p>
                            <a target="_blank" href="<?php echo $strYoutube?>">
                                <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-youtube-square"></i>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            <a target="_blank" href="<?php echo $strInstagram?>">
                                <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-instagram-square"></i>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="row footer-bottom-row">
                <div class="col-md-4 copyright"><?php echo date('Y');?> <i class="fas fa-copyright"></i> <?php echo get_bloginfo('name')?>. All Rights Reserved</div>
                <div class="col-md-4 policy text-center"><a href="privacy-policy"> Read Our Privacy Policy</a></div>
                <div class="col-md-4 text-center developer">Designed and Developed By <a targer="_blank" href="https://karandeepvirk.in">Karandeep Singh</a></div>
            </div>
        </div>
    </div>
</div>
<?php wp_footer(); ?>