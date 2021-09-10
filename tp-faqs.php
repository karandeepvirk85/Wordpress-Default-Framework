<?php 
/**
 * Template Name: FAQs
 */
get_header();

if(class_exists('Theme_Controller')){
    $paged = Theme_Controller::getPagedQuery();
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'faqs',-1);
    $argsPagination = Theme_Controller::getArgsForPagination($paged, 1);
    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
    $arrTitleContainer = array(
        'title' => 'FAQS',
        'url' => 'faqs'
    );
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