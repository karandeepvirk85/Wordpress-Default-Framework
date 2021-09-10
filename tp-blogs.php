<?php 
/**
 * Template Name: Blogs
 */

get_header();

if(class_exists('Theme_Controller')){
    $paged = Theme_Controller::getPagedQuery();
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'post',4);
    $args = Theme_Controller::getArgsForPagination($paged, $allPostsWPQuery->max_num_pages);
    $args['columns'] = 4;
}
?>
<?php get_template_part('templates/gtheme','wp_page');?>
    <div class="blog-container container">
        <!--INCLUDE PAGE TITLE-->
        <div class="row">
            <div class="col-md-9">
                <div class="row posts-row">
                    <?php 
                        if($allPostsWPQuery->have_posts()){
                            $intCount = 0;
                            while($allPostsWPQuery->have_posts() ) : $allPostsWPQuery->the_post();
                                $intCount++;
                                get_template_part( 'templates/gtheme','all_posts',$args);
                                echo ($intCount % 3 == 0) ? '</div><div class="row posts-row">' : "";
                            endwhile;
                            wp_reset_postdata(); 
                        }
                    ?>
                </div>
            </div>
            
            <!-------INLUDE SIDE BAR------->
            <div class="col-md-3 sidbar-container">    
                <?php  get_template_part('templates/blog-sidebar');?>
            </div>  
        </div>
        
        <!-------INLUDE PAGE CONTAINER------->
        <div class="row">    
            <div class="col-md-12 pagination-container">
                <?php get_template_part( 'templates/gtheme','custom_pagination',$args); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer();?>