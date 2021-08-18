<?php
/**
 * Template for default WP pages
 * Theme Name: gTheme
 * Template Author: Karandeep Singh Virk
 */
get_header();
?>
<div class="container page-container">
    <?php
    if (have_posts()) :
        while (have_posts()) : 
            the_post();
            get_template_part('templates/page-title');
            get_template_part('templates/page-content');
        endwhile;
    endif;
    ?>
</div>
<?php get_footer();?>