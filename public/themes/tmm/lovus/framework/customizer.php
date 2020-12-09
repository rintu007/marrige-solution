<?php
/**
 * Lovus theme customizer
 *
 * @package Lovus
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Lovus_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		if ( ! isset( $this->config['fields'][$name] ) ) {
			return false;
		}

		$default = isset( $this->config['fields'][$name]['default'] ) ? $this->config['fields'][$name]['default'] : false;

		return get_theme_mod( $name, $default );
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function lovus_get_option( $name ) {
	global $lovus_customize;

	if ( empty( $lovus_customize ) ) {
		return false;
	}

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( $lovus_customize->get_theme(), $name );
	} else {
		$value = $lovus_customize->get_option( $name );
	}

	return apply_filters( 'lovus_get_option', $value, $name );
}

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function lovus_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'lovus_customize_modify' );

/**
 * Customizer configuration
 */
$lovus_customize = new Lovus_Customize(
	array(
		'theme'    => 'lovus',

		'panels'   => array(
			'general' => array(
				'priority' => 10,
				'title'    => esc_html__( 'General', 'lovus' ),
			),
			'header'  => array(
				'priority' => 11,
				'title'    => esc_html__( 'Header', 'lovus' ),
			),
			'socials'  => array(
				'priority' => 210,
				'title'    => esc_html__( 'Socials', 'lovus' ),
			),
		),

		'sections' => array(

			// Panel Header
			'top_header'      => array(
				'title'       => esc_html__( 'Top Header', 'lovus' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'header'      => array(
				'title'       => esc_html__( 'Navigation', 'lovus' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'logo'        => array(
				'title'       => esc_html__( 'Site Logo', 'lovus' ),
				'description' => '',
				'priority'    => 50,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'page_header' => array(
				'title'       => esc_html__( 'Page Header', 'lovus' ),
				'description' => '',
				'priority'    => 15,
				'capability'  => 'edit_theme_options',
			),

			// Panel Socials
			'socials'      => array(
				'title'       => esc_html__( 'Socials', 'lovus' ),
				'description' => '',
				'priority'    => 220,
				'capability'  => 'edit_theme_options',
			),

			
			// Panel Content
			'content'     => array(
				'title'       => esc_html__( 'Blog', 'lovus' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),

			// Panel Projects
			'project'     => array(
				'title'       => esc_html__( 'Portfolio', 'lovus' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),

			// Panel Shop
			'shop'     => array(
				'title'       => esc_html__( 'Shop', 'lovus' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),

			// Panel Footer
			'footer'     => array(
				'title'       => esc_html__( 'Footer', 'lovus' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),


			// Coming Soon
			'csoon'     => array(
				'title'       => esc_html__( 'Coming Soon', 'lovus' ),
				'description' => '',
				'priority'    => 245,
				'capability'  => 'edit_theme_options',
			),


			// Panel Styling
			'styling'     => array(
				'title'       => esc_html__( 'Miscellaneous', 'lovus' ),
				'description' => '',
				'priority'    => 250,
				'capability'  => 'edit_theme_options',
			),
		),

		'fields'   => array(

			//Header

			'sticky'     => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Sticky Header', 'lovus' ),
				'section'  => 'header',
				'default'  => '1',
				'priority' => 10,
			),
			'bg_menu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Main Menu', 'lovus' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			'color_menu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Menu', 'lovus' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			'bg_sh'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Scroll Menu', 'lovus' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			'color_sh'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Scroll Menu', 'lovus' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),			
			'bg_smenu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Dropdown Menu', 'lovus' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			'color_smenu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Dropdown Menu', 'lovus' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			'btn_menu'    => array(
				'type'     => 'text',
				'label'    => esc_html__( 'RSVP Button', 'lovus' ),
				'section'  => 'header',
				'default'  => 'RSVP',
				'priority' => 10,
			),
			'rsvp'      => array(
				'type'     => 'text',
				'label'    => esc_html__( 'RSVP Form Title', 'lovus' ),
				'description' => esc_html__( 'Make and get title in Contact Form 7 (Admin bar > Contact)', 'lovus' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),

			// Logo
			'logo_text'    => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Logo Text', 'lovus' ),
				'section'  => 'logo',
				'default'  => 'Laurie<span>&amp;</span>Briant',
				'priority' => 10,
			),
			'logo_color'   => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Logo', 'lovus' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
				'output' => array(
					array(
						'element'  => 'header div#logo a',
						'property' => 'color',
						'units'    => '',
					)
				),
			),
			'logo_scolor'  => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Scroll Logo', 'lovus' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
				'output' => array(
					array(
						'element'  => 'header.smaller.scroll-light div#logo a',
						'property' => 'color',
						'units'    => '',
					)
				),
			),

			'logo'         => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Logo Image', 'lovus' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo2'        => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Scroll Logo Image', 'lovus' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_width'     => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Logo Width', 'lovus' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_height'    => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Logo Height', 'lovus' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_position'  => array(
				'type'     => 'spacing',
				'label'    => esc_html__( 'Logo Margin', 'lovus' ),
				'section'  => 'logo',
				'priority' => 10,
				'default'  => array(
					'top'    => '16px',
					'bottom' => '',
					'left'   => '0',
					'right'  => '0',
				),
			),

			// Page Header
			'page_header'    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'lovus' ),
				'description' => esc_html__( 'Enable to show page header on whole site', 'lovus' ),
				'section'     => 'page_header',
				'default'     => '1',
				'priority'    => 10,
			),
			'ph_layout'  => array(
				'type'     => 'select',
				'label'    => esc_html__( 'Page Title Style', 'lovus' ),
				'section'  => 'page_header',
				'default'  => 'style1',
				'priority' => 10,
				'choices'  => array(
					'style1' 	=> esc_html__( 'Style 1', 'lovus' ),
					'style2' 	=> esc_html__( 'Style 2', 'lovus' ),
				),
				'active_callback' => array(
				 	array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'page_header_bg' => array(
				'type'        => 'image',
				'label'       => esc_html__( 'Background Image', 'lovus' ),
				'description' => esc_html__( 'Upload a page header background image', 'lovus' ),
				'section'     => 'page_header',
				'default'     => '',
				'priority'    => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'page_bg_color'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Color', 'lovus' ),
				'section'  => 'page_header',
				'default'  => '',
				'priority' => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'page_header_color'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Page Title', 'lovus' ),
				'section'  => 'page_header',
				'default'  => '#fff',
				'priority' => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'sub_title'    => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Sub Text', 'lovus' ),
				'section'  => 'page_header',
				'default'  => 'Our',
				'priority' => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				 	array(
					  	'setting'  => 'ph_layout',
					  	'operator' => '==',
					  	'value'    => 'style1',
				 	),
				),
			),

			// Content
			'blog_layout'  => array(
				'type'     => 'radio-image',
				'label'    => esc_html__( 'Blog List Layout', 'lovus' ),
				'section'  => 'content',
				'default'  => 'default',
				'priority' => 10,
				'choices'  => array(
					'default' 	=> get_template_directory_uri() . '/framework/admin/images/right.png',
					'left-bar' 	=> get_template_directory_uri() . '/framework/admin/images/left.png',
					'no-bar' 	=> get_template_directory_uri() . '/framework/admin/images/full.png',
				),
			),
			'post_layout'  => array(
				'type'     => 'radio-image',
				'label'    => esc_html__( 'Single Blog Layout', 'lovus' ),
				'section'  => 'content',
				'default'  => 'default',
				'priority' => 10,
				'choices'  => array(
					'default' 	=> get_template_directory_uri() . '/framework/admin/images/right.png',
					'left-bar' 	=> get_template_directory_uri() . '/framework/admin/images/left.png',
					'no-bar' 	=> get_template_directory_uri() . '/framework/admin/images/full.png',
				),
			),
			'title_single' => array(
				'type'    		=> 'text',
				'label'   		=> esc_html__( 'Title Header Single', 'lovus' ),
				'section' 		=> 'content',
				'default' 		=> '',
				'priority'    	=> 12,
			),
			'read_more' => array(
				'type'    		=> 'text',
				'label'   		=> esc_html__( 'Read More Button', 'lovus' ),
				'section' 		=> 'content',
				'default' 		=> '',
				'priority'    	=> 12,
			),
			'excerpt_length' => array(
				'type'    => 'number',
				'label'   => esc_html__( 'Excerpt Length', 'lovus' ),
				'section' => 'content',
				'default' => 27,
				'choices' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			),

			//Footer
			'tfooter'     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Footer Top', 'lovus' ),
				'section'     => 'footer',
				'default'     => '1',
				'priority'    => 10,
			),
			'logo_footer'  => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Logo Footer', 'lovus' ),
				'section'  => 'footer',
				'default'  => '',
				'priority' => 10,
			),
			'text_footer'     => array(
				'type'        => 'text',
				'label'       => esc_html__( 'Footer Text', 'lovus' ),
				'section'     => 'footer',
				'default'     => '',
				'priority'    => 10,
				'active_callback' => array(
					array(
					  	'setting'  => 'w_footer',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'bg_footer'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Color Top Footer', 'lovus' ),
				'section'  => 'footer',
				'default'  => '',
				'priority' => 10,
				'active_callback' => array(
					array(
					  	'setting'  => 'w_footer',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'color_footer'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Top Footer', 'lovus' ),
				'section'  => 'footer',
				'default'  => '',
				'priority' => 10,
				'active_callback' => array(
					array(
					  	'setting'  => 'w_footer',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),

			'bfooter'     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Footer Bottom', 'lovus' ),
				'section'     => 'footer',
				'default'     => '1',
				'priority'    => 10,
			),
			'bg_bottom'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Bottom Footer', 'lovus' ),
				'section'  => 'footer',
				'default'  => '',
				'priority' => 10,
				'active_callback' => array(
					array(
					  	'setting'  => 'bfooter',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'color_bottom' => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Footer', 'lovus' ),
				'section'  => 'footer',
				'default'  => '',
				'priority' => 10,
				'active_callback' => array(
					array(
					  	'setting'  => 'bfooter',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'copy_right'      => array(
				'type'        => 'code',
				'label'       => esc_html__( 'Copy Right Text', 'lovus' ),
				'section'     => 'footer',
				'default'     => '',
				'priority'    => 10,
				'active_callback' => array(
					array(
					  	'setting'  => 'bfooter',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),

			//Styling
			'preload'     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Preloader', 'lovus' ),
				'section'     => 'styling',
				'default'     => '1',
				'priority'    => 10,
			),
			'api_map'      => array(
				'type'     => 'text',
				'label'    => esc_html__( 'API Google Map', 'lovus' ),
				'section'  => 'styling',
				'default'  => 'AIzaSyAvpnlHRidMIU374bKM5-sx8ruc01OvDjI',
				'priority' => 10,
			),
			'main_color'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Primary Color', 'lovus' ),
				'section'  => 'styling',
				'default'  => '#d1a17a',
				'priority' => 10,
			),
			'custom_css'     => array(
				'type'        => 'code',
				'label'       => esc_html__( 'Custom Code', 'lovus' ),
				'description' => esc_html__( 'Add more js, css, html... code here.', 'lovus' ),
				'section'     => 'styling',
				'default'     => '',
				'priority'    => 10,
			),
		),
	)
);