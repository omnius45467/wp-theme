<?php

/*
Widget Name: Full Width Gallery Widget
Description: A widget to show Gallery Posts in a Full width layout.
Author: imithemes
Author URI: http://imithemes.com
*/

class Full_Width_Gallery_Widget extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'full-width-gallery-widget',
			__('Full Width Gallery Widget', 'imic-framework'),
			array(
				'description' => __('A widget to show Gallery Posts in a Full width layout.', 'imic-framework'),
				'panels_icon' => 'dashicons dashicons-format-gallery',
				'panels_groups' => array('framework')
			),
			array(

			),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __('Overlay Title', 'siteorigin-widgets'),
				),

				'categories' => array(
					'type' => 'text',
					'label' => __('Categories (Enter comma separated gallery category slugs)', 'imic-framework'),
				),
				'number_of_posts' => array(
					'type' => 'slider',
					'label' => __( 'Number of Gallery Items to show', 'imic-framework' ),
					'default' => 5,
					'min' => 1,
					'max' => 20,
					'integer' => true,
				),
				'icon' => array(
					'type' => 'icon',
					'label' => __('Icon', 'siteorigin-widgets'),
				),
  				'icon_size' => array(
					'type' => 'number',
					'label' => __('Icon size', 'siteorigin-widgets'),
					'default' => 48,
				),
				'icon_image' => array(
					'type' => 'media',
					'library' => 'image',
					'label' => __('Icon image', 'siteorigin-widgets'),
					'description' => __('Use your own icon image.', 'siteorigin-widgets'),
				),
				'grid_column' => array(
					'type' => 'select',
					'state_name' => 'grid',
					'prompt' => __( 'Choose Grid Column', 'framework' ),
					'options' => array(
						'5' => __( 'Five', 'framework' ),
						'4' => __( 'Four', 'framework' ),
						'3' => __( 'Three', 'framework' ),
						'2' => __( 'Two', 'framework' ),
					)
				),
				
			),
			plugin_dir_path(__FILE__)
		);
	}


	
	function get_template_name( $instance ) {
		return 'grid-view';
	}

	function get_style_name($instance) {
		return false;
	}

	function get_less_variables($instance){
		return false;
	}


}

siteorigin_widget_register('full-width-gallery-widget', __FILE__, 'Full_Width_Gallery_Widget');