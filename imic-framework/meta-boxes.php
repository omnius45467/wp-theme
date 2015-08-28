<?php
/* * ** Meta Box Functions **** */
$prefix = 'imic_';
global $meta_boxes;
load_theme_textdomain('framework', IMIC_FILEPATH . '/language');
$meta_boxes = array();
  /* Speaker Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'staff_meta_box',
    'title' => __('Staff Member Meta', 'framework'),
    'pages' => array('speaker'),
    'fields' => array(
		array(
            'name' => __('Show Sermon URL', 'framework'),
            'id' => $prefix . 'display_sermon_url',
            'desc' => __("Select Enabled to show sermons of this speaker.", 'framework'),
            'type' => 'select',
            'options' => array(
		'1' => __('Enable', 'framework'),
		'0' => __('Disable','framework'),
            ),
	'std' => 1,
        ),
		array(
            'name' => __('Position', 'framework'),
            'id' => $prefix . 'staff_position',
            'desc' => __("Enter the staff job title.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Email', 'framework'),
            'id' => $prefix . 'staff_member_email',
            'desc' => __("Enter the staff member's Email.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
                    'name'  => __('Social Icon', 'framework'),
                    'id'    => $prefix."social_icon_list",
                    'desc'  =>  __('Enter Social Icon and Url.', 'framework'),
                    'type'  => 'text_list',
                    'clone' => true,
                    'options' => array(
                            '0' => __('Social', 'framework'),
                            '1' => __('Url', 'framework'))
                      ),
    )
);
  /* Sermon Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'sermon_meta_box',
    'title' => __('Sermon Details', 'framework'),
    'pages' => array('sermon'),
    'fields' => array(
		array(
			'name' => __( 'Sermon Speakers', 'framework' ),
			'id' => $prefix.'sermon_speaker',
			'type' => 'post',
			// Post type
			'post_type' => 'speaker',
			// Field type, either 'select' or 'select_advanced' (default)
			'field_type' => 'select_advanced',
			'multiple' => true,
			// Query arguments (optional). No settings means get all published posts
			'query_args' => array(
			'post_status' => 'publish',
			'posts_per_page' => - 1,
			)
			),
		array(
            'name' => __('Sermon Date', 'framework'),
            'id' => $prefix . 'sermon_date',
            'desc' => __("Insert sermon date.", 'framework'),
            'type' => 'date',
			'js_options' => array(
				'dateFormat'      =>'yy-mm-dd',
				'changeMonth'     => true,
				'changeYear'      => true,
				'showButtonPanel' => false,
			),
        ),
		array(
            'name' => __('MP4 Video', 'framework'),
            'id' => $prefix . 'mp4_video',
            'desc' => __("Insert MP4 Video.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
		array(
            'name' => __('WEBM Video', 'framework'),
            'id' => $prefix . 'webm_video',
            'desc' => __("Insert WEBM Video.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
		array(
            'name' => __('OGG Video', 'framework'),
            'id' => $prefix . 'ogg_video',
            'desc' => __("Insert OGG Video.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
		array(
            'name' => __('Vimeo URL', 'framework'),
            'id' => $prefix . 'vimeo_video',
            'desc' => __("Enter Vimeo video URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Youtube URL', 'framework'),
            'id' => $prefix . 'youtube_video',
            'desc' => __("Enter Youtube video URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('Self Hosted Audio', 'framework'),
            'id' => $prefix . 'self_audio',
            'desc' => __("Insert self hosted audio.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
		array(
			'name' => __( 'Audio Description', 'meta-box' ),
			'id' => $prefix.'audio_desc',
			'type' => 'wysiwyg',
			// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
			'raw' => false,
			'std' => __( 'WYSIWYG default value', 'meta-box' ),
			// Editor settings, see wp_editor() function: look4wp.com/wp_editor
			'options' => array(
			'textarea_rows' => 3,
			'tinymce' => true,
			'media_buttons' => true,
			),
			),
		array(
            'name' => __('Soundcloud URL', 'framework'),
            'id' => $prefix . 'soundcloud_audio',
            'desc' => __("Enter Soundcloud audio URL.", 'framework'),
            'type' => 'text',
            'std' => '',
        ),
		array(
            'name' => __('PDF', 'framework'),
            'id' => $prefix . 'pdf_url',
            'desc' => __("Insert PDF URL.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
    )
);/* Sermon Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'sermon_podcast',
    'title' => __('Sermon Podcast', 'framework'),
    'pages' => array('sermon'),
    'fields' => array(
         //Podcast Desciption
        array(
            'name' => __('Sermon short description', 'framework'),
            'id' => $prefix . 'sermons_podcast_description',
            'desc' => __("Enter short and sweet description for this sermon to show at podcast players.", 'framework'),
            'type' => 'textarea'
        ),
      )
);
/* * **Gallery Page Meta Box1 *** */
$meta_boxes[] = array(
    'id' => 'template-gallery1',
    'title' => __('Gallery  Metabox', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
           array(
            'name' => __('Enabled/Disable Sorting  Bar', 'framework'),
            'id' => $prefix . 'gallery_secondary_bar_type_status',
            'desc' => __("Select Enabled to active Sorting  Bar.", 'framework'),
            'type' => 'select',
            'options' => array(
		'1' => __('Enable', 'framework'),
		'0' => __('Disable','framework'),
            ),
	'std' => 0,
        ),
		array(
            'name' => __('Enabled/Disable Pagination', 'framework'),
            'id' => $prefix . 'gallery_page_pagination',
            'desc' => __("Select Enabled to active Pagination.", 'framework'),
            'type' => 'select',
            'options' => array(
		'1' => __('Enable', 'framework'),
		'0' => __('Disable','framework'),
            ),
	'std' => 0,
        ),
		array(
        'name'    => __( 'Gallery Category', 'framework' ),
        'id'      => $prefix . 'advanced_gallery_taxonomy',
        'desc' => __("Choose Gallery Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'gallery-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
				'std' => '',
            ),
		array(
			'name'  => __('Gallery to show on page', 'framework'),
			'id'    => $prefix."gallery_number_show",
			'desc'  =>  __("Enter number of galleries to show on page, blank will show all Gallery items.", 'framework'),
			'type' => 'text',
		),  
       array(
            'name' => __('Columns Layout', 'framework'),
            'id' => $prefix . 'projects_columns_layout',
            'desc' => __("Select Columns Layout .", 'framework'),
            'type' => 'select',
            'options' => array(
				'3' => __('One Fourth', 'framework'),
				'4' => __('One Third','framework'),
				'6' => __('Half','framework'),
					),
			'std' => 4,
	),
       ));
/* * **Sermon Series Page Meta Box1 *** */
$meta_boxes[] = array(
    'id' => 'template-sermon1',
    'title' => __('Sermon Metabox', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(
           array(
			'name'  => __('Sermon Categories', 'framework'),
			'id'    => $prefix."sermon_series_cat",
			'desc'  =>  __("Enter Sermon Categories ID's in which order you would like to show them Ex-1,2,3.", 'framework'),
			'type' => 'text',
		),  
			array(
            'name' => __('Sermon Series Column', 'framework'),
            'id' => $prefix . 'sermon_series_column',
            'desc' => __("Select Columns Layout .", 'framework'),
            'type' => 'select',
            'options' => array(
				'3' => __('One Fourth', 'framework'),
				'4' => __('One Third','framework'),
				'6' => __('Half','framework'),
					),
			'std' => 4,
	),
			array(
			'name'  => __('Sermon Count', 'framework'),
			'id'    => $prefix."sermon_series_count",
			'desc'  =>  __("Enter number of sermon series to show.", 'framework'),
			'type' => 'text',
		),  
			array(
			'name'  => __('Description', 'framework'),
			'id'    => $prefix."sermon_series_desc",
			'desc'  =>  __("Enter number of words to show from description Default:25.", 'framework'),
			'type' => 'text',
		), 
			array(
			'name' => __( 'Sermon Label', 'meta-box' ),
			'id' => $prefix.'sermon_series_label',
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std' => 1,
		), 
			array(
			'name'  => __('Button Label', 'framework'),
			'id'    => $prefix."sermon_series_button",
			'desc'  =>  __("Enter button value.", 'framework'),
			'type' => 'text',
		), 
));
/* * **Sermon List/Grid Page Meta Box1 *** */
$meta_boxes[] = array(
    'id' => 'template-sermon-two1',
    'title' => __('Sermons View Style', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array( 
      	array(
            'name' => __('Layout Type', 'framework'),
            'id' => $prefix . 'sermons_layout_type',
            'desc' => __("Select Layout Type", 'framework'),
            'type' => 'select',
            'options' => array(
				'0' => __('List', 'framework'),
				'1' => __('Grid','framework'),
					),
			'std' => 0,
		),  
         array(
            'name' => __('Columns Layout', 'framework'),
            'id' => $prefix . 'sermons_columns_layout',
            'desc' => __("Select Columns Layout for Grid Layout Type.", 'framework'),
            'type' => 'select',
            'options' => array(
				'3' => __('One Fourth', 'framework'),
				'4' => __('One Third','framework'),
				'6' => __('Half','framework'),
					),
			'std' => 4,
		), 
		array(
			'name'  => __('Sermons Count', 'framework'),
			'id'    => $prefix."sermons_count",
			'desc'  =>  __("Number of Sermons to show on page", 'framework'),
			'type' => 'text',
		),   
		array(
        'name'    => __( 'Sermons Category', 'framework' ),
        'id'      => $prefix . 'advanced_sermons_list_taxonomy',
        'desc' => __("Choose Sermons Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'sermon-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
			'std' => '',
         ), 
		array(
			'name'  => __('Sermons Excerpt', 'framework'),
			'id'    => $prefix."sermons_desc",
			'desc'  =>  __("Enter number of words to show as excerpt from sermon content. Default:25.", 'framework'),
			'type' => 'text',
		),
		array(
			'name'  => __('Button Label', 'framework'),
			'id'    => $prefix."sermons_button",
			'desc'  =>  __("Enter read more button label", 'framework'),
			'type' => 'text',
		), 
));
/* * **Event Page Meta Box1*** */
$meta_boxes[] = array(
    'id' => 'template-event1',
    'title' => __('Event Metabox', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(  
      array(
            'name' => __('Event Layout Type', 'framework'),
            'id' => $prefix . 'event_layout_type',
            'desc' => __("Select Event Layout Type.", 'framework'),
            'type' => 'select',
            'options' => array(
		'0' => __('Month List', 'framework'),
		'1' => __('Grid','framework'),
		'2' => __('Future&Past','framework'),
            ),
	'std' => 0,
        ),  
		array(
			'name'  => __('Event Count', 'framework'),
			'id'    => $prefix."events_count",
			'desc'  =>  __("Number of Events to show for Future&Past.", 'framework'),
			'type' => 'text',
		),   
		array(
        'name'    => __( 'Event Category', 'framework' ),
        'id'      => $prefix . 'advanced_event_list_taxonomy',
        'desc' => __("Choose Event Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'event-category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
			'std' => '',
            ), 
         array(
            'name' => __('Columns Layout', 'framework'),
            'id' => $prefix . 'temp_event_columns_layout',
            'desc' => __("Select Columns Layout .", 'framework'),
            'type' => 'select',
            'options' => array(
				'3' => __('One Fourth', 'framework'),
				'4' => __('One Third','framework'),
				'6' => __('Half','framework'),
					),
			'std' => 4,
	),
       ));
/* * **Template Blog Masonry Page Meta Box1*** */
$meta_boxes[] = array(
    'id' => 'template-blog-masonry1',
    'title' => __('Blog Masonry Metabox', 'framework'),
    'pages' => array('page'),
    'show_names' => true,
    'fields' => array(   
		array(
			'name'  => __('Post Count', 'framework'),
			'id'    => $prefix."post_count",
			'desc'  =>  __("Number of Posts to show.", 'framework'),
			'type' => 'text',
		),   
		array(
        'name'    => __( 'Post Category', 'framework' ),
        'id'      => $prefix . 'advanced_post_list_taxonomy',
        'desc' => __("Choose Post Category", 'framework'),
        'type'    => 'taxonomy_advanced',
        'options' => array(
                // Taxonomy name
                'taxonomy' => 'category',
                'type' => 'select',
                // Additional arguments for get_terms() function. Optional
                'args' => array('orderby' => 'count', 'hide_empty' => true)
                ),
			'std' => '',
            ), 
         array(
            'name' => __('Columns Layout', 'framework'),
            'id' => $prefix . 'temp_event_columns_layout',
            'desc' => __("Select Columns Layout .", 'framework'),
            'type' => 'select',
            'options' => array(
				'3' => __('One Fourth', 'framework'),
				'4' => __('One Third','framework'),
				'6' => __('Half','framework'),
					),
			'std' => 4,
	),
       ));
/* Gallery & Post Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'gallery_meta_box',
    'title' => __('Post Meta Box', 'framework'),
    'pages' => array('gallery','post'),
    'fields' => array(
        // Gallery Video Url
		array(
            'name' => __('Video Options', 'framework'),
            'id' => $prefix . 'post_video_option',
            'desc' => __("Select Video Option.", 'framework'),
            'type' => 'select',
            'options' => array(
                '1' => __('Youtube or Vimeo', 'framework'),
                '2' => __('Self Hosted', 'framework'),
            ),
        ),
        array(
            'name' => __('Video Url', 'framework'),
            'id' => $prefix . 'gallery_video_url',
            'desc' => __("Enter the Youtube or Vimeo URL.", 'framework'),
            'type' => 'url',
        ),
		array(
            'name' => __('MP4 Video', 'framework'),
            'id' => $prefix . 'post_mp4_video',
            'desc' => __("Insert MP4 Video.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
		array(
            'name' => __('WEBM Video', 'framework'),
            'id' => $prefix . 'post_webm_video',
            'desc' => __("Insert WEBM Video.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
		array(
            'name' => __('OGG Video', 'framework'),
            'id' => $prefix . 'post_ogg_video',
            'desc' => __("Insert OGG Video.", 'framework'),
            'type' => 'file_input',
			'clone' => false,
            'std' => '',
        ),
        // Gallery Link Url
        array(
            'name' => __('Link Url', 'framework'),
            'id' => $prefix . 'gallery_link_url',
            'desc' => __("Enter the Link URL.", 'framework'),
            'type' => 'url',
        ),
		array(
            'name' => __('Gallery Images', 'framework'),
            'id' => $prefix . 'gallery_images',
            'desc' => __("Upload images for gallery.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 30
        ),
		array(
            'name' => __('Slider Speed', 'framework'),
            'id' => $prefix . 'gallery_slider_speed',
            'desc' => __("Default Slider Speed is 5000.", 'framework'),
            'type' => 'text',
        ),
       array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'gallery_slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'gallery_slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'gallery_slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'gallery_slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
        //Audio Display
        array(
            'name' => __('Audio', 'framework'),
            'id' => $prefix . 'gallery_uploaded_audio',
            'desc' => __("Upload Audio.", 'framework'),
            'type' => 'file_input',
        ),
    )
);
/* Event Meta Box
  ================================================== */
/*** Event Details Meta box ***/   
$meta_boxes[] = array(
    'id' => 'event_meta_box',
    'title' => __('Event Date', 'framework'),
    'pages' => array('event'),
    'fields' => array( 
        // Event Start Date 
		array(
            'name' => __('Featured Event', 'framework'),
            'id' => $prefix . 'featured_event',
            'desc' => __("Select Featured Event.", 'framework'),
            'type' => 'select',
            'options' => array(
				'no' => __('No','framework'),
				'yes' => __('Yes','framework'),
        ),
		), 
        array(
            'name' => __('Event Start Date', 'framework'),
            'id' => $prefix . 'event_start_dt',
            'desc' => __("Insert date of Event start.", 'framework'),
            'type' => 'datetime',
			'js_options' => array(
	              'dateFormat'      => 'yy-mm-dd',
				  'hourMax' => 24,
				  	'timeFormat' => 'hh:mm',
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => true,
					'stepMinute' => 5,
					'showSecond' => false,
					'stepSecond' => 10,
				),
        ),
        //Event End Date
        array(
            'name' => __(' Event End Date', 'framework'),
            'id' => $prefix . 'event_end_dt',
            'desc' => __("Insert date of Event end, multiple days Event could not be recur.", 'framework'),
            'type' => 'datetime',
			'js_options' => array(
	              'dateFormat'      => 'yy-mm-dd',
				  'hourMax' => 24,
					'changeMonth'     => true,
					'changeYear'      => true,
					'showButtonPanel' => true,
					'stepMinute' => 5,
					'showSecond' => false,
					'stepSecond' => 10,
				),
        ),
    )
);
/*** Event Address Meta box ***/   
$meta_boxes[] = array(
    'id' => 'event_address_box',
    'title' => __('Event Details', 'framework'),
    'pages' => array('event'),
    'fields' => array( 
	 //Address
		 /*array(
			'name'  => __('Address1', 'framework'),
			'id'    => $prefix."event_address1",
			'desc'  =>  __("Enter event's address1.", 'framework'),
			'type' => 'text',
		),*/
		array(
			'name'  => __('Address2', 'framework'),
			'id'    => $prefix."event_address2",
			'desc'  =>  __("This field should have real address to get GMap.", 'framework'),
			'type' => 'text',
		),   
		array(
			'id'    => $prefix."event_map_location",
			'name' => __( 'Location', 'meta-box' ),
			'type' => 'map',
			'std' => '-6.233406,-35.049906,15', // 'latitude,longitude[,zoom]' (zoom is optional)
			'style' => 'width: 500px; height: 500px',
			'address_field' => 'imic_event_address2', // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
			), 
		array(
                    'name'  => __('Additional Information', 'framework'),
                    'id'    => $prefix."event_extra_info",
                    'desc'  =>  __('Enter additional information.', 'framework'),
                    'type'  => 'text_list',
                    'clone' => true,
                    'options' => array(
                            '0' => __('Title', 'framework'),
                            '1' => __('value', 'framework'))
                      ),
		array(
			'name'  => __('Event Manager', 'framework'),
			'id'    => $prefix."event_manager",
			'desc'  =>  __("Enter event manager email address for contact.", 'framework'),
			'type' => 'text',
		),  
		array(
			'name' => __( 'Enable Registration', 'framework' ),
			'id' => $prefix.'event_registration',
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std' => 1,
		),  
		array(
			'name' => __( 'Custom Registration Button URL', 'framework' ),
			'id' => $prefix.'custom_event_registration',
			'desc' => __("For example EventBrite Event page URL of yours.", 'framework'),
			'type' => 'text'
		),
		array(
			'name' => __( 'Open custom URL in new Tab/Window', 'framework' ),
			'id' => $prefix.'custom_event_registration_target',
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std' => 1,
		),
		)
);
/*** Event Recurrence Meta box ***/   
$meta_boxes[] = array(
    'id' => 'event_recurring_box',
    'title' => __('Recurring Event', 'framework'),
    'pages' => array('event'),
    'fields' => array( 		 
        //Frequency of Event
		array(
            'name' => __('Event Frequency Type', 'framework'),
            'id' => $prefix . 'event_frequency_type',
            'desc' => __("Select Frequency Type.", 'framework'),
            'type' => 'select',
            'options' => array(
				'0' => __('Not Required','framework'),
				'1' => __('Fixed Date','framework'),
                '2' => __('Week Day', 'framework'),
        ),
		),
		array(
            'name' => __('Day of Month', 'framework'),
            'id' => $prefix . 'event_day_month',
            'desc' => __("Select Day of Month.", 'framework'),
            'type' => 'select',
            'options' => array(
				'first' => __('First','framework'),
                'second' => __('Second', 'framework'),
				'third' => __('Third', 'framework'),
				'fourth' => __('Fourth', 'framework'),
				'last' => __('Last', 'framework'),
        ),
		),
		array(
            'name' => __('Event Week Day', 'framework'),
            'id' => $prefix . 'event_week_day',
            'desc' => __("Select Week Day.", 'framework'),
            'type' => 'select',
            'options' => array(
				'sunday' => __('Sunday','framework'),
                'monday' => __('Monday', 'framework'),
				'tuesday' => __('Tuesday', 'framework'),
				'wednesday' => __('Wednesday', 'framework'),
				'thursday' => __('Thursday', 'framework'),
				'friday' => __('Friday', 'framework'),
				'saturday' => __('Saturday', 'framework'),
        ),
		),
        array(
            'name' => __('Event Frequency', 'framework'),
            'id' => $prefix . 'event_frequency',
            'desc' => __("Select Frequency.", 'framework'),
            'type' => 'select',
            'options' => array(
				'35' => __('Select', 'framework'),
                '1' => __('Every Day', 'framework'),
				'2' => __('Every Second Day', 'framework'),
				'3' => __('Every Third Day', 'framework'),
				'4' => __('Every Fourth Day', 'framework'),
				'5' => __('Every Fifth Day', 'framework'),
				'6' => __('Every Sixth Day', 'framework'),
                '7' => __('Every Week', 'framework'),
				'30' => __('Every Month', 'framework'),
            ),
        ),
		//Frequency Count
		array(
            'name' => __('Number of times to repeat event', 'framework'),
            'id' => $prefix . 'event_frequency_count',
            'desc' => __("Enter the number of how many time this event should repeat.", 'framework'),
            'type' => 'text',
        ),    
		array(
            'name' => __('Do not change', 'framework'),
            'id' => $prefix . 'event_frequency_end',
            'desc' => __("If any changes done in this file, may your theme will not work like running now.", 'framework'),
            'type' => 'hidden',
        ),    
    )
);
/* Contact Page Map Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-contact1',
    'title' => __('Banner Options','framework'),
   'pages' => array('page'),
    'fields' => array(
		array(
            'name' => __('Choose Banner Type', 'framework'),
            'id' => $prefix . 'contact_banner_type',
            'desc' => __("Select Banner Type.", 'framework'),
            'type' => 'select',
            'options' => array(
					'1' => __('Map', 'framework'),
				  '2' => __('Banner Options', 'framework'),
            ),
			'std' => '2'
        ),
		array(
            'name' => __('Address for Map', 'framework'),
            'id' => $prefix . 'contact_map_address',
            'desc' => __("Enter address for map.", 'framework'),
            'type' => 'text',
        ),
        )
);
/* Post Page Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'post_page_meta_box',
    'title' => __('Page/Post Header Options', 'framework'),
   'pages' => array('post','page','sermon','event','product','speaker'),
    'fields' => array(
		array(
            'name' => __('Choose Header Type', 'framework'),
            'id' => $prefix . 'pages_Choose_slider_display',
            'desc' => __("Select Banner Type.", 'framework'),
            'type' => 'select',
            'options' => array(
					'1' => __('Banner', 'framework'),
				  '2' => __('Banner Image', 'framework'),
                '3' => __('Flex Slider', 'framework'),
					'4' => __('Nivo Slider','framework'),
                '5' => __('Revolution Slider', 'framework'),
				'6' => __('Layer Slider', 'framework'),
            ),
			'std' => 2
        ),
		array(
				'name' => __( 'Banner Color', 'meta-box' ),
				'id' => $prefix.'pages_banner_color',
				'type' => 'color',
				),
		array(
			'name' => __( 'Banner Overlay', 'meta-box' ),
			'id' => $prefix.'pages_banner_overlay',
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std' => 0,
		), 
		array(
			'name' => __( 'Banner Animation', 'meta-box' ),
			'id' => $prefix.'pages_banner_animation',
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std' => 0,
		), 
		array(
            'name' => __('Banner Image', 'framework'),
            'id' => $prefix . 'header_image',
            'desc' => __("Upload banner image for header for this Page/Post.", 'framework'),
            'type' => 'image_advanced',
            'max_file_uploads' => 1
        ),
		array(
            'name' => __('Banner Description', 'framework'),
            'id' => $prefix . 'pages_banner_description',
            'desc' => __("Enter banner description.", 'framework'),
            'type' => 'text',
        ),
        array(
                   'name' => __('Select Revolution Slider from list','framework'),
                    'id' => $prefix . 'pages_select_revolution_from_list',
                    'desc' => __("Select Revolution Slider from list", 'framework'),
                    'type' => 'select',
                    'options' => imic_RevSliderShortCode(),
                ),
		array(
                   'name' => __('Select Layer Slider from list','framework'),
                    'id' => $prefix . 'pages_select_layer_from_list',
                    'desc' => __("Select Layer Slider from list", 'framework'),
                    'type' => 'select',
                    'options' => imic_layerslidershortcode(),
                ),
        //Slider Image
		array(
            'name' => __('Banner/Slider Height', 'framework'),
            'id' => $prefix . 'pages_slider_height',
            'desc' => __("Enter Height for Banner/Slider Ex-265.", 'framework'),
            'type' => 'text',
        ),
        array(
            'name' => __('Slider Image', 'framework'),
            'id' => $prefix . 'pages_slider_image',
            'desc' => __("Enter Slider Image.", 'framework'),
            'type' => 'image_advanced',
        ),
		array(
            'name' => __('Slider Pagination', 'framework'),
            'id' => $prefix . 'pages_slider_pagination',
            'desc' => __("Enable to show pagination for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Enable', 'framework'),
                'no' => __('Disable', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Auto Slide', 'framework'),
            'id' => $prefix . 'pages_slider_auto_slide',
            'desc' => __("Select Yes to slide automatically.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Direction Arrows', 'framework'),
            'id' => $prefix . 'pages_slider_direction_arrows',
            'desc' => __("Select Yes to show slider direction arrows.", 'framework'),
            'type' => 'select',
            'options' => array(
                'yes' => __('Yes', 'framework'),
                'no' => __('No', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Slide Interval', 'framework'),
            'id' => $prefix . 'pages_slider_interval',
            'desc' => __("Enter pause time for each slide. 1000 = 1 second. Default is 7000(7 seconds)", 'framework'),
            'type' => 'text',
            'std' => '7000'
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'pages_slider_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'fade' => __('Fade', 'framework'),
                'slide' => __('Slide', 'framework'),
            ),
        ),
		array(
            'name' => __('Slider Effects', 'framework'),
            'id' => $prefix . 'pages_nivo_effects',
            'desc' => __("Select effects for slider.", 'framework'),
            'type' => 'select',
            'options' => array(
                'sliceDown' => __('sliceDown', 'framework'),
                'sliceDownLeft' => __('sliceDownLeft', 'framework'),
				'sliceUp' => __('sliceUp', 'framework'),
                'sliceUpLeft' => __('sliceUpLeft', 'framework'),
				'sliceUpDown' => __('sliceUpDown', 'framework'),
                'sliceUpDownLeft' => __('sliceUpDownLeft', 'framework'),
				'fold' => __('fold', 'framework'),
                'fade' => __('fade', 'framework'),
				'random' => __('random', 'framework'),
                'slideInRight' => __('slideInRight', 'framework'),
				'slideInLeft' => __('slideInLeft', 'framework'),
                'boxRandom' => __('boxRandom', 'framework'),
				'boxRain' => __('boxRain', 'framework'),
				'boxRainReverse' => __('boxRainReverse', 'framework'),
				'boxRainGrow' => __('boxRainGrow', 'framework'),
				'boxRainGrowReverse' => __('boxRainGrowReverse', 'framework'),
            ),
        ),
        )
);
/* Contact Page Map Meta Box
  ================================================== */
$meta_boxes[] = array(
    'id' => 'template-contact2',
    'title' => __('Contact Options','framework'),
   'pages' => array('page'),
    'fields' => array(
		array(
            'name' => __('Contact Email', 'framework'),
            'id' => $prefix . 'contact_email',
            'desc' => __("Enter contact email, if left blank admin email will be used.", 'framework'),
            'type' => 'text',
        ),
        )
);
/* * ******************* META BOX REGISTERING ********************** */
/**
 * Register meta boxes
 *
 * @return void
 */
function imic_register_meta_boxes() {
    global $meta_boxes;
    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if (class_exists('RW_Meta_Box')) {
        foreach ($meta_boxes as $meta_box) {
            new RW_Meta_Box($meta_box);
        }
    }
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking Page template, categories, etc.
add_action('admin_init', 'imic_register_meta_boxes');
/* * ******************* META BOX CHECK ********************** */
/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function rw_maybe_include($template_file) {
    // Include in back-end only
    if (!defined('WP_ADMIN') || !WP_ADMIN)
        return false;
    // Always include for ajax
    if (defined('DOING_AJAX') && DOING_AJAX)
        return true;
    // Check for post IDs
    $checked_post_IDs = array();
    if (isset($_GET['post']))
        $post_id = $_GET['post'];
    elseif (isset($_POST['post_ID']))
        $post_id = $_POST['post_ID'];
    else
        $post_id = false;
    $post_id = (int) $post_id;
    if (in_array($post_id, $checked_post_IDs))
        return true;
    // Check for Page template
    $checked_templates = array($template_file);
    $template = get_post_meta($post_id, '_wp_page_template', true);
    if (in_array($template, $checked_templates))
        return true;
// If no condition matched
    return false;
}
?>