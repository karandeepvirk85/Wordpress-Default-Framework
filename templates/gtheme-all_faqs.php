<?php 
/**
 * Template Name: Faqs
 */
get_header();
if(class_exists('Theme_Controller')){
    // Get Paged Query
    $paged = Theme_Controller::getPagedQuery();
    // Get Posts Query
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'faqs',$args['number_of_faqs']);
    // Set Args for Pagination
    $argsPagination = Theme_Controller::getArgsForPagination($paged, 1);

    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
}
?>

<div class="container faqs-container">
    <div class="title-container">
        <h1>FREQUENTLY ASKED QUESTION</h1>
        <?php if (is_front_page()){?>
            <a style="border: 2px solid <?php echo $strThemeSecondaryColor;?>;color: <?php echo $strThemeSecondaryColor;?>" href="<?php echo home_url();?>/faqs" class="btn-theme btn btn-outline-success btn-lg">View All Faqs</a>
        <?php }?>
    </div>
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