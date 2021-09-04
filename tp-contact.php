<?php 
/**
 * Template Name: Contact US
 */
get_header();
$strFacebook            = Theme_Controller::get_theme_option('facebook'); 
$strTwitter             = Theme_Controller::get_theme_option('twitter');
$strYoutube             = Theme_Controller::get_theme_option('youtube'); 
$strInstagram           = Theme_Controller::get_theme_option('instagram');
$strEmail               = Theme_Controller::get_theme_option('email');
$strContact             = Theme_Controller::get_theme_option('contact');
$strAddress             = Theme_Controller::get_theme_option('address');
$strLogoWidth 	        = Theme_Controller::get_theme_option('logo_width');
$strSiteLogo 	        = Theme_Controller::get_theme_option('site_logo');
$strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
 ?>
<div class="container page-container contact-page">
    <div class="row">
        <div class="col-md-12">
            <?php 
            if(have_posts()) :
                while (have_posts()) : 
                    the_post();?>
                    <h1><?php the_title();?></h1>
                    <?php the_content();?>
                    <?php
                endwhile;
            endif;
            ?>
        </div>
    </div>
    <hr/>

    <div class="row">
        <div class="col-md-6">
            <div class="address-info">
                <img style="width:<?php echo $strLogoWidth;?>px;" src="<?php echo $strSiteLogo;?>">
                <h2>Address</h2>
                <p class="footer-address"><i class="fas fa-map-marker"></i> <?php echo $strAddress;?></p>
                <p class="footer-contact"><i class="fas fa-phone-square"></i> <strong>Contact: </strong> <a href="tel:<?php echo $strContact;?>"><?php echo $strContact;?></a></p>
                <p class="footer-email"><i class="fas fa-envelope"></i> <strong>Email: </strong> <a href="mailto:<?php echo $strEmail;?>"><?php echo $strEmail;?></a></p>
            </div>
            <hr/>

            <div class="social-info">
                <h2>Social</h2>
                <p>
                    <a target="_blank" href="<?php echo $strFacebook?>">
                        <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-facebook-square"></i>
                    </a>
                </p>
                
                <p>
                    <a target="_blank" href="<?php echo $strTwitter?>">
                        <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-twitter-square"></i>
                    </a>
                </p>

                <p>
                    <a target="_blank" href="<?php echo $strYoutube?>">
                        <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-youtube-square"></i>
                    </a>
                </p>

                <p>
                    <a target="_blank" href="<?php echo $strInstagram?>">
                        <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fab fa-instagram-square"></i>
                    </a>
                </p>
            </div>
        </div>

        <div class="col-md-6 contact-form">
            <?php get_template_part('templates/contact-form');?>
        </div>
    </div>
</div>
<?php get_footer(); ?>