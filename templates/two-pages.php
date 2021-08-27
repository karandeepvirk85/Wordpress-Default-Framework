<?php
 if(class_exists('Theme_Controller')){
    $strThemeSecondaryColor = Theme_Controller::get_theme_option( 'secondary_color' );
    $objHomePage1 = get_post(Theme_Controller::get_theme_option('home_section_page_1'));
    $objHomePage2 = get_post(Theme_Controller::get_theme_option('home_section_page_2'));
}
?>

<div class="container-fluid two-pages-container">
    <div class="title-container">
        <h1 class="text-center">DONT KNOW WHERE TO START?</h1>
    </div>    
    <?php for($i = 1; $i<=2; $i++){
        $intPageId = Theme_Controller::get_theme_option('home_section_page_'.$i); 
        $strButtonTitle = Theme_Controller::get_theme_option('page_button_title_'.$i);
        $objHomePage = get_post(Theme_Controller::get_theme_option('home_section_page_'.$i)); 
        if($i==1){?>
        <div class="row">
            <div class="col-md-6 two-pages-image" data-src="<?php echo get_the_title(get_post_thumbnail_id($objHomePage->ID));?>" 
                style="background-image:url('<?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostImage($objHomePage->ID,'large');}?>')">
            </div>

            <div class="col-md-6 two-pages-content">
                <h2><?php echo $objHomePage->post_title;?></h2>
                <?php 
                    if(class_exists('Theme_Controller')){
                    echo Theme_Controller::getFilteredContent($objHomePage->post_content,true,300);
                }?>
                <a class="btn-page btn btn-secondary btn-lg" href="<?php echo get_the_permalink($intPageId); ?>"><?php echo $strButtonTitle;?></a>
            </div>
        </div>

        <?php } else if ($i==2){?>
        <div class="row">
            <div class="col-md-6 two-pages-content">
                <h2><?php echo $objHomePage->post_title;?></h2>
                <?php 
                    if(class_exists('Theme_Controller')){
                        echo Theme_Controller::getFilteredContent($objHomePage->post_content,true,300);
                    }
                ?>
                <a  class="btn-page btn btn-secondary btn-lg" href="<?php echo get_the_permalink($intPageId); ?>"><?php echo $strButtonTitle;?></a>
            </div>
            <div class="col-md-6 two-pages-image" data-src="<?php echo get_the_title(get_post_thumbnail_id($objHomePage->ID));?>"
                style="background-image:url('<?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostImage($objHomePage->ID,'large');}?>')">
            </div>
        </div>
        <?php }?>
    <?php }?>
</div>