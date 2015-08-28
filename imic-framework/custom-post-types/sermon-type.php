<?php
/* ==================================================
  Sermons Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'sermon_register');
function sermon_register() {
    $args_c = array(
    "label" => __('Sermon Categories','framework'),
    "singular_label" => __('Sermon Category','framework'),
    'public' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'args' => array('orderby' => 'term_order'),
    'rewrite' => false,
   'query_var' => true,
   'show_admin_column' => true,
);
    $tags = array(
    "label" => __('Sermon Tags','framework'),
    "singular_label" => __('Sermon Tag','framework'),
    'public' => true,
    'hierarchical' => false,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'args' => array('orderby' => 'term_order'),
    'rewrite' => false,
   'query_var' => true,
   'show_admin_column' => true,
);
register_taxonomy('sermon-tag', 'sermon',$tags);
register_taxonomy('sermon-category', 'sermon',$args_c);
    $labels = array(
        'name' => __('Sermons', 'framework'),
        'singular_name' => __('Sermon','framework'),
        'add_new' => __('Add New', 'framework'),
        'add_new_item' => __('Add New Sermon', 'framework'),
        'edit_item' => __('Edit Sermon', 'framework'),
        'new_item' => __('New Sermon', 'framework'),
        'view_item' => __('View Sermon', 'framework'),
        'search_items' => __('Search Sermons', 'framework'),
        'not_found' => __('No sermons have been added yet', 'framework'),
        'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
        'parent_item_colon' => '',
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'hierarchical' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor', 'thumbnail','excerpt','author'),
        'has_archive' => true,
		'menu_icon' => 'dashicons-media-text',
        'taxonomies' => array('sermon-category')
    );
     register_post_type('sermon', $args);
     register_taxonomy_for_object_type('sermon-category','sermon');
	 register_taxonomy_for_object_type('sermon-tag','sermon');
}
?>