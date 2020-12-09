<?php
/**
 * Template Name: FullWidth
 */
get_header(); ?>

<?php
    $bg = '';
    if ( ! function_exists('rwmb_meta') ) { 
        $subtext = '';
        $full = null;
        $bg = '';
    }else{
        $subtext = rwmb_meta('_cmb_subtext', "type=text" );
        $full = rwmb_meta('_cmb_fheight', "type=checkbox" );
        $images = rwmb_meta('_cmb_bg_header', "type=image" ); 
        if(!$images){
             $bg = '';
        } else {
             foreach ( $images as $image ) { 
                $bg = $image['full_url']; 
                break;
            }
        }
    }
   
?>

<?php if(lovus_get_option('page_header')) { ?>
<?php 
    $img = lovus_get_option( 'page_header_bg' ) ? lovus_get_option( 'page_header_bg' ) : ''; 
    $img_src = $bg ? $bg : $img;
?>
<section id="subheader" class="dark no-top no-bottom <?php if($full) echo "full-height"; ?>" data-stellar-background-ratio=".2" <?php if($img_src) { ?>style="background-image: url(<?php echo esc_url($img_src); ?>); background-size: cover;"<?php } ?>>
    <div class=" <?php if($full) echo 'center-y fadeScroll relative'; else echo 'wrap';?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center fadeScroll relative" data-scroll-speed="2">
                    <h2 data-scroll-speed="8"><?php the_title(); ?></h2>
                    <?php if(lovus_get_option( 'ph_layout' ) == 'style1' && $subtext) { ?>
                    <div class="wm" data-scroll-speed="3"><?php echo esc_html($subtext); ?></div>
                    <?php }else{ ?>
                    <div class="small-border"></div>
                    <?php } ?>
                    <div class="spacer-double"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
    
<?php while (have_posts()) : the_post(); ?>

    <?php the_content(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>