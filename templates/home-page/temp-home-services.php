<?php
/**
 * This template is for Home Page Services
 */

 if(class_exists('Theme_Controller')){
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'services',6);
    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
    $arrTitleContainer = array(
        'title' => 'Visa Categories',
        'url' => 'services'
    );
}
?>
<div class="container services-container">
 <?php get_template_part('templates/home-page/gtheme','home_title_container', $arrTitleContainer);?>
    <div class="services-row-grid">
        <?php 
        if ($allPostsWPQuery->have_posts()){
            $intCount = 0;
            while ($allPostsWPQuery->have_posts() ) : $allPostsWPQuery->the_post(); $intCount++;?>
                <div class="services-col">
                    <div class="services-icons" style="background-color:<?php echo $strThemeSecondaryColor;?>"> 
                        <?php echo get_post_meta($post->ID,'services_icon',true);?>
                    </div>
                    <h2><?php the_title();?></h2>
                    <?php 
                        if(class_exists('Theme_Controller')){
                            echo Theme_Controller::getFilteredContent($post->post_content,true,250);
                        }
                    ?>
                    <p>
                        <a class="btn btn-secondary btn-theme" href="<?php echo get_permalink($post->ID);?>" role="button">View Category</a></p>
                </div>
            <?php
                endwhile;
                wp_reset_postdata(); 
            }?>
    </div>
</div>