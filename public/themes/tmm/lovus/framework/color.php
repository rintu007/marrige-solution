<?php 

//Custom Style Frontend
if(!function_exists('lovus_color_scheme')){
    function lovus_color_scheme(){
        $main_color = '';

        //Main Color
        if(lovus_get_option('main_color')){
            $main_color = 
            '
			.bg-color,
			section.bg-color,
			section.call-to-action,
			#mainmenu li li a:hover,
			#mainmenu ul li:hover > a,
			.price-row,
			.slider-info .text1,
			.btn-primary,
			.bg-id-color,
			.pagination > .active > a,
			.pagination > li > span,
			.pagination > .active > a:hover,
			.pagination > li > span:hover,
			.pagination > .active > a:focus,
			.pagination > .active > span:focus,
			.dropcap,
			.fullwidthbanner-container a.btn,
			.feature-box-big-icon i,
			#testimonial-full,
			.icon-deco i,
			.feature-box-small-icon .border,
			.small-border,
			#jpreBar,
			.date-post,
			.team-list .small-border,
			.de-team-list .small-border,
			.btn-line:hover,a.btn-line:hover,
			.btn-line.hover,a.btn-line.hover,
			.owl-arrow span,
			.de-progress .progress-bar,
			#btn-close-x:hover,
			.box-fx .info,
			.de_testi blockquote:before,
			.btn-more,
			.widget .small-border,
			.product img:hover,
			#btn-search,
			.de_tab.timeline li.active .dot,
			.btn-id,
			.tiny-border,
			#back-to-top,
			#subheader .small-border-deco span,
			#services-list li a:hover,
			.timeline .tl-block .tl-line,
			.de_tab.tab_style_2 .de_nav li.active span,
			.de_tab.tab_steps.style-2 .de_nav li.active span,
			.feature-box-small-icon.style-2 .number.bg-color,
			a.btn-custom,.btn-custom,
			span.overlay,
			.owl-custom-nav .btn-next:before,
			.owl-custom-nav .btn-prev:before,
			.timeline > li > .timeline-badge,
			.de_light  .de_tab.tab_style_3 .de_nav li.active span,
			.circle,
			.social-icons-sm i:hover,
			.btn-rsvp,
			.btn-close,
			.pricing-s1 .ribbon,
			.social-icons-sm i:hover,
			.overlay-v i:before,
			.wpb-js-composer div.vc_tta-color-grey.vc_tta-style-classic.vc_tta-tabs-position-top .vc_tta-tab.vc_active>a
			{
				background-color:'.lovus_get_option('main_color').' ;
			}

			.feature-box i,
			#mainmenu li:hover > ul,
			#mainmenu li:hover > a,
			.date-box .day,
			.slider_text h1,
			.id-color,
			h1.id-color,h2.id-color,h3.id-color,h4.id-color,
			.pricing-box li h1,
			.title span,
			i.large:hover,
			.feature-box-small-icon-2 i,
			address span i,
			.pricing-dark .pricing-box li.price-row,
			.ratings i,
			#mainmenu a:hover,
			#mainmenu a.active,
			header.smaller #mainmenu a.active,
			.pricing-dark .pricing-box li.price-row,
			.dark .feature-box-small-icon i,
			a.btn-slider:after,
			.box-icon-simple i,
			a.btn-line:after,
			.team-list .social a,
			.de_contact_info i,
			.dark .btn-line:hover:after, .dark a.btn-line:hover:after, .dark a.btn-line.hover:after,
			a.btn-text:after,
			.separator span  i,
			address span strong,
			.de_tab.tab_steps .de_nav li span:hover,
			.de_testi_by,
			.widget_tags li a,
			.dark .btn-line:after, .dark  a.btn-line:after,
			.crumb a,
			.btn-right:after,
			.btn-left:before,
			#mainmenu li a:after,
			header .info .social i:hover,
			#back-to-top:hover:before,
			#services-list li.active,
			#services-list li.active a:after,
			.testimonial-list:before,
			#filters a.selected,
			span.deco-big, h2.name b,
			h2.hs1 span, h2.id-color strong,
			.wm,.wm2,
			.blog-list .date-box .day,
			.countdown-period,
			.pricing-s1 .top .price .currency,
			header div#logo h1 span,
			#menu-btn
			{
				color:'.lovus_get_option('main_color').'
			}

			.feature-box i,
			.pagination > .active > a,
			.pagination > li > span,
			.pagination > .active > a:hover,
			.pagination > li > span:hover,
			.pagination > .active > a:focus,
			.pagination > .active > span:focus
			.feature-box-big-icon i:after,
			.btn-line:hover,a.btn-line:hover,
			.btn-line.hover,a.btn-line.hover,
			.product img:hover,
			#contact_form input[type=text]:focus,#contact_form input[type=tel]:focus,#contact_form input[type=email]:focus,#contact_form textarea:focus, #search:focus,
			#contact_form .de_light input[type=text]:focus, #contact_form .de_lighttextarea:focus, #contact_form .de_light #search:focus,
			.form-transparent input[type=text]:focus, .form-transparent textarea:focus, .form-transparent input[type=email]:focus,
			.de_tab.tab_steps.style-2 .de_nav li.active span,
			#filters a.selected,
			.box-border
			{

				border-color:'.lovus_get_option('main_color').' ;
			}

			.box-fx .inner,
			.dark .box-fx .inner,
			.blog-list img,
			.arrow-up,
			.de_light  .de_tab.tab_style_2 .de_nav li.active span,
			.timeline > li > .timeline-panel,
			.separator span:before,
			.separator span:after,
			.de_light .separator span:before,
			.de_light .separator span:after,
			.text-light .separator span:before,
			.text-light .separator span:after ,
			.form-underline input[type=text]:focus, .form-underline textarea:focus, .form-underline input[type=email]:focus, .form-underline select:focus
			{
				border-bottom-color:'.lovus_get_option('main_color').' ;
			}

			.arrow-down,
			.preloader1{
				border-top-color:'.lovus_get_option('main_color').' ;
			}

			.callbacks_nav {
				background-color:'.lovus_get_option('main_color').' ;
			}


			.de_tab .de_nav li span {
			border-top: 3px solid '.lovus_get_option('main_color').' ;
			}

			.feature-box-big-icon i:after {
			border-color: '.lovus_get_option('main_color').'  transparent;
			}

			.de_review li.active img{
				border:solid 4px '.lovus_get_option('main_color').' ;
			}


			blockquote{
			border-left-color:'.lovus_get_option('main_color').';
			}
			';
        }

        if(! empty($main_color)){
			echo '<style type="text/css">'.$main_color.'</style>';
		}
    }
}
add_action('wp_head', 'lovus_color_scheme');