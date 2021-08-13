<?php
/**
 * Template for default WP pages
 * Theme Name: gTheme
 * Template Author: Karandeep Singh Virk
 */
get_header();
if ( have_posts() ) :
while ( have_posts() ) : the_post();
    // Display post
    var_dump($post);
    endwhile;
endif;
get_footer();
?>