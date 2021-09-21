<?php 
/**
 * Template For Home Page Title
 */
?>

<div class="flex-title-container">
    <h1><?php echo $args['title']; ?></h1>
    <a href="<?php echo home_url().'/'.$args['url']?>" class="btn-theme btn-theme-transparent btn btn-outline-success btn-lg">View All <?php echo $args['title']; ?> <i class="fas fa-chevron-circle-right"></i></a>
</div>