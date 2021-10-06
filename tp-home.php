<?php
/**
 * Template Name: Home
 */

get_header();
    ?>
    <div class="home-page">
        <?php 
            get_template_part('templates/home-page/template-mega-slider');
            get_template_part('templates/home-page/template-home-services');
            get_template_part('templates/home-page/template-two-pages');
            get_template_part('templates/home-page/template-home-posts');
            get_template_part('templates/home-page/template-home-testimonials');
            get_template_part('templates/home-page/template-faqs');
            get_template_part('templates/home-page/template-google-map-contact');
        ?>
    </div>
<?php get_footer();?>