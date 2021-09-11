<?php 
/**
 * Template For Home Page Title
 */

$strThemeSecondaryColor = Theme_Controller::get_theme_option('secondary_color');
?>

<div class="flex-title-container">
    <h1><?php echo $args['title']; ?></h1>
    <a style="border: 2px solid <?php echo $strThemeSecondaryColor;?>;color: <?php echo $strThemeSecondaryColor;?>" href="<?php echo home_url().'/'.$args['url']?>" class="btn-theme btn-theme-transparent btn btn-outline-success btn-lg">View All <?php echo $args['title']; ?> <i class="fas fa-chevron-circle-right"></i></a>
</div>