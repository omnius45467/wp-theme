<?php

/*
Widget Name: Sermons List Widget
Description: A widget to show sermons list/grid view.
Author: imithemes
Author URI: http://imithemes.com
*/

class Sermons_List_Widget extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'sermons-list-widget',
			__('Sermons List Widget', 'imic-framework'),
			array(
				'description' => __('A widget to show sermons list/grid view.', 'imic-framework'),
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
					'label' => __('All sermons button text', 'imic-framework'),
					'default' => __('All Sermons', 'imic-framework'),
					'description' => __('This button will be displayed only if the widget has title.', 'imic-framework'),
				),

				'allpostsurl' => array(
					'type' => 'link',
					'label' => __('All sermons button URL', 'imic-framework'),
					'description' => __('This button will be displayed only if the widget has title.', 'imic-framework'),
				),

				'categories' => array(
					'type' => 'text',
					'label' => __('Categories (Enter comma separated sermons category slugs)', 'imic-framework'),
				),
				'number_of_posts' => array(
					'type' => 'slider',
					'label' => __( 'Number of Sermons to show', 'imic-framework' ),
					'default' => 3,
					'min' => 1,
					'max' => 25,
					'integer' => true,
				),
				'show_post_meta' => array(
					'type' => 'checkbox',
					'default' => true,
					'label' => __('Show sermon meta like sermon date, media links?', 'imic-framework'),
				),
				'excerpt_length' => array(
					'type' => 'text',
					'default' => 50,
					'label' => __('Length of excerpt(Enter the number of words to show)? Leave blank to hide - Default is: 50', 'imic-framework'),
				),
				'read_more_text' => array(
					'type' => 'text',
					'default' => 'Watch Sermon',
					'label' => __('Continue reading button text, Leave blank to hide button - Default is: Watch Sermon', 'imic-framework'),
				),
				'listing_layout' => array(
					'type' => 'section',
					'label' => __( 'Layout', 'siteorigin-widgets' ),
					'hide' => false,
					'description' => __( 'Choose listing layout.', 'siteorigin-widgets' ),
					'fields' => array(
						'layout_type'    => array(
							'type'    => 'radio',
							'default' => 'list',
							'label'   => __( 'Layout Type', 'siteorigin-widgets' ),
							'options' => array(
								'list' => __( 'List View', 'siteorigin-widgets' ),
								'grid'      => __( 'Grid View', 'siteorigin-widgets' ),
								)
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
						),
					),
				)
			),
			plugin_dir_path(__FILE__)
		);
	}


	
	function get_template_variables( $instance, $args ) {
		$layout = $instance['listing_layout'];
		return array(
				'layout_type' => array(
					'column'  => (!empty($layout['grid_column']))? $layout['grid_column'] : 4
				)
			);
	}
	
	function get_template_name( $instance ) {
		return $instance['listing_layout']['layout_type'] == 'list' ? 'list-view' : 'grid-view';
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

siteorigin_widget_register('sermons-list-widget', __FILE__, 'Sermons_List_Widget');