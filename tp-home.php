<?php
/**
 * Template Name: Home
 */
get_header();
    $args = array(
        'number_of_faqs' => 6,
    );
    ?>
    <div class="home-page">
        <?php 
            get_template_part('templates/mega-slider');
            get_template_part('templates/home-services');
            get_template_part('templates/two-pages');
            get_template_part('templates/home-posts');
            get_template_part('templates/home-testimonials');
            get_template_part('templates/gtheme','all_faqs',$args);
            get_template_part('templates/google-map');
        ?>
    </div>
<?php get_footer();?>