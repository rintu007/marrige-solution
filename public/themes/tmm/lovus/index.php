<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package lovus
 */

get_header(); ?>

<?php
    $bg = '';
    if ( ! function_exists('rwmb_meta') ) { 
        $subtext = '';
        $full    = null;
        $bg      = '';
    }else{
        $subtext = rwmb_meta('_cmb_subtext', "type=text", get_option( 'page_for_posts' ));
        $full    = rwmb_meta('_cmb_fheight', "type=checkbox", get_option( 'page_for_posts' ));
        $images  = rwmb_meta('_cmb_bg_header', "type=image", get_option( 'page_for_posts' )); 
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
    $stext = $subtext ? $subtext : lovus_get_option( 'sub_title' );
?>
<section id="subheader" class="dark no-top no-bottom <?php if($full) echo "full-height"; ?>" data-stellar-background-ratio=".2" <?php if($img_src) { ?>style="background-image: url(<?php echo esc_url($img_src); ?>); background-size: cover;"<?php } ?>>
    <div class=" <?php if($full) echo 'center-y fadeScroll relative'; else echo 'wrap';?>">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center fadeScroll relative" data-scroll-speed="2">
                    <h2 data-scroll-speed="8"><?php if( is_home() && is_front_page() ) echo esc_html__( 'Journal', 'lovus' ); else echo get_the_title( get_option( 'page_for_posts' ) ); ?></h2>
                    <?php if(lovus_get_option( 'ph_layout' ) == 'style1' && $stext) { ?>
                    <div class="wm" data-scroll-speed="3"><?php echo esc_html($stext); ?></div>
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