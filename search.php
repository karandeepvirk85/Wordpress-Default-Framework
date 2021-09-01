<?php
/**
 * Template for Search Page
 * Theme Name: gTheme
 * Template Author: Karandeep Singh Virk
 */
get_header();
if ( have_posts() ) :
while ( have_posts() ) : the_post();
    endwhile;
endif;
get_footer();
?>