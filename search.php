<?php
/**
 * Template for default WP pages
 * Theme Name: gTheme
 * Template Author: Karandeep Singh Virk
 */
get_header();?>
<div class="container-fluid">
    <p></p>
    <div class="container page-container search">
        <h1>Search Results</h1>
        <?php
        if(have_posts()) :
            while (have_posts()) : 
                the_post();?>
            <div class="page-content">
                <p><i class="fas fa-chevron-right"></i> <a href="<?php echo get_permalink($post->ID);?>"><?php the_title();?></a></p>
            </div>
            <?php
            endwhile;
            endif;
        ?>
    </div>
</div>
<?php get_footer();?>