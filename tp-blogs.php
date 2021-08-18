<?php 
/**
 * Template Name: Blogs
 */
get_header();
if(class_exists('Theme_Controller')){
    // Get Paged Query
    $paged = Theme_Controller::getPagedQuery();
    // Get Posts Query
    $arrBlogs = Theme_Controller::getAllPosts($paged,'post',2);
    // Set Args for Pagination
    $args = Theme_Controller::getArgsForPagination($paged, $arrBlogs->max_num_pages);
}
?>

<div class="container page-container">
    <?php get_template_part('templates/page-title');?>  
    <?php get_template_part( 'templates/gtheme','custom_pagination',$args); ?>
</div>
<?php get_footer();?>