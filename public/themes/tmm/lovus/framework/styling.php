<?php 

//Custom Style Frontend
if(!function_exists('lovus_custom_frontend_style')){
    function lovus_custom_frontend_style(){
    	$style_css 	= '';
        $sticky     = '';
        $bg_h       = '';
        $bg_sh      = '';
        $bg_sm      = '';
        $color_sm   = '';
        $color_m    = '';
        $color_sh   = '';

        $cl_pheader = '';
        $bg_pheader = '';
        $h_pheader  = '';

        $logo_mar 	= '';
        $logo_w 	= '';
        $logo_h 	= '';

        $bg_ft      = '';
        $color_ft   = '';
        $bg_bt		= '';
        $color_bt	= '';


        //Header

        if(!lovus_get_option('sticky')){
            $sticky = 'header.smaller{ position: absolute; }';
        }
        if(lovus_get_option('bg_menu')){
        	$bg_h = 'header.transparent{ background: '.lovus_get_option('bg_menu').'; }';
        }
        if(lovus_get_option('color_menu')){
        	$color_m = '#mainmenu a{ color: '.lovus_get_option('color_menu').'; }';
        }
        if(lovus_get_option('bg_sh')){
            $bg_sh = 'header.smaller.scroll-light{ background: '.lovus_get_option('bg_sh').'; }';
        }
        if(lovus_get_option('color_sh')){
            $color_sh = 'header.smaller.scroll-light #mainmenu a{ color: '.lovus_get_option('color_sh').'; }';
        }
        if(lovus_get_option('bg_smenu')){
            $bg_sm = '#mainmenu li li a{ background: '.lovus_get_option('bg_smenu').'; } #mainmenu li li{ border-color: '.lovus_get_option('bg_smenu').'; }';
        }
        if(lovus_get_option('color_smenu')){
            $color_sm = '#mainmenu li li a{ color: '.lovus_get_option('color_smenu').'; }';
        }

        //Logo
        if(lovus_get_option('logo_width')){
            $logo_w = 'header div#logo img { width: '.lovus_get_option('logo_width').'px; }';
        }
        if(lovus_get_option('logo_height')){
            $logo_h = 'header div#logo img { height: '.lovus_get_option('logo_height').'px; }';
        }
        if(lovus_get_option('logo_position')){
            $space = lovus_get_option('logo_position');
            $logo_mar = 'header div#logo h1 { margin: '.$space["top"].' '.$space["right"].' '.$space["bottom"].' '.$space["left"].'; }';
        }
        
        //Page Header
        if(lovus_get_option('page_bg_color')){
            $bg_pheader = '#subheader.dark{ background: '.lovus_get_option('page_bg_color').'; } #subheader .wrap{background: none;}';
        }
        if(lovus_get_option('page_header_color')){
            $h_pheader = '#subheader.dark h2{ color:'.lovus_get_option('page_header_color').'; }';
        }

        //Footer
        
        if(lovus_get_option('bg_footer')){
            $bg_ft = '.topfooter{ background: '.lovus_get_option('bg_footer').'; }';
        }
        if(lovus_get_option('color_footer')){
            $color_ft = 'footer .topfooter h2{ color: '.lovus_get_option('color_footer').'; } ';
        }
        if(lovus_get_option('bg_bottom')){
        	$bg_bt = '.subfooter{ background: '.lovus_get_option('bg_bottom').'; }';
        }
        if(lovus_get_option('color_bottom')){
        	$color_bt = '.subfooter, .subfooter a{ color: '.lovus_get_option('color_bottom').'; } ';
        }


        $style_css .= lovus_get_option('custom_css');
        $style_css .= $sticky;
        $style_css .= $bg_h;
        $style_css .= $color_m;
        $style_css .= $bg_sh;
        $style_css .= $color_sh;
        $style_css .= $bg_sm;
        $style_css .= $color_sm;

        $style_css .= $logo_w;
        $style_css .= $logo_h;
        $style_css .= $logo_mar;

        $style_css .= $bg_ft;
        $style_css .= $color_ft;
        $style_css .= $bg_bt;
        $style_css .= $color_bt;

        $style_css .= $bg_pheader;
        $style_css .= $h_pheader;

        if(! empty($style_css)){
			echo '<style type="text/css">'.$style_css.'</style>';
		}
    }
}
add_action('wp_head', 'lovus_custom_frontend_style');