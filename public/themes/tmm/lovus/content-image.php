<div class="col-md-6">
    <div <?php post_class(); ?>>
        <div class="post-content">
            <div class="post-image">            
                <a href="<?php the_permalink(); ?>">
                <?php if( function_exists( 'rwmb_meta' ) ) { ?>
                    <?php $images = rwmb_meta( '_cmb_image', "type=image" ); ?>
                    <?php if($images){ ?>              
                        <?php  foreach ( $images as $image ) {  ?>
                            <?php $img = $image['full_url']; ?>
                            <img src="<?php echo esc_url($img); ?>" class="img-responsive" alt="">
                        <?php } ?>                
                    <?php } ?>
                <?php } ?>
                </a>           
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