<?php
 if(class_exists('Theme_Controller')){
    $paged = Theme_Controller::getPagedQuery();
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'services',6);
    $strSecondary = Theme_Controller::get_theme_option( 'secondary_color' );
    $args = Theme_Controller::getArgsForPagination($paged, $allPostsWPQuery->max_num_pages);
    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
    $arrTitleContainer = array(
        'title' => 'Visa Categories',
        'url' => 'services'
    );
}
?>
<div class="container services-container">
 <?php get_template_part('templates/gtheme','home_title_container', $arrTitleContainer);?>
    <div class="row services-row">
        <?php 
        if ($allPostsWPQuery->have_posts()){
            $intCount = 0;
            while ($allPostsWPQuery->have_posts() ) : $allPostsWPQuery->the_post(); $intCount++;?>
                <div class="col-md-4 text-center">
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
                </div>
            <?php
                echo ($intCount % 3 == 0) ? '</div><div class="row services-row">' : "";
                endwhile;
                wp_reset_postdata(); 
            }?>
    </div>
</div>