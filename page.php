<?php
/**
 * Template for default WP pages
 * Theme Name: gTheme
 * Template Author: Karandeep Singh Virk
 */
get_header();
$args['post_type'] = 'page';
?>

<?php 
    get_template_part('templates/gtheme','single_post', $args);
?>

<?php get_footer();?>