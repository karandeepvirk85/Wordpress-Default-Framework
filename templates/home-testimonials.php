<?php 
/**
 * This template is for Full Width Home Slider
 */
$arrTestimonials = Theme_Controller::getAllPosts(null,'testimonials', 6);
$strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
?>

<div class="container testimonials-container">
    <div class="title-container">
        <h1>TESTIMONIALS</h1>
        <a style="border: 2px solid <?php echo $strThemeSecondaryColor;?>;color: <?php echo $strThemeSecondaryColor;?>" href="<?php echo home_url();?>/services" class="btn-theme btn btn-outline-success btn-lg">View All Testimonials</a>
    </div>

    <div id="carouselTestimonials" class="carousel-adjust carousel slide" data-ride="carousel">
        <!--Carousel Indicators-->
        <ol class="carousel-indicators">
            <?php 
                $intNumber = 0;
                if($arrTestimonials->have_posts()){
                    while ($arrTestimonials->have_posts()){
                        $arrTestimonials->the_post();?>
                            <li style="background-color:<?php echo $strThemeSecondaryColor;?>" data-target="#carouselTestimonials" data-slide-to="<?php echo $intNumber;?>" class="<?php echo $intNumber == 0 ? "active" : "";?>"></li>
                            <?php $intNumber++; 
                        }
                    wp_reset_postdata(); ?>
                <?php }
            ?>
        </ol>

        <!--Carousel Inners-->
        <div class="carousel-inner">   
            <?php 
                $intNumber = 0;
                if($arrTestimonials->have_posts()){
                    while ($arrTestimonials->have_posts()){
                        $intNumber++;
                        $arrTestimonials->the_post();?>
                        <div class="carousel-item <?php echo $intNumber==1 ? "active" : "";?>">
                            <img src="<?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostImage($post->ID,'large');}?>">
                            <h3><?php the_title();?></h3>
                            <p>
                            <?php
                                if(class_exists('Theme_Controller')){
                                    echo Theme_Controller::getFilteredContent($post->post_content,true,300);
                                }
                            ?>
                            </p>
                            <p class="testi-author">
                                By <?php echo get_post_meta($post->ID,'testimonial_by',true);?>
                            </p>
                        </div>
                            <?php  
                        }
                    wp_reset_postdata(); ?>
                <?php }
            ?>
        </div>

        <!--Next Prev Buttons-->
        <a style="background-color:<?php echo $strThemeSecondaryColor;?>" class="carousel-control-prev" href="#carouselTestimonials" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a style="background-color:<?php echo $strThemeSecondaryColor;?>" class="carousel-control-next" href="#carouselTestimonials" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>