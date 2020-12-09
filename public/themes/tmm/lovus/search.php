<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package lovus
 */

get_header(); ?>
    

    <?php if(lovus_get_option('page_header')) { ?>
    <?php $img = lovus_get_option( 'page_header_bg' ) ? lovus_get_option( 'page_header_bg' ) : ''; ?>
    <section id="subheader" class="dark no-top no-bottom" data-stellar-background-ratio=".2" <?php if($img) { ?>style="background-image: url(<?php echo esc_url($img); ?>); background-size: cover;"<?php } ?>>
        <div class="wrap">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center fadeScroll relative" data-scroll-speed="2">
                        <h2 data-scroll-speed="8"><?php printf( esc_html__( 'Search Results for: %s', 'lovus' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
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

    <div id="content" class="<?php echo esc_attr( lovus_get_option('blog_layout') ); ?>">
        <div class="container">
            <div class="row">
                <div class="blog-list">
                <?php if( have_posts() ) : ?>
                    <?php 
                        while (have_posts()) : the_post();
                            get_template_part( 'content', get_post_format() ) ;
                        endwhile;
                    ?>
                <?php endif; ?>
                </div>
            </div>
            <div class="text-center">
                <?php echo lovus_pagination(); ?>  
            </div>
        </div>
    </div>   

<?php get_footer(); ?>