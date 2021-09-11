<?php 
/**
 * Home Page FAQS
 */
if(class_exists('Theme_Controller')){

    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'faqs',6);
    
    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
    
    $arrTitleContainer = array(
        'title' => 'FAQS',
        'url' => 'all-faqs'
    );
}
?>

<div class="container faqs-container">
    <?php get_template_part('templates/home-page/gtheme','home_title_container', $arrTitleContainer);?>
    <!--INCLUDE PAGE TITLE-->
    <div class="row">
        <div class="col-md-12">
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