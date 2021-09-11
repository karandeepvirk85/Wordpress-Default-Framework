<div class="container-fluid page-container padding-0">
    <?php 
    if(have_posts()) :
        while (have_posts()) : 
            the_post();
            $intPostImageId = 0;
            $intPostImageId = (int) get_post_thumbnail_id($post->ID);

            if($intPostImageId >0){?>
                <div data-src="<?php echo get_the_title($intPostImageId);?>" class="img-fluid single-page-image" style="background-image:url('<?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostImage($post->ID,'large');}?>')"></div>
            <?php } else{?>
                <p class="spacer"></p>
            <?php }?>

            <div class="container page-content">
                <h1><?php the_title();?></h1>
                <?php the_content();?>
            </div>
            <?php
        endwhile;
    endif;
    ?>