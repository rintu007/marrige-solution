<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lovus
 */
?>
    
    <footer>
        <?php if(lovus_get_option( 'tfooter' )) { ?>
        <div class="topfooter">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-12">
                        <?php if(lovus_get_option( 'logo_footer' )) { ?>
                        <img src="<?php echo esc_url(lovus_get_option( 'logo_footer' )); ?>" alt="">
                        <?php }else{ ?>
                        <h2 class="hs1"><?php echo htmlspecialchars_decode(lovus_get_option( 'text_footer' )); ?></h2>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php }if(lovus_get_option( 'bfooter' ) && lovus_get_option( 'copy_right' )) { ?>
        <div class="subfooter">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo htmlspecialchars_decode(lovus_get_option( 'copy_right' )); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </footer>
    <!-- footer close -->

    <a href="#" id="back-to-top"></a>
    <div id="preloader">
        <div class="preloader1"></div>
    </div>

    <?php if(lovus_get_option( 'rsvp' )) { ?>
    <div id="popup-box" class="full-height">
        <span class="btn-close">
            <i class="icon_close"></i>
        </span>

        <div class="container center-y">
            <div class="row">

                <?php echo do_shortcode('[contact-form-7 title="'.lovus_get_option( 'rsvp' ).'"]'); ?>

                <div class="spacer-single"></div>
            </div>
        </div>
    </div>
    <?php } ?>

</div>

<?php wp_footer(); ?>

</body>
</html>
