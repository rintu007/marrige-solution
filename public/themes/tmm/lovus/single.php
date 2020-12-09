<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package lovus
 */
get_header(); ?>

<?php if(lovus_get_option('page_header')) { ?>
<?php 
    $img = lovus_get_option( 'page_header_bg' ) ? lovus_get_option( 'page_header_bg' ) : ''; 
    $title   = lovus_get_option('title_single') ? lovus_get_option('title_single') : esc_html__('Single Blog', 'lovus');
?>
    <?php $img = lovus_get_option( 'page_header_bg' ) ? lovus_get_option( 'page_header_bg' ) : ''; ?>
    <section id="subheader" class="dark no-top no-bottom" data-stellar-background-ratio=".2" <?php if($img) { ?>style="background-image: url(<?php echo esc_url($img); ?>); background-size: cover;"<?php } ?>>
        <div class="wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center fadeScroll relative" data-scroll-speed="2">
                        <h2 data-scroll-speed="8"><?php echo esc_html($title); ?></h2>
                        <?php if(lovus_get_option( 'sub_title' )) { ?>
                            <?php if(lovus_get_option( 'ph_layout' ) == 'style1') { ?>
                            <div class="wm" data-scroll-speed="3"><?php echo esc_html(lovus_get_option( 'sub_title' )); ?></div>
                            <?php }else{ ?>
                            <div class="small-border"></div>
                            <?php } ?>
                        <?php } ?>
                        <div class="spacer-double"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<?php while (have_posts()): the_post(); ?>

<div id="content" class="<?php echo esc_attr( lovus_get_option('post_layout') ); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-list blog-single">
                    <div class="single-post">
                        <?php                                                     
                            $format = get_post_format();
                            $link_video = get_post_meta(get_the_ID(),'_cmb_link_video', true);
                            $link_audio = get_post_meta(get_the_ID(),'_cmb_link_audio', true);
                        ?>
                        <div class="post-content">
                            <?php if($format == 'video') {  ?>
                                <div class="post-image">
                                    <div class="video-post">
                                        <iframe width="100%" height="315" src="<?php echo esc_url( $link_video ); ?>"></iframe>
                                    </div>
                                </div>
                            <?php }elseif($format == 'audio') { ?>
                                <div class="post-image">
                                    <iframe style="width:100%" height="150" scrolling="no" frameborder="no" src="<?php echo esc_url( $link_audio ); ?>"></iframe>
                                </div>
                            <?php }elseif($format == 'gallery') { ?>
                                <div class="post-image">
                                    <div class="owl-carousel owl-theme blog-slide">
                                    <?php if( function_exists( 'rwmb_meta' ) ) { ?>
                                        <?php $images = rwmb_meta( '_cmb_images', "type=image" ); ?>
                                        <?php if($images){ ?>              
                                            <?php  foreach ( $images as $image ) {  ?>
                                                <?php $img = $image['full_url']; ?>
                                                <div class="item"><img src="<?php echo esc_url($img); ?>" alt=""></div>
                                            <?php } ?>                

                                        <?php } ?>
                                    <?php } ?>
                                    </div>
                                </div>
                            <?php }elseif($format == 'image') { ?>
                                <div class="post-image">
                                    <?php if( function_exists( 'rwmb_meta' ) ) { ?>
                                        <?php $images = rwmb_meta( '_cmb_image', "type=image" ); ?>
                                        <?php if($images){ ?>              
                                            <?php  foreach ( $images as $image ) {  ?>
                                                <?php $img = $image['full_url']; ?>
                                                <img src="<?php echo esc_url($img); ?>" class="img-responsive" alt="">
                                            <?php } ?>                
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php }elseif( has_post_thumbnail() ) { ?>
                            <div class="post-image">            
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" alt="">
                                </a>            
                            </div>
                            <?php } ?>

                            <div class="date-box">
                                <div class="day"><?php the_time('d'); ?></div>
                                <div class="month"><?php the_time('M'); ?></div>
                            </div>

                            <div class="post-text">
                                <h3><?php the_title(); ?></h3>
                                <?php the_content(); ?>
                                <?php if(has_tag()) { ?>
                                    <div class="list-tag"><strong><?php echo esc_html__("Tags: ","lovus"); ?></strong> <?php the_tags('', ', ' ); ?></div>
                                <?php } ?>
                                <?php
                                    wp_link_pages( array(
                                        'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'lovus' ) . '</span>',
                                        'after'       => '</div>',
                                        'link_before' => '<span>',
                                        'link_after'  => '</span>',
                                        'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'lovus' ) . ' </span>%',
                                        'separator'   => '<span class="screen-reader-text">, </span>',
                                    ) );
                                ?>
                            </div>

                        </div>
                    </div>
                    
                </div>

                <div class="comment-area">
                <?php
                   if ( comments_open() || get_comments_number() ) :
                    comments_template();
                   endif;
                ?>
                </div>

            </div>

            <div class="col-md-4">
                <div class="sidebar">
                    <?php get_sidebar();?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>