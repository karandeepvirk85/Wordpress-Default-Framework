<?php 
/**
 * Posts Columns
 */
?>
<div class="posts-column" data-link="<?php echo get_permalink($post->ID); ?>">
    <div class="post-container">
        <div class="post-top-container">
            <div class="post-image" style="background-image:url('<?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostImage($post->ID,'large');}?>')"></div>
        </div>
        <div class="post-bottom-container">
            <div class="post-meta-container">
                <div class="post-author">
                    <?php echo ucwords(get_user_meta($post->post_author)['nickname'][0]); ?>
                </div>
                <div class="divider">
                    |
                </div>
                <div class="post-date">
                    <?php if(class_exists('Theme_Controller')){echo Theme_Controller::getPostDate($post->post_date);}?>
                </div>
            </div>
            <div class="post-title-container">
                <a href="<?php echo get_permalink($post->ID); ?>"> <?php the_title(); ?></a>
            </div>
            <div class="post-content-container">
                <?php 
                    if(is_single()){
                        echo $post->post_content;
                    }else{
                        if(class_exists('Theme_Controller')){
                            echo Theme_Controller::getFilteredContent($post->post_content,true,200);
                        }
                    }
                ?>
            </div>
            <?php if(!is_single()){?>
                <div class="read-more-container">
                    <a class="read-more-link" href="<?php the_permalink()?>">Read More..</a>
                </div>
            <?php }?>
        </div>
    </div>
</div>