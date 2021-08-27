<?php
/**
 * Template for 404
 */
get_header();
?>
<div class="container page-container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>SORRY THIS PAGE DOES NOT EXIST</h1>
            <img alt="Photo by Romson Preechawit on Unsplash" class="img-fluid" src="<?php echo get_template_directory_uri()?>/images/404.jpg">
        </div>
    </div>
</div>
<?php 
    get_footer();
?>