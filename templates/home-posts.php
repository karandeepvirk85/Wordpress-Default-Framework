<?php
 if(class_exists('Theme_Controller')){
    $strThemeSecondaryColor = Theme_Controller::get_theme_option( 'secondary_color' );
    $objHomePost1 = get_post(Theme_Controller::get_theme_option('home_section_blog_1'));
    $objHomePost2 = get_post(Theme_Controller::get_theme_option('home_section_blog_2'));
    $objHomePost3 = get_post(Theme_Controller::get_theme_option('home_section_blog_3'));
    $arrTitleContainer = array(
        'title' => 'Latest Posts',
        'url' => 'blogs'
    );
}
?>
<div class="container home-posts">    
    <?php get_template_part('templates/gtheme','home_title_container',$arrTitleContainer);?>    
    <a href="<?php echo get_permalink($objHomePost1->ID);?>">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading"><?php echo $objHomePost1->post_title;?></h2>
                <p class="lead"><?php echo Theme_Controller::getFilteredContent($objHomePost1->post_content,true,500);?></p>
            </div>
            <div class="col-md-5">
                <img class="featurette-image img-fluid mx-auto"  alt="blog-image"  src="<?php echo Theme_Controller::getPostImage($objHomePost1->ID,'large'); ?>"  data-holder-rendered="true">
            </div>
        </div>
    </a>

    <a href="<?php echo get_permalink($objHomePost2->ID);?>">
        <div class="row featurette">
            <div class="col-md-7 order-md-2">
                <h2 class="featurette-heading"><?php echo $objHomePost2->post_title;?></span></h2>
                <p class="lead"><?php echo Theme_Controller::getFilteredContent($objHomePost2->post_content,true,400);?></p>
                
            </div>
            <div class="col-md-5 order-md-1">
                <img class="featurette-image img-fluid mx-auto"  alt="blog-image" src="<?php echo Theme_Controller::getPostImage($objHomePost2->ID,'large');?>" data-holder-rendered="true">
            </div>
        </div>
    </a>

    <a href="<?php echo get_permalink($objHomePost3->ID);?>">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading"><?php echo $objHomePost3->post_title;?></span></h2>
                <p class="lead"><?php echo Theme_Controller::getFilteredContent($objHomePost3->post_content,true,400);?></p>
            </div>
            <div class="col-md-5">
                <img class="featurette-image img-fluid mx-auto"  alt="blog-image" src="<?php echo Theme_Controller::getPostImage($objHomePost3->ID,'large');?>" data-holder-rendered="true">
            </div>
        </div>
    </a>
</div>