<?php 
/**
 * Template Name: Services
 * This Template Display ALL Services
 */
get_header();

// If Theme Controller and Testimonials Cntroller Exists Get All Testimonails 
if(class_exists('Theme_Controller') && class_exists('Services_Controller')){
    // Get All Testimonails
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,Services_Controller::$arrPostConfig['post_type'],-1);
    // Args For Pagination
    $paged = Theme_Controller::getPagedQuery();
    $args = Theme_Controller::getArgsForPagination($paged, $allPostsWPQuery->max_num_pages);
}
?>

<?php get_template_part('templates/gtheme','wp_page');?>
    <div class="container services-container">
        <div class="posts-row">
            <?php
                if($allPostsWPQuery->have_posts()){
                    $intCount = 0;
                    while ($allPostsWPQuery->have_posts() ) : $allPostsWPQuery->the_post();
                        $intCount++;
                        get_template_part( 'templates/gtheme','all_posts',$args);
                    endwhile;
                wp_reset_postdata();
            }?>
        </div>
        
        <!-------INLUDE PAGE CONTAINER------->
        <div class="row">    
            <div class="col-md-12 pagination-container">
                <?php get_template_part('templates/gtheme','custom_pagination',$args); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>