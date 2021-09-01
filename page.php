<?php
/**
 * Template for default WP pages
 * Theme Name: gTheme
 * Template Author: Karandeep Singh Virk
 */
get_header();
?>

<div class="container single-container">
    <?php
    if(have_posts()) :
        while (have_posts()) : 
            the_post();
            get_template_part('templates/page-title');?>
                <img class="img-fluid" src="<?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostImage($post->ID,'large');}?>">
                <div class="page-content">
                    <?php get_template_part('templates/page-content');?>
                </div>
                <?php
        endwhile;
    endif;
    ?>
</div>
<?php get_footer();?>