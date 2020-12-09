<?php
/**
 * Hooks for importer
 *
 * @package MrBara
 */


/**
 * Importer the demo content
 *
 * @since  1.0
 *
 */
function mrbara_importer() {
	return array(
		array(
			'name'       => 'Lovus',
			'preview'    => get_template_directory_uri().'/framework/data/home1.jpg',
			'content'    => get_template_directory_uri().'/framework/data/wedding/demo-content.xml',
			'customizer' => get_template_directory_uri().'/framework/data/wedding/customizer.dat',
			'pages'      => array(
				'front_page' => 'Wedding 1 and Onepage Wedding',
				'blog'       => 'Journal',
			),
			'menus'      => array(
				'primary'      => 'main-menu',
				'onepage'      => 'onepage-menu',
			)
		),
		array(
			'name'       => 'Lovus Planner',
			'preview'    => get_template_directory_uri().'/framework/data/home2.jpg',
			'content'    => get_template_directory_uri().'/framework/data/wedding-planner/demo-content.xml',
			'customizer' => get_template_directory_uri().'/framework/data/wedding-planner/customizer.dat',
			'pages'      => array(
				'front_page' => 'Wedding Planner 1',
				'blog'       => 'Blog',
			),
			'menus'      => array(
				'primary'      => 'main-menu',
				'onepage'      => 'onepage-menu',
			)
		),
	);
}

add_filter( 'soo_demo_packages', 'mrbara_importer', 30 );