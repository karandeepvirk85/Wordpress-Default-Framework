<?php
/**
 * Template Name: Home
 */
get_header();
    $args = array(
        'number_of_faqs' => 4,
    );
    get_template_part('templates/mega-slider');
    get_template_part('templates/home-services');
    get_template_part('templates/two-pages');
    get_template_part('templates/home-posts');
    get_template_part('templates/home-testimonials');
    get_template_part( 'templates/gtheme','all_faqs',$args);
get_footer();