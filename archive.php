<?php 
/**
 * 
 */
get_header();
?>
<?php 
   if (have_posts()) :
    while (have_posts()) : 
        the_post();
var_dump($post);
    endwhile;
endif;
?>
<?php get_footer();?>