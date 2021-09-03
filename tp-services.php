<?php 
/**
 * Template Name: Services
 */
get_header();

if(class_exists('Theme_Controller')){
    $paged = Theme_Controller::getPagedQuery();
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'services',-1);
    $args = Theme_Controller::getArgsForPagination($paged, $allPostsWPQuery->max_num_pages);
    $args['columns'] = 3;
}
?>

<div class="container services-container">
    <!--INCLUDE PAGE TITLE-->
    <?php get_template_part('templates/page-title');?>  
    <div class="row">
        <div class="col-md-12">
            <div class="row posts-row">
                <?php
                    if($allPostsWPQuery->have_posts()){
                        $intCount = 0;
                        while ($allPostsWPQuery->have_posts() ) : $allPostsWPQuery->the_post();
                            $intCount++;
                            get_template_part( 'templates/gtheme','all_posts',$args);
                            echo ($intCount % 4 == 0) ? '</div><div class="row posts-row">' : "";
                        endwhile;
                    wp_reset_postdata(); 
                 }?>
            </div>
        </div>
    </div>
    
    <!-------INLUDE PAGE CONTAINER------->
    <div class="row">    
        <div class="col-md-12 pagination-container">
            <?php get_template_part('templates/gtheme','custom_pagination',$args); ?>
        </div>
    </div>
</div>
<?php get_footer();?>