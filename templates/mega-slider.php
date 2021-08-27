<?php 
/**
 * This template is for Full Width Home Slider
 */
$strNumberOfSlides      = Theme_Controller::get_theme_option( 'number_of_slides');
$strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
?>

<div id="carouselIndicators" class="carousel-adjust carousel slide" data-ride="carousel">
    <!--Carousel Indicators-->
    <ol class="carousel-indicators">
        <?php 
            if($strNumberOfSlides > 0){
                for ($i=1; $i<=$strNumberOfSlides; $i++){?>
                        <li data-target="#carouselIndicators" data-slide-to="<?php echo $i-1;?>" class="<?php echo $i-1 == 0 ? "active" : "";?>"></li>
                        <?php 
                    }?>
            <?php }
        ?>
    </ol>

    <!--Carousel Inners-->
    <div class="carousel-inner">   
        <?php
            if($strNumberOfSlides > 0){
                for ($i = 1; $i <= $strNumberOfSlides; $i++){
                    $strImageUrl = Theme_Controller::get_theme_option('slider_image_'.$i);
                    $strCaptionText = trim(Theme_Controller::get_theme_option('slider_caption_'.$i));
                    $strButtonTitle = Theme_Controller::get_theme_option('slider_button_title_'.$i);
                    $strButtonLink = Theme_Controller::get_theme_option('slider_button_link_'.$i);?>
                    <div class="carousel-item <?php echo $i==1 ? "active" : "";?>">
                        <!--Image-->
                        <?php if(!empty($strImageUrl)){?>
                            <img class="d-block w-100" src="<?php echo $strImageUrl;?>" alt="Image Slider">
                        <?php }?>

                        <!--Caption-->
                        <div class="carousel-caption">
                            
                            <!--Caption Text-->
                            <?php 
                                if(!empty($strCaptionText)) {?>
                                    <h5><?php echo $strCaptionText;?></h5>
                                <?php }
                            ?>

                            <!--Caption Button-->
                            <?php 
                                if(!empty($strButtonTitle) && !empty($strButtonLink)){?>
                                    <a style="background-color:<?php echo $strThemeSecondaryColor;?>" class="btn-block btn btn-secondary" href="<?php echo $strButtonLink;?>"><?php echo $strButtonTitle;?></a>
                                <?php }
                            ?>
                        </div>
                    </div>
                <?php }?>
            <?php }
        ?>
    </div>

    <!--Next Prev Buttons-->
    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>