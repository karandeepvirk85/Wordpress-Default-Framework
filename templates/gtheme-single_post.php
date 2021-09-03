<?php
/**
 * Single Posts
 */
get_header();
$strPostType = $args['post_type']; 
$strTestimonialsBy = get_post_meta($post->ID,'testimonial_by',true);
?>
<div class="single-post-container">
    <?php if(get_post_thumbnail_id($intPostId)>0) {?>
    <div class="container-fluid single-post-image-container"> 
        <div class="single-post-image <?php echo $strPostType?>" style="background-image:url('<?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostImage($post->ID,'large');}?>')"></div>
    </div>
    <?php }?>
</div>

<div class="container-fluid single-post-content-container">
    <div class="row">
        <div class="col-md-9 left-bar">
            <div class="post-top-container">
                <h1>
                    <?php echo $post->post_title;?>
                </h1>
                <div class="post-date-container">
                    <i class="fas fa-calendar-day"></i>
                    <?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostDate($post->post_date);}?>
                </div>
            </div>
            <hr/>
            <div class="single-post-content">
                <?php echo apply_filters('the_content',$post->post_content);?>
                <?php if(!empty($strTestimonialsBy)){?>
                    <h5 class="testimonial-by"> Testimonial By <?php echo $strTestimonialsBy;?><h5>
                <?php }?>
            </div>
        </div>
        <?php if($strPostType == 'post'){?>
            <div class="col-md-3 sidbar-container">    
                <?php  get_template_part('templates/blog-sidebar');?>
            </div>
        <?php } else{ ?>
            <div class="col-md-3 single-post-side-bar">
                <h3>All <?php echo ucwords($strPostType); ?></h3>
                <?php
                    $allPostsSideBar  = Theme_Controller::getAllPosts($paged, $strPostType ,-1);
                    if($allPostsSideBar->have_posts()){
                        while ($allPostsSideBar->have_posts() ) : $allPostsSideBar->the_post();?>
                        <p>
                            <a href="<?php echo get_permalink($post->ID);?>"><?php echo $post->post_title;?></a>
                        </p>
                    <?php endwhile;
                        wp_reset_postdata(); 
                    }
                ?>
            </div>
        <?php } ?>
    </div>
</div>
<?php get_footer();?>
