<?php
/**
 * Template Name: Home
 */
get_header();
    ?>
    <div class="home-page">
        <?php 
            get_template_part('templates/home-page/temp-mega-slider');
            get_template_part('templates/home-page/temp-home-services');
            get_template_part('templates/home-page/temp-two-pages');
            get_template_part('templates/home-page/temp-home-posts');
            get_template_part('templates/home-page/temp-home-testimonials');
            get_template_part('templates/gtheme','all_faqs');
            get_template_part('templates/home-page/temp-google-map-contact');
        ?>
    </div>
<?php get_footer();?>