<?php

/**
 * Register meta boxes
 *
 * @since 1.0
 *
 * @param array $meta_boxes
 *
 * @return array
 */

function lovus_register_meta_boxes( $meta_boxes ) {

	$prefix = '_cmb_';
	$meta_boxes[] = array(

		'id'       => 'format_detail',

		'title'    => esc_html__( 'Format Details', 'lovus' ),

		'pages'    => array( 'post' ),

		'context'  => 'normal',

		'priority' => 'high',

		'autosave' => true,

		'fields'   => array(

			array(

				'name'             => esc_html__( 'Image', 'lovus' ),

				'id'               => $prefix . 'image',

				'type'             => 'image_advanced',

				'class'            => 'image',

				'max_file_uploads' => 1,

			),

			array(

				'name'  => esc_html__( 'Gallery', 'lovus' ),

				'id'    => $prefix . 'images',

				'type'  => 'image_advanced',

				'class' => 'gallery',

			),			

			array(

				'name'  => esc_html__( 'Audio', 'lovus' ),

				'id'    => $prefix . 'link_audio',

				'type'  => 'oembed',

				'cols'  => 20,

				'rows'  => 2,

				'class' => 'audio',

				'desc' => 'Ex: https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/139083759',

			),

			array(

				'name'  => esc_html__( 'Video', 'lovus' ),

				'id'    => $prefix . 'link_video',

				'type'  => 'oembed',

				'cols'  => 20,

				'rows'  => 2,

				'class' => 'video',

				'desc' => 'Example: <b>https://player.vimeo.com/video/92505328</b>',

			),			

		),

	);


	$meta_boxes[] = array(
		'id'         => 'page_settings',
		'title'      => 'Page/Post Settings',
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
                'name' => 'Background Header',
                'id'   => $prefix . 'bg_header',
                'type' => 'image_advanced',
                'max_file_uploads' => 1,
            ),
            array(
                'name' => 'Full Height?',
                'id'   => $prefix . 'fheight',
                'type' => 'checkbox',
            ),
            array(
                'name' => 'Sub Text',
                'id'   => $prefix . 'subtext',
                'type' => 'text',
            ),
		)
	);
	

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'lovus_register_meta_boxes' );

