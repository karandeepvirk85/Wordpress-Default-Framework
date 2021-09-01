<div class="container-fluid google-map-container">
    <div class="title-container">
        <h1 class="text-center">Contact US</h1>
    </div>
    <div class="row">
        <div class="col-md-7 google-map-col">
            <?php echo Theme_Controller::get_theme_option('google_map');?>
        </div>
        <div class="col-md-5 contact-form">
            <?php get_template_part('templates/contact-form'); ?>
        </div>
    </div>
</div>
<?php

?>