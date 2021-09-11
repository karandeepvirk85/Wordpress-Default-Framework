<div class="container-fluid google-map-container">
    <div class="center-title-container">
        <h1 class="text-center">Contact US</h1>
    </div>
    <div class="row">
        <div class="col-md-8 google-map-col">
            <?php echo Theme_Controller::get_theme_option('google_map');?>
        </div>
        <div class="col-md-4 contact-form">
            <h4>INQUIRY FORM</h4>
            <?php get_template_part('templates/contact-form'); ?>
        </div>
    </div>
</div>
<?php

?>