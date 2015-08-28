<?php

/*
Widget Name: Sermon Series Widget
Description: A widget to show a grid view of Sermon categories as Series.
Author: imithemes
Author URI: http://imithemes.com
*/

class Sermon_Series_Widget extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'sermon-series-widget',
			__('Sermon Series Widget', 'imic-framework'),
			array(
				'description' => __('A widget to show a grid view of Sermon categories as Series.', 'imic-framework'),
				'panels_icon' => 'dashicons dashicons-list-view',
				'panels_groups' => array('framework')
			),
			array(

			),
			array(
				'number_of_posts' => array(
					'type' => 'slider',
					'label' => __( 'Number of Categories to show', 'imic-framework' ),
					'default' => 4,
					'min' => 1,
					'max' => 100,
					'integer' => true,
				),
				'show_post_meta' => array(
					'type' => 'checkbox',
					'default' => true,
					'label' => __('Show Series Date Range', 'imic-framework'),
				),
				'series_order' => array(
					'type' => 'text',
					'label' => __('Series Order (Enter Sermon Categories IDs in which you would like to show them Ex-1,2,3)', 'imic-framework'),
					'description' => __( 'How to know the Sermon category ID? - Go to Sermons > Sermon Categories in WP Dashboard. On the categories list page hover over the Category and you can see the ID in the link of it.', 'imic-framework' ),
				),
				'excerpt_length' => array(
					'type' => 'text',
					'default' => 25,
					'label' => __('Length of excerpt(Enter the number of words to show)? Leave blank to hide - Default is: 25', 'imic-framework'),
				),
				'read_more_text' => array(
					'type' => 'text',
					'default' => 'View Series',
					'label' => __('View Series button text, Leave blank to hide button - Default is: View Series', 'imic-framework'),
				),
				'grid_column' => array(
					'type' => 'select',
					'state_name' => 'grid',
					'prompt' => __( 'Choose Grid Column', 'framework' ),
					'options' => array(
						'6' => __( 'Two', 'framework' ),
						'4' => __( 'Three', 'framework' ),
						'3' => __( 'Four', 'framework' ),
					)
				)
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
		return array();
	}
	function modify_instance($instance){
		return $instance;
	}


}

siteorigin_widget_register('sermon-series-widget', __FILE__, 'Sermon_Series_Widget');