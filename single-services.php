<?php
/**
 * Template for default Services Page
 * Theme Name: gTheme
 * Template Author: Karandeep Singh Virk
 */
get_header();
$args['columns'] = 12;
?>
<div class="container-fluid page-container single-post-container single-services-container">
   <div class="row posts-row single-post single-service-page">
        <?php get_template_part( 'templates/gtheme','all_posts',$args);?>
    </div>
</div>
<?php get_footer();?>