<?php 
/**
 * Template for Single Posts
 */
get_header();

$args['post_type'] = 'post';

if(is_singular('services')){
    
    $args['post_type'] = 'services';

}else if(is_singular('testimonials')){
    
    $args['post_type'] = 'testimonials';
}
else if(is_singular('post')){
    $args['post_type'] = 'post';
}

get_template_part('templates/gtheme','single_post',$args);

?>

<?php get_footer();?>