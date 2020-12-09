<div class="col-md-6">
    <div <?php post_class(); ?>>
        <div class="post-content">
            <?php if ( has_post_thumbnail() ) { ?>
            <div class="post-image">            
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" alt="">
                </a>            
            </div>
            <?php } ?>

            <div class="post-wrapper">
                <div class="date-box">
                    <div class="day"><?php the_time('d'); ?></div>
                    <div class="month"><?php the_time('M'); ?></div>
                </div>

                <div class="post-text">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p><?php echo lovus_excerpt_length(); ?></p>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>