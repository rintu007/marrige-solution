<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package lovus
 */

wp_head(); ?>
  <div class="wrapper">
    <section class="no-padding bg-error full-height">
      <div class="container">
        <div class="warp-404 center-y">
          <div class="warp-404-inner">
            <h3 class="id-color"><?php esc_html_e('404','lovus'); ?></h3>
            <h2><?php esc_html_e('Page Not Found','lovus'); ?></h2>
            <span><?php esc_html_e('The page you have requested cannot be found.','lovus'); ?></span>
            <p><?php wp_kses( _e('Maybe the page was moved or deleted, or perhaps you just mistyped the address.<br> Why not to try and find your way using the navigation bar above or click on the logo to return to our  home page.','lovus'), wp_kses_allowed_html('post') ); ?></p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-custom">Back To Home</a>
          </div>
        </div>
      </div>
    </section>
  </div>
	
<?php wp_footer(); ?>
