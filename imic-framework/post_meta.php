<?php
if (!function_exists('imic_register_post_box')) {
    add_action('admin_init', 'imic_register_post_box');
    function imic_register_post_box() {
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    $post_types = array(
		'' => __('Select','framework'),
		'post' => __('Post', 'framework'),
		'speaker' => __('Speaker','framework'),
		'gallery' => __('Gallery','framework'),
		'sermon' => __('Sermon','framework'),
		'product' => __('Product','framework'),
            );
	$product_cat = 'product_cat';
}
else {
	$post_types = array(
		'' => __('Select','framework'),
		'post' => __('Post', 'framework'),
		'speaker' => __('Speaker','framework'),
		'gallery' => __('Gallery','framework'),
		'sermon' => __('Sermon','framework'),
            );
	$product_cat = 'category';
}
if (!function_exists('imic_get_all_sidebars')) {
    function imic_get_all_sidebars() {
        $all_sidebars = array();
        global $wp_registered_sidebars;
        $all_sidebars = array('' => '');
        foreach ($wp_registered_sidebars as $sidebar) {
            $all_sidebars[$sidebar['id']] = $sidebar['name'];
        }
        return $all_sidebars;
    }
}
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_';
//Event Counter Section
$meta_box = array(
    'id' => 'template-home28',
    'title' => __('Event Counter Section', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
          array(
            'name' => __('Enabled/Disable Section', 'framework'),
            'id' => $prefix . 'event_counter',
            'desc' => __("Select Enabled to active event section.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
		'1' => __('Enable','framework'),
            ),
	'std' => 0,
        ),
		array(
            'name' => __('Counter Title', 'framework'),
            'id' => $prefix . 'event_counter_title',
                'desc' => __("Enter the Event Counter Title.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
        'name'    => __( 'Event Category', 'framework' ),
        'id'      => $prefix . 'counter_event_category',
        'desc' => __("Choose Event Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'event-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
));
new RW_Meta_Box($meta_box);	
$meta_box = array(
    'id' => 'template-home26',
    'title' => __('Post Section 1', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
          array(
            'name' => __('Enabled/Disable Section', 'framework'),
            'id' => $prefix . 'status_section1',
            'desc' => __("Select Enabled to active Latest Post.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
		'1' => __('Enable','framework'),
            ),
	'std' => 0,
        ),
		array(
                    'name' => 'Select Sidebar',
                    'id' => $prefix . 'section1_homepage_sidebar',
                    'desc' => __("Select Sidebar for this section.", 'framework'),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars(),
                ),
		array(
            'name' => __('Link Title', 'framework'),
            'id' => $prefix . 'section1_link_title',
                'desc' => __("Enter the Link title.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => __('Link to page', 'framework'),
            'id' => $prefix . 'section1_page_link',
                'desc' => __("Enter the Page Link.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => __('Heading Title', 'framework'),
            'id' => $prefix . 'section1_heading',
                'desc' => __("Enter the heading title.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => __('Event Type', 'framework'),
            'id' => $prefix . 'section1_event_type',
            'desc' => __("Select Event Type.", 'framework'),
            'type' => 'select',
            'options' => array(
		'future' => __('Future', 'framework'),
		'past' => __('Past','framework'),
            ),
		'std' => 'future',
        ),
		array(
        'name'    => __( 'Event Category', 'framework' ),
        'id'      => $prefix . 'section1_event_category',
        'desc' => __("Choose Event Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'event-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
		array(
            'name' => __('Events Count', 'framework'),
            'id' => $prefix . 'section1_event_count',
                'desc' => __("Enter the number of Events.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
));
new RW_Meta_Box($meta_box);
/* * **Home Page Meta Box1 *** */
$meta_box = array(
    'id' => 'template-home25',
    'title' => __('Post Section 2', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
          array(
            'name' => __('Enabled/Disable Section', 'framework'),
            'id' => $prefix . 'status_section2',
            'desc' => __("Select Enabled to active Latest Post.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
		'1' => __('Enable','framework'),
            ),
	'std' => 0,
        ),
		array(
                    'name' => 'Select Sidebar',
                    'id' => $prefix . 'section2_homepage_sidebar',
                    'desc' => __("Select Sidebar for this section.", 'framework'),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars(),
                ),
		array(
            'name' => __('Heading Title', 'framework'),
            'id' => $prefix . 'section2_heading',
                'desc' => __("Enter the heading title.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => __('Enabled/Disable Latest Post', 'framework'),
            'id' => $prefix . 'status_latest_post',
            'desc' => __("Select Enabled to active Latest Post.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
		'1' => __('Enable','framework'),
            ),
	'std' => 1,
        ),
		array(
            'name' => __('Recent Post Title', 'framework'),
            'id' => $prefix . 'section2_recent_title',
                'desc' => __("Enter the Recent Post title.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => __('Recent Post Excerpt', 'framework'),
            'id' => $prefix . 'section2_excerpt_length',
                'desc' => __("Enter the excerpt length for recent post section.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
            'name' => __('Select Post Type', 'framework'),
            'id' => $prefix . 'selected_post_type',
            'desc' => __("Select Post Type.", 'framework'),
            'type' => 'select',
            'options' => $post_types,
		'std' => 'post',
        ),
		array(
        'name'    => __( 'Post Category', 'framework' ),
        'id'      => $prefix . 'post_category',
        'desc' => __("Choose Post Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
		array(
        'name'    => __( 'Event Category', 'framework' ),
        'id'      => $prefix . 'event_category',
        'desc' => __("Choose Event Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'event-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
		array(
        'name'    => __( 'Gallery Category', 'framework' ),
        'id'      => $prefix . 'gallery_category',
        'desc' => __("Choose Gallery Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'gallery-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
		array(
        'name'    => __( 'Sermon Category', 'framework' ),
        'id'      => $prefix . 'sermon_category',
        'desc' => __("Choose sermon Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'sermon-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
		array(
        'name'    => __( 'Product Category', 'framework' ),
        'id'      => $prefix . 'product_category',
        'desc' => __("Choose Product Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => $product_cat,
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
            ),
		array(
			'name' => __( 'Select Post Options', 'meta-box' ),
			'id' => $prefix.'select_post_options',
			'type' => 'checkbox_list',
			// Options of checkboxes, in format 'value' => 'Label'
			'options' => array(
			'thumb' => __( 'Thumbnail', 'framework' ),
			'title' => __( 'Title', 'framework' ),
			'text' => __( 'Text', 'framework' ),
			'more' => __('Read More','framework'),
			),
			),
		array(
			'name' => __( 'Select Post Content Type', 'meta-box' ),
			'id' => $prefix.'select_post_content',
			'type' => 'radio',
			// Array of 'value' => 'Label' pairs for radio options.
			// Note: the 'value' is stored in meta field, not the 'Label'
			'options' => array(
			'excerpt' => __( 'Excerpt', 'framework' ),
			'content' => __( 'Content', 'framework' ),
			),
			),
		array(
            'name' => __('Post Excerpt', 'framework'),
            'id' => $prefix . 'section2_post_excerpt_length',
                'desc' => __("Enter the excerpt length for post section.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		array(
			'name' => __( 'Select Image Hyperlink', 'meta-box' ),
			'id' => $prefix.'select_thumb_hyperlink',
			'type' => 'radio',
			// Array of 'value' => 'Label' pairs for radio options.
			// Note: the 'value' is stored in meta field, not the 'Label'
			'options' => array(
			'0' => __( 'No Link', 'framework' ),
			'image' => __( 'Big Image', 'framework' ),
			'single' => __( 'Link to Post', 'framework' ),
			),
			),
		array(
			'name' => __( 'Select Title Hyperlink', 'meta-box' ),
			'id' => $prefix.'select_title_hyperlink',
			'type' => 'radio',
			// Array of 'value' => 'Label' pairs for radio options.
			// Note: the 'value' is stored in meta field, not the 'Label'
			'options' => array(
			'0' => __( 'No Link', 'framework' ),
			'single' => __( 'Link to Post', 'framework' ),
			),
			),
        array(
            'name' => __('Number of Latest Posts to show on page', 'framework'),
            'id' => $prefix . 'posts_to_show_on',
                'desc' => __("Enter the number of Latest Posts to show on page. example - 3 .", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
        ));
		new RW_Meta_Box($meta_box);
//Gallery Section
$meta_box = array(
    'id' => 'template-home27',
    'title' => __('Gallery Section', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
          array(
            'name' => __('Enabled/Disable Section', 'framework'),
            'id' => $prefix . 'status_gallery',
            'desc' => __("Select Enabled to active gallery section.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Disable', 'framework'),
		'1' => __('Enable','framework'),
            ),
	'std' => 0,
        ),
		array(
            'name' => __('Gallery Title', 'framework'),
            'id' => $prefix . 'gallery_title',
                'desc' => __("Enter the Gallery title.", 'framework'),
            'type' => 'text',
            'std' => ''
        ),
		
));
new RW_Meta_Box($meta_box);	
	}
}
?>