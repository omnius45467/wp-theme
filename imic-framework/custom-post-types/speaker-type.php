<?php
/* ==================================================
  Speaker Post Type Functions
  ================================================== */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
add_action('init', 'speaker_register');
function speaker_register() {
	$args_c = array(
    "label" => __('Staff Categories', "imic-framework-admin"),
    "singular_label" => __('Staff Category', "imic-framework-admin"),
    'public' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'args' => array('orderby' => 'term_order'),
    'rewrite' => false,
    'query_var' => true,
	'show_admin_column' => true,
);
register_taxonomy('speaker-category', 'speaker', $args_c);
    $labels = array(
        'name' => __('Staff', 'framework'),
        'singular_name' => __('Staff', 'framework'),
        'all_items'=> __('Staff', 'framework'),
        'add_new' => __('Add New', 'framework'),
        'add_new_item' => __('Add New Staff Member', 'framework'),
        'edit_item' => __('Edit Staff Member', 'framework'),
        'new_item' => __('New Staff Member', 'framework'),
        'view_item' => __('View Staff', 'framework'),
        'search_items' => __('Search Staff', 'framework'),
        'not_found' => __('No staff member have been added yet', 'framework'),
        'not_found_in_trash' => __('Nothing found in Trash', 'framework'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
		'capability_type' => 'page',
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'rewrite' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'page-attributes','excerpt','author'),
        'has_archive' => true,
		'menu_icon' => 'dashicons-businessman',
    );
    register_post_type('speaker', $args);
	register_taxonomy_for_object_type('speaker-category','speaker');
}
?>