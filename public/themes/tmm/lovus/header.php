<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lovus
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?> >
    <div class="wrapper">
        
        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- logo begin -->
                        <div id="logo">
                            <h1>
                                <?php $logo = lovus_get_option( 'logo' ) ? lovus_get_option( 'logo' ) : lovus_get_option( 'logo_text' ); 
                                      $logo2 = lovus_get_option( 'logo2' );
                                if(lovus_get_option( 'logo' )) { ?>
                                <a href="<?php echo esc_url( home_url('/') ); ?>"><img class="logo" src="<?php echo esc_url($logo); ?>" alt=""></a>
                                <a href="<?php echo esc_url( home_url('/') ); ?>"><img class="logo-2" src="<?php echo esc_url($logo2); ?>" alt=""></a>
                                <?php }else{ ?>
                                <a href="<?php echo esc_url( home_url('/') ); ?>"><?php echo htmlspecialchars_decode($logo); ?></a>
                                <?php } ?>
                            </h1>
                        </div>
                        <span id="menu-btn" class="<?php if(lovus_get_option( 'btn_menu' )) echo 'btn-margin'; ?>"></span>

                        <?php if(lovus_get_option( 'btn_menu' )) { ?>
                        <span class="btn-rsvp"><?php echo htmlspecialchars_decode(lovus_get_option( 'btn_menu' )); ?></span>
                        <?php } ?>

                        <nav>
                            <?php
                                $primary = array(
                                    'theme_location'  => 'primary',
                                    'menu'            => '',
                                    'container'       => '',
                                    'container_class' => '',
                                    'container_id'    => '',
                                    'menu_class'      => '',
                                    'menu_id'         => '',
                                    'echo'            => true,
                                    'before'          => '',
                                    'after'           => '',
                                    'link_before'     => '',
                                    'link_after'      => '',
                                    'items_wrap'      => '<ul id="mainmenu">%3$s</ul>',
                                    'depth'           => 0,
                                );
                                if ( has_nav_menu( 'primary' ) ) {
                                    wp_nav_menu( $primary );
                                }
                            ?>
                        </nav>

                    </div>
                    <!-- mainmenu close -->

                </div>
            </div>
        </header>