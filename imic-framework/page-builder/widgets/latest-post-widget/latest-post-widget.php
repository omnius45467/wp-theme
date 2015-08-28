<?php

/*
Widget Name: Latest Post Widget
Description: A widget to show a single very latest blog post.
Author: imithemes
Author URI: http://imithemes.com
*/

class Latest_Post_Widget extends SiteOrigin_Widget {
	function __construct() {

		parent::__construct(
			'latest-post-widget',
			__('Latest Post Widget', 'imic-framework'),
			array(
				'description' => __('A widget to show a single very latest blog post.', 'imic-framework'),
				'panels_icon' => 'dashicons dashicons-list-view',
				'panels_groups' => array('framework')
			),
			array(

			),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __('Widget Title', 'imic-framework'),
				),

				'categories' => array(
					'type' => 'text',
					'label' => __('Post Category slug (Enter only a single category slug)', 'imic-framework'),
				),
				'show_post_meta' => array(
					'type' => 'checkbox',
					'default' => true,
					'label' => __('Show post meta like post date, author, categories, comments?', 'imic-framework'),
				),
				'excerpt_length' => array(
					'type' => 'checkbox',
					'default' => true,
					'label' => __('Show post excerpt', 'imic-framework'),
				),
				'read_more_text' => array(
					'type' => 'text',
					'default' => 'Continue reading',
					'label' => __('Continue reading button text, Leave blank to hide button - Default is Continue Reading', 'imic-framework'),
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

siteorigin_widget_register('latest-post-widget', __FILE__, 'Latest_Post_Widget');