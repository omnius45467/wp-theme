<?php

/*
Widget Name: Events List Widget
Description: A widget to show upcoming events list.
Author: imithemes
Author URI: http://imithemes.com
*/

class Events_List_Widget extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'events-list-widget',
			__('Events List Widget', 'imic-framework'),
			array(
				'description' => __('A widget to show upcoming events list.', 'imic-framework'),
				'panels_icon' => 'dashicons dashicons-list-view',
				'panels_groups' => array('framework')
			),
			array(

			),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __('Title', 'siteorigin-widgets'),
				),

				'allpostsbtn' => array(
					'type' => 'text',
					'label' => __('All events button text', 'imic-framework'),
					'default' => __('All Events', 'imic-framework'),
					'description' => __('This button will be displayed only if the widget has title.', 'imic-framework'),
				),

				'allpostsurl' => array(
					'type' => 'link',
					'label' => __('All events button URL', 'imic-framework'),
					'description' => __('This button will be displayed only if the widget has title.', 'imic-framework'),
				),

				'categories' => array(
					'type' => 'text',
					'label' => __('Event Category slug (Enter only a single category slug)', 'imic-framework'),
				),
				'event_type' => array(
					'type' => 'select',
					'state_name' => 'future',
					'prompt' => __( 'Choose Events Type', 'framework' ),
					'options' => array(
						'future' => __( 'Future', 'framework' ),
						'past' => __( 'Past', 'framework' ),
					)
				),
				'number_of_posts' => array(
					'type' => 'slider',
					'label' => __( 'Number of Upcoming Events to show', 'imic-framework' ),
					'default' => 4,
					'min' => 1,
					'max' => 25,
					'integer' => true,
				),
				'show_post_meta' => array(
					'type' => 'checkbox',
					'default' => true,
					'label' => __('Show post action icons like Share, Location, Register?', 'imic-framework'),
				),
			),
			plugin_dir_path(__FILE__)
		);
	}


	
	function get_template_name( $instance ) {
		return 'list-view';
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

siteorigin_widget_register('events-list-widget', __FILE__, 'Events_List_Widget');