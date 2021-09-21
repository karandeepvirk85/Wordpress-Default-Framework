<?php 
/**
 * Template Name: FAQs
 *
 */
get_header();

// If Theme Controller and Testimonials Cntroller Exists Get All Testimonails 
if(class_exists('Theme_Controller') && class_exists('Faqs_Controller')){
    // Get All Testimonails
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,Faqs_Controller::$arrPostConfig['post_type'],-1);
    // Args For Pagination
    $paged = Theme_Controller::getPagedQuery();
    $args = Theme_Controller::getArgsForPagination($paged, $allPostsWPQuery->max_num_pages);
    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
}
?>

<?php get_template_part('templates/gtheme','wp_page');?>            
    <div class="container faqs-container">
        <?php 
            if($allPostsWPQuery->have_posts()){
                $intCount = 0;
                while ($allPostsWPQuery->have_posts() ) : $allPostsWPQuery->the_post();
                    $intCount++;
                    ?>
                    <div class="faqs-inner-container">
                        <div class="faqs-question">
                            <h4><?php the_title();?></h4>
                            <i style="color:<?php echo $strThemeSecondaryColor;?>" class="fas fa-toggle-off"></i>
                        </div>
                        <div class="faqs-answer hide-answer animate__animated animate__fadeInUp animate__faster">
                            <?php echo Theme_Controller::getFilteredContent($post->post_content,true,'400');?>
                        </div>
                        </div>
                    <?php
                endwhile;
            wp_reset_postdata(); 
            }?>
        </div>
    </div>
</div>
<?php get_footer();?>