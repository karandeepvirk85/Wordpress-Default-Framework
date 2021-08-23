<?php
 if(class_exists('Theme_Controller')){
    // Get Paged Query
    $paged = Theme_Controller::getPagedQuery();
    // Get Posts Query
    $allPostsWPQuery = Theme_Controller::getAllPosts($paged,'services',6);

    $strSecondary = Theme_Controller::get_theme_option( 'secondary_color' );
    // Set Args for Pagination
    $args = Theme_Controller::getArgsForPagination($paged, $allPostsWPQuery->max_num_pages);

    $strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
}
?>
<div class="container services-container">
    <div class="title-container">
        <h1>VISA CATEGORIES</h1>
        <a style="border: 2px solid <?php echo $strThemeSecondaryColor;?>;color: <?php echo $strThemeSecondaryColor;?>" href="<?php echo home_url();?>/services" class="btn-theme btn btn-outline-success btn-lg">View All Categories</a>
    </div>
    <div class="row services-row">
        <?php 
        if ($allPostsWPQuery->have_posts()){
            $intCount = 0;
            while ($allPostsWPQuery->have_posts() ) : $allPostsWPQuery->the_post(); $intCount++;?>
                <div class="col-md-4 text-center">
                    <div class="services-col">
                        <?php echo get_post_meta($post->ID,'services_icon',true);?>
                        <h2><?php the_title();?></h2>
                        <?php 
                            if(class_exists('Theme_Controller')){
                                echo Theme_Controller::getFilteredContent($post->post_content,true,250);
                            }
                        ?>
                        <p><a class="btn btn-secondary" href="#" role="button">View details</a></p>
                    </div>
                </div>
            <?php
                echo ($intCount % 3 == 0) ? '</div><div class="row services-row">' : "";
                endwhile;
                wp_reset_postdata(); 
            } else { ?>
            <div class="col-md-12">
                <p><?php _e( 'There no posts to display.' ); ?></p>
            </div>
        <?php } ?>
    </div>
</div>