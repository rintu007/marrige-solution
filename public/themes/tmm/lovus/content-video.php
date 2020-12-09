<?php $link_video = get_post_meta(get_the_ID(),'_cmb_link_video', true); ?>
<div class="col-md-6">
    <div <?php post_class(); ?>>
        <div class="post-content">
            <div class="post-image">            
                <div class="video-post">
                    <iframe width="100%" height="315" src="<?php echo esc_url( $link_video ); ?>"></iframe>
                </div>          
            </div>

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