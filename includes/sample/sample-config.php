<?php
/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */
if (!class_exists('Redux_Framework_sample_config')) {
load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH . '/language');
    class Redux_Framework_sample_config {
        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;
        public function __construct() {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }
        }
        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();
            // Create the sections and fields
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**
          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.
         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!</h1>';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }
              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }
        /**
          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.
          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'imic-framework-admin'),
                'desc' => __('<p>Did you know that IMIC Framework sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$imic_options</strong></p>', 'imic-framework-admin'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**
          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;
            return $args;
        }
        /**
          Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = __('Testing filter hook!','framework');
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }
        public function setSections() {
            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();
            if (is_dir($sample_patterns_path)) :
                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();
                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {
                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;
            ob_start();
            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'imic-framework-admin'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>
                <h4><?php echo $this->theme->display('Name'); ?></h4>
                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'imic-framework-admin'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'imic-framework-admin'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'imic-framework-admin') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'imic-framework-admin'), $this->theme->parent()->display('Name'));
            }
            ?>
                </div>
            </div>
            <?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }
			load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH . '/language');
			$defaultLogo = get_template_directory_uri().'/images/logo.png';
			$defaultAdminLogo = get_template_directory_uri().'/images/logo@2x.png';
			$defaultBannerImages = get_template_directory_uri().'/images/page-header1.jpg';
			$defaultFavicon = '';
			$default_logo = get_template_directory_uri() . '/images/logo.png';
			$default_favicon = get_template_directory_uri() . '/images/favicon.ico';
            // ACTUAL DECLARATION OF SECTIONS
			$this->sections[] = array(
    'icon' => 'el-icon-cogs',
    'icon_class' => 'icon-large',
    'title' => __('General Settings', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'enable_maintenance',
            'type' => 'switch',
            'title' => __('Enable Maintenance', 'imic-framework-admin'),
            'subtitle' => __('Enable the themes in maintenance mode.', 'imic-framework-admin'),
            "default" => 0,
            'on' => __('Enabled', 'imic-framework-admin'),
            'off' => __('Disabled', 'imic-framework-admin'),
        ),
        array(
            'id' => 'switch-responsive',
            'type' => 'switch',
            'title' => __('Enable Responsive', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable the responsive behaviour of the theme', 'imic-framework-admin'),
            "default" => 1,
        ),
        array(
            'id' => 'enable_backtotop',
            'type' => 'switch',
            'title' => __('Enable Back To Top', 'imic-framework-admin'),
            'subtitle' => __('Enable the back to top button that appears in the bottom right corner of the screen.', 'imic-framework-admin'),
            "default" => 0,
        ),
        array(
            'id' => 'enable_rtl',
            'type' => 'switch',
            'title' => __('Enable RTL', 'imic-framework-admin'),
            'subtitle' => __('If you are using wordpress for RTL languages then you should enable this option.', 'imic-framework-admin'),
            "default" => 0,
        ),
        array(
            'id' => 'custom_favicon',
            'type' => 'media',
            'compiler' => 'true',
            'title' => __('Custom favicon', 'imic-framework-admin'),
            'desc' => __('Upload a image that will represent your website favicon', 'imic-framework-admin'),
            'default' => array('url' => $default_favicon),
        ),
       array(
            'id' => 'tracking-code',
            'type' => 'ace_editor',
            'title' => __('Tracking Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the header template of your theme. Please put code without opening and closing script tags.', 'imic-framework-admin'),
			'default' => '',
        ),
        array(
            'id' => 'custom_admin_login_logo',
            'type' => 'media',
            'url' => true,
            'title' => __('Custom admin login logo', 'imic-framework-admin'),
            'compiler' => 'true',
            //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
            'desc' => __('Upload a 254 x 95px image here to replace the admin login logo.', 'imic-framework-admin'),
            'subtitle' => __('', 'imic-framework-admin'),
            'default' => array('url' => $defaultAdminLogo),
        )
    )
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-up',
    'title' => __('Header Options', 'imic-framework-admin'),
    'desc' => __('<p class="description">These are the options for the header.</p>', 'imic-framework-admin'),
    'fields' => array(
		array(
            'id' => 'header_image',
            'type' => 'media',
            'url' => true,
            'title' => __('Header Image', 'imic-framework-admin'),
            'desc' => __('Default header image for post types.', 'imic-framework-admin'),
            'subtitle' => __('Set this image as default header image for all Page/Post/Event/Sermons/Gallery.', 'imic-framework-admin'),
            'default' => array('url' => ''),
        ),
		array(
			'id'=>'logo_type',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Logo Type', 'imic-framework-admin'), 
			'subtitle' => __('Select logo type', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Text Logo','imic-framework-admin'),
					'1' => __('Image Logo','imic-framework-admin')
				),
			'default' => '0',
			),
		array(
            'id' => 'logo_icon',
			'required' => array('logo_type','equals','0'),
            'type' => 'text',
            'title' => __('Font Icon', 'imic-framework-admin'),
            'subtitle' => __('Insert Font Icon code <a href="http://fontawesome.io/icons/">http://fontawesome.io/icons/</a>', 'imic-framework-admin'),
            'default' => 'fa-heart'
        ),
		array(
            'id' => 'logo_text',
			'required' => array('logo_type','equals','0'),
            'type' => 'text',
            'title' => __('Logo Text', 'imic-framework-admin'),
            'subtitle' => __('Enter logo text. Text inside span tags will be normal else will be bold font.', 'imic-framework-admin'),
            'default' => 'Adore<span>Church</span>'
        ),
        array(
            'id' => 'logo_upload',
			'required' => array('logo_type','equals','1'),
            'type' => 'media',
            'url' => true,
            'title' => __('Upload Logo', 'imic-framework-admin'),
            'desc' => __('Basic media uploader with disabled URL input field.', 'imic-framework-admin'),
            'subtitle' => __('Upload site logo to display in header. Keep it below 250px wide for best results.', 'imic-framework-admin'),
            'default' => array('url' => $default_logo),
        ),
        array(
            'id' => 'retina_logo_upload',
			'required' => array('logo_type','equals','1'),
            'type' => 'media',
            'url' => true,
            'title' => __('Upload Logo for Retina Devices', 'imic-framework-admin'),
            'desc' => __('Retina Display is a marketing term developed by Apple to refer to devices and monitors that have a resolution and pixel density so high – roughly 300 or more pixels per inch', 'imic-framework-admin'),
            'subtitle' => __('Upload site logo to display in header.', 'imic-framework-admin'),
            'default' => array('url' => $defaultAdminLogo),
        ),
		array(
            'id' => 'retina_logo_width',
            'type' => 'text',
            'title' => __('Standard Logo Width for Retina Logo', 'imic-framework-admin'),
            'subtitle' => __('If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width.', 'imic-framework-admin'),
            'default' => ''
        ),
		array(
            'id' => 'retina_logo_height',
            'type' => 'text',
            'title' => __('Standard Logo Height for Retina Logo', 'imic-framework-admin'),
            'subtitle' => __('If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height.', 'imic-framework-admin'),
            'default' => ''
        ),
		array(
            'id' => 'sticky_header_height',
            'type' => 'text',
            'title' => __('Header height when its stikcy (Widthout px) just put number', 'imic-framework-admin'),
            'subtitle' => __('The logo in sticky header will be of this height as well.', 'imic-framework-admin'),
            'default' => '60'
        ),
        array(
            'id' => 'enable-search',
            'type' => 'switch',
            'title' => __('Enable search with menu', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable search icon next to your main menu to open search form', 'imic-framework-admin'),
            "default" => 0,
        ),
        array(
            'id' => 'enable-cart',
            'type' => 'switch',
            'title' => __('Enable cart with menu', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable cart icon next to your main menu to open cart', 'imic-framework-admin'),
            "default" => 0,
        ),
		array(
    		'id' => 'header_layout',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Header Layout','imic-framework-admin'), 
			'subtitle' => __('Select the Header layout', 'imic-framework-admin'),
    			'options' => array(
					'header-style1' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style1.png'),
    				'header-style2' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style2.png'),
    				'header-style3' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style3.png'),
					'header-style4' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style4.png'),
    				'header-style5' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/headerLayout/header-style5.png'),
    				),
    		'default' => 'header-style1'
    	),
        array(
						'id' => 'header_social_links',
						'type' => 'sortable',
						'label' => true,
						'compiler'=>true,
						'title' => __('Social Links', 'imic-framework-admin'),
						'desc' => __('Enter the social links and sort to active and display according to sequence in header.', 'imic-framework-admin'),
						'options' => array(
										'fa-facebook' => 'facebook',
										'fa-twitter' => 'twitter',
										'fa-pinterest' => 'pinterest',
										'fa-google-plus' => 'google',
										'fa-youtube' => 'youtube',
										'fa-instagram' => 'instagram',
										'fa-vimeo-square' => 'vimeo',
										'fa-rss' => 'rss',
										'fa-dribbble' => 'dribbble',
										'fa-dropbox' => 'dropbox',
										'fa-bitbucket' => 'bitbucket',
										'fa-flickr' => 'flickr',
										'fa-foursquare' => 'foursquare',
										'fa-github' => 'github',
										'fa-gittip' => 'gittip',
										'fa-linkedin' => 'linkedin',
										'fa-pagelines' => 'pagelines',
										'fa-skype' => 'skype',
										'fa-tumblr' => 'tumblr'
							),
		
		),
	),
);
$this->sections[] = array(
    'icon' => 'el-icon-share',
    'title' => __('Share Options', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'switch_sharing',
            'type' => 'switch',
            'title' => __('Social Sharing', 'imic-framework-admin'),
            'subtitle' => __('Enable/Disable theme default social sharing buttons for posts/events/sermons single pages', 'imic-framework-admin'	
			),
            "default" => 1,
       		),
		 array(
			'id'=>'sharing_style',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Share Buttons Style', 'imic-framework-admin'), 
			'subtitle' => __('Choose the style of share button icons', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Rounded','imic-framework-admin'),
					'1' => __('Squared','imic-framework-admin')
				),
			'default' => '0',
			),
		 array(
			'id'=>'sharing_color',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Share Buttons Color', 'imic-framework-admin'), 
			'subtitle' => __('Choose the color scheme of the share button icons', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Brand Colors','imic-framework-admin'),
					'1' => __('Theme Color','imic-framework-admin'),
					'2' => __('GrayScale','imic-framework-admin')
				),
			'default' => '0',
			),
		array(
			'id'       => 'share_icon',
			'type'     => 'checkbox',
			'required' => array('switch_sharing','equals','1'),
			'title'    => __('Social share options', 'redux-framework-demo'),
			'subtitle' => __('Click on the buttons to disable/enable share buttons', 'redux-framework-demo'),
			'options'  => array(
				'1' => 'Facebook',
				'2' => 'Twitter',
				'3' => 'Google',
				'4' => 'Tumblr',
				'5' => 'Pinterest',
				'6' => 'Reddit',
				'7' => 'Linkedin',
				'8' => 'Email'
			),
			'default' => array(
				'1' => '1',
				'2' => '1',
				'3' => '1',
				'4' => '1',
				'5' => '1',
				'6' => '1',
				'7' => '1',
				'8' => '1'
			)
		),
		array(
			'id'       => 'share_post_types',
			'type'     => 'checkbox',
			'required' => array('switch_sharing','equals','1'),
			'title'    => __('Select share buttons for post types', 'imic-framework-admin'),
			'subtitle'     => __('Uncheck to disable for any type', 'imic-framework-admin'),
			'options'  => array(
				'1' => 'Posts',
				'2' => 'Pages',
				'3' => 'Events',
				'4' => 'Sermons',
			),
			'default' => array(
				'1' => '1',
				'2' => '1',
				'3' => '1',
				'4' => '1',
				'5' => '1'
			)
		)
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-down',
    'title' => __('Footer Options', 'imic-framework-admin'),
    'desc' => __('<p class="description">These are the options for the footer.</p>', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'site-rss',
            'type' => 'text',
			'required' => array('theme_color_types','equals','0'),
            'title' => __('Rss', 'imic-framework-admin'),
            'subtitle' => __('Rss URL to link your  Rss icon.', 'imic-framework-admin'),
            'desc' => __('Enter your Rss URL for you theme footer.', 'imic-framework-admin'),
            'default' => site_url().'/feed/',
        ),
        array(
            'id' => 'footer_copyright_text',
            'type' => 'text',
            'title' => __('Footer Copyright Text', 'imic-framework-admin'),
            'subtitle' => __(' Enter Copyright Text', 'imic-framework-admin'),
            'default' => __('All Rights Reserved', 'imic-framework-admin')
        ),
		array(
			'id'=>'footer_infobar',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Footer Info Bar', 'imic-framework-admin'), 
			'subtitle' => __('Enable/Disable Info bar in the footer just below the widgets.', 'imic-framework-admin'),
			'options' => array(
					'1' => __('Enable','imic-framework-admin'),
					'0' => __('Disable','imic-framework-admin')
				),
			'default' => '1',
		),
		array(
    		'id'               => 'website_info',
    		'type'             => 'editor',
			'required' => array('footer_infobar','equals','1'),
    		'title'            => __('Info bar content', 'imic-framework-admin'),
    		'subtitle'         => __('Insert static content or any shortcode for the Info Bar. If Social icons are enabled then it this area will be 3/4 of the full bar else will be full width.', 'imic-framework-admin'),
    		'default'          => '',
    		'args'   => array(
        	'teeny'            => false,
			'tinymce'		=> true,
        	'textarea_rows'    => 6
    		)
		),
		array(
			'id'=>'footer_social_switch',
			'type' => 'button_set',
			'required' => array('footer_infobar','equals','1'),
			'compiler'=>true,
			'title' => __('Footer Info Bar Social Icons', 'imic-framework-admin'), 
			'subtitle' => __('Enable/Disable Social Icons which displays in info bar.', 'imic-framework-admin'),
			'options' => array(
					'1' => __('Enable','imic-framework-admin'),
					'0' => __('Disable','imic-framework-admin')
				),
			'default' => '1',
		),
		array(
						'id' => 'footer_social_links',
						'required' => array('footer_infobar','equals','1'),
						'required' => array('footer_social_switch','equals','1'),
						'type' => 'sortable',
						'label' => true,
						'compiler'=>true,
						'title' => __('Social Links', 'imic-framework-admin'),
						'desc' => __('Insert Social URL in their respective fields and sort as your desired order.', 'imic-framework-admin'),
						'options' => array(
										'fa-facebook' => 'facebook',
										'fa-twitter' => 'twitter',
										'fa-pinterest' => 'pinterest',
										'fa-google-plus' => 'gplus',
										'fa-youtube' => 'youtube',
										'fa-instagram' => 'instagram',
										'fa-vimeo-square' => 'vimeo',
										'fa-rss' => 'rss',
										'fa-dribbble' => 'dribbble',
										'fa-dropbox' => 'dropbox',
										'fa-bitbucket' => 'bitbucket',
										'fa-flickr' => 'flickr',
										'fa-foursquare' => 'foursquare',
										'fa-github' => 'github',
										'fa-gittip' => 'gittip',
										'fa-linkedin' => 'linkedin',
										'fa-pagelines' => 'pagelines',
										'fa-skype' => 'skype',
										'fa-tumblr' => 'tumblr'
							),
					),
		array(
    		'id' => 'footer_layout',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Footer Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the footer layout', 'imic-framework'),
    			'options' => array(
					'12' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-1.png'),
    				'6' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-2.png'),
    				'4' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-3.png'),
    				'3' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-4.png'),
					'2' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerColumns/footer-5.png'),
    							),
    		'default' => '4'
    						),	
		array(
    		'id' => 'footer_skin',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Footer Style','imic-framework-admin'), 
			'subtitle' => __('Select the Footer style', 'imic-framework-admin'),
    			'options' => array(
					'' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerSkins/light.png'),
    				'footer-dark' => array('title' => '', 'img' => ReduxFramework::$_url.'assets/img/footerSkins/dark.png'),
    				),
    		'default' => ''
    						),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-check-empty',
    'title' => __('Layout Options', 'imic-framework-admin'),
    'fields' => array(
        array(
			'id'=>'site_width',
			'type' => 'text',
			'compiler'=>true,
			'title' => __('Site Width', 'imic-framework-admin'), 
			'subtitle' => __('Controls the overall site width. Without px, ex: 1040(Default). Recommended maximum width is 1170 to maintain the theme structure.', 'imic-framework-admin'),
			'default' => '1080px',
		),
        array(
			'id'=>'site_layout',
			'type' => 'image_select',
			'compiler'=>true,
			'title' => __('Page Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the page layout type', 'imic-framework-admin'),
			'options' => array(
					'wide' => array('alt' => 'Wide', 'img' => ReduxFramework::$_url.'assets/img/wide.png'),
					'boxed' => array('alt' => 'Boxed', 'img' => ReduxFramework::$_url.'assets/img/boxed.png')
				),
			'default' => 'wide',
			),
		array(
			'id'=>'repeatable-bg-image',
			'type' => 'image_select',
			'required' => array('site_layout','equals','boxed'),
			'title' => __('Repeatable Background Images', 'imic-framework-admin'), 
			'subtitle' => __('Select image to set in background.', 'imic-framework-admin'),
			'options' => array(
				'pt1.png' => array('alt' => 'pt1', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt1.png'),
				'pt2.png' => array('alt' => 'pt2', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt2.png'),
				'pt3.png' => array('alt' => 'pt3', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt3.png'),
				'pt4.png' => array('alt' => 'pt4', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt4.png'),
				'pt5.png' => array('alt' => 'pt5', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt5.png'),
				'pt6.png' => array('alt' => 'pt6', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt6.png'),
				'pt7.png' => array('alt' => 'pt7', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt7.png'),
				'pt8.png' => array('alt' => 'pt8', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt8.png'),
				'pt9.png' => array('alt' => 'pt9', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt9.png'),
				'pt10.png' => array('alt' => 'pt10', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt10.png'),
				'pt11.jpg' => array('alt' => 'pt11', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt11.png'),
				'pt12.jpg' => array('alt' => 'pt12', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt12.png'),
				'pt13.jpg' => array('alt' => 'pt13', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt13.png'),
				'pt14.jpg' => array('alt' => 'pt14', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt14.png'),
				'pt15.jpg' => array('alt' => 'pt15', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt15.png'),
				'pt16.png' => array('alt' => 'pt16', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt16.png'),
				'pt17.png' => array('alt' => 'pt17', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt17.png'),
				'pt18.png' => array('alt' => 'pt18', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt18.png'),
				'pt19.png' => array('alt' => 'pt19', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt19.png'),
				'pt20.png' => array('alt' => 'pt20', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt20.png'),
				'pt21.png' => array('alt' => 'pt21', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt21.png'),
				'pt22.png' => array('alt' => 'pt22', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt22.png'),
				'pt23.png' => array('alt' => 'pt23', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt23.png'),
				'pt24.png' => array('alt' => 'pt24', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt24.png'),
				'pt25.png' => array('alt' => 'pt25', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt25.png'),
				'pt26.png' => array('alt' => 'pt26', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt26.png'),
				'pt27.png' => array('alt' => 'pt27', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt27.png'),
				'pt28.png' => array('alt' => 'pt28', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt28.png'),
				'pt29.png' => array('alt' => 'pt29', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt29.png'),
				'pt30.png' => array('alt' => 'pt30', 'img' => ReduxFramework::$_url.'assets/img/patterns/pt30.png')
				)
			),	
		array(
			'id'=>'upload-repeatable-bg-image',
			'compiler'=>true,
			'required' => array('site_layout','equals','boxed'),
			'type' => 'media', 
			'url'=> true,
			'title' => __('Upload Repeatable Background Image', 'imic-framework-admin')
			),
		array(
			'id'=>'full-screen-bg-image',
			'compiler'=>true,
			'required' => array('site_layout','equals','boxed'),
			'type' => 'media', 
			'url'=> true,
			'title' => __('Upload Full Screen Background Image', 'imic-framework-admin')
			),	
		
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-lines',
    'title' => __('Sidebar Options', 'imic-framework-admin'),
    'fields' => array(
        array(
    		'id' => 'sidebar_position',
    		'type' => 'image_select',
    		'compiler'=>true,
			'title' => __('Sidebar position','imic-framework-admin'), 
			'subtitle' => __('Select the Global Sidebar Position. Can be overridden by page sidebar settings.', 'imic-framework-admin'),
    			'options' => array(
    				'2' => array('title' => 'Left', 'img' => ReduxFramework::$_url.'assets/img/2cl.png'),
					'1' => array('title' => 'Right', 'img' => ReduxFramework::$_url.'assets/img/2cr.png'),
    				),
    		'default' => '1'
    	),
		array(
			'id'       => 'author_sidebar',
			'type'     => 'select',
			'title'    => __('Author Page Sidebar', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar for author page.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'event_term_sidebar',
			'type'     => 'select',
			'title'    => __('Event Archive Sidebar', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar for archive page of Event.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'sermon_term_sidebar',
			'type'     => 'select',
			'title'    => __('Sermon Archive Sidebar', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar for archive page of Sermon.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'search_sidebar',
			'type'     => 'select',
			'title'    => __('Search Page Sidebar', 'imic-framework-admin'), 
			'desc'     => __('Select sidebar for search page.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
		array(
			'id'       => 'bbpress_sidebar',
			'type'     => 'select',
			'title'    => __('bbpress Sidebar', 'imic-framework-admin'), 
			'desc'     => __('Select default sidebar for all pages of bbpress including forums, topics, search.', 'imic-framework-admin'),
			'data'  => 'sidebars',
			'default'  => '',
		),
	),
);
$this->sections[] = array(
    'icon' => 'el-icon-brush',
    'title' => __('Color Options', 'imic-framework-admin'),
    'fields' => array(
		 array(
			'id'=>'theme_color_type',
			'type' => 'button_set',
			'compiler'=>true,
			'title' => __('Page Layout', 'imic-framework-admin'), 
			'subtitle' => __('Select the page layout type', 'imic-framework-admin'),
			'options' => array(
					'0' => __('Pre-Defined Color Schemes','imic-framework-admin'),
					'1' => __('Custom Color','imic-framework-admin')
				),
			'default' => '0',
			),
        array(
            'id' => 'theme_color_scheme',
            'type' => 'select',
			'required' => array('theme_color_type','equals','0'),
            'title' => __('Theme Color Scheme', 'imic-framework-admin'),
            'subtitle' => __('Select your themes alternative color scheme.', 'imic-framework-admin'),
            'options' => array('color1.css' => 'color1.css', 'color2.css' => 'color2.css', 'color3.css' => 'color3.css', 'color4.css' => 'color4.css', 'color5.css' => 'color5.css', 'color6.css' => 'color6.css', 'color7.css' => 'color7.css', 'color8.css' => 'color8.css', 'color9.css' => 'color9.css', 'color10.css' => 'color10.css','color11.css' => 'color11.css','color12.css' => 'color12.css'),
            'default' => 'color1.css',
        ),	
		array(
			'id'=>'primary_theme_color',
			'type' => 'color',
			'required' => array('theme_color_type','equals','1'),
			'title' => __('Primary Theme Color', 'imic-framework-admin'), 
			'subtitle' => __('Pick a primary color for the template.', 'imic-framework-admin'),
			'validate' => 'color',
			'transparent' => false,
			),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-brush',
    'title' => __('Styling', 'imic-framework-admin'),
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-up',
    'title' => __('Header', 'imic-framework-admin'),
    'subtitle' => __('Style elements of header including the logo area and navigations', 'imic-framework-admin'),
	'subsection' => true,
    'fields' => array(
        array(
			'id'=>'header_wide_width',
			'type' => 'checkbox',
			'compiler'=>true,
			'title' => __('100% Header Width', 'imic-framework-admin'), 
			'subtitle' => __('Check this box to set the header to 100% of the browser width. Uncheck to follow site width. Only works with wide layout mode. Not available for Header Style 5', 'imic-framework-admin'),
			'default' => '0',
		),
		array(  'id' => 'header_background_alpha',
				'type' => 'color_rgba',
				'output' => array('background-color' => '.site-header, .header-style2 .site-header, .header-style3 .site-header, .header-style4 .site-header, .header-style5 .site-header'),
				'title' => __('Header Background Color', 'imic-framework-demo'),
				'subtitle'=> __('<strong>Defaults:</strong><br>Header Style 1: none<br>Header Style 2: #ffffff<br>Header Style 3: rgba(255,255,255,.9)<br>Header Style 4: #ffffff<br>Header Style 5: #ffffff'),
				'options'       => array(
					'show_input'                => true,
					'show_initial'              => true,
					'show_alpha'                => true,
					'show_palette'              => false,
					'show_palette_only'         => false,
					'show_selection_palette'    => true,
					'max_palette_size'          => 10,
					'allow_empty'               => true,
					'clickout_fires_change'     => false,
					'choose_text'               => 'Choose',
					'cancel_text'               => 'Cancel',
					'show_buttons'              => true,
					'use_extended_classes'      => true,
					'palette'                   => null,  // show default
					'input_text'                => 'Select Color'
				),
				'default'   => array(),
		),
		array(  'id' => 'header_background_image',
				'type' => 'background',
				'background-color'=> false,
				'output' => array('.site-header, .header-style2 .site-header, .header-style3 .site-header, .header-style4 .site-header, .header-style5 .site-header'),
				'title' => __('Header Background Image', 'imic-framework-demo'),
				'subtitle'=> __('This will override the color style defined just above.'),
				'default'  => array(
				)
		),
		array(  'id' => 'sticky_header_background_alpha',
			'type' => 'color_rgba',
			'output' => array('background' => '.site-header.sticky-header, .header-style2 .site-header.sticky-header, .header-style3 .site-header.sticky-header, .header-style4 .site-header.sticky-header, .header-style5 .site-header.sticky-header'),
			'title' => __('Sticky Header Background', 'imic-framework-demo'),
			'subtitle'=> __('Default: rgba(255, 255, 255, 0.9)'),
			'desc' => __('You can put in opaque color here for sticky header.', 'imic-framework-demo'),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => true,
				'max_palette_size'          => 10,
				'allow_empty'               => true,
				'clickout_fires_change'     => false,
				'choose_text'               => 'Choose',
				'cancel_text'               => 'Cancel',
				'show_buttons'              => true,
				'use_extended_classes'      => true,
				'palette'                   => null,  // show default
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#ffffff',
				'alpha'     => .9
			),
		),
		array(  'id' => 'text_logo_color',
				'type' => 'color_rgba',
				'output' => array('color' => '.body .site-logo h1 a','border-color'=>'.body .site-logo .logo-icon'),
				'title' => __('Text Logo Color', 'imic-framework-demo'),
				'subtitle'=> __('Default: #ffffff'),
				'options'       => array(
					'show_input'                => true,
					'show_initial'              => true,
					'show_alpha'                => true,
					'show_palette'              => false,
					'show_palette_only'         => false,
					'show_selection_palette'    => true,
					'max_palette_size'          => 10,
					'allow_empty'               => true,
					'clickout_fires_change'     => false,
					'choose_text'               => 'Choose',
					'cancel_text'               => 'Cancel',
					'show_buttons'              => true,
					'use_extended_classes'      => true,
					'palette'                   => null,  // show default
					'input_text'                => 'Select Color'
				),
				'default'   => array(
					'color'     => '#ffffff',
					'alpha'     => 1
				),
		),
        array(
			'id'          => 'text_logo_typo',
			'type'        => 'typography',
			'title'       => __('Text Logo typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Bold<br>Font Size - 16px<br>Line Height - 30px<br>Letter Spacing - 0px<br>Color - #ffffff<br>Text transform - Uppercase', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => false,
			'font-weight' => false,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => false,
			'line-height' => false,
			'text-transform' => true,
			'letter-spacing' => true,
			'output'      => array('.site-logo h1 a'),
			'units'       =>'px',
			'default'     => array(
			),
		),
		array(  'id' => 'sticky_text_logo_color',
				'type' => 'color_rgba',
				'output' => array('color' => '.sticky-header .site-logo h1 a','border-color'=>'.sticky-header .site-logo .logo-icon'),
				'title' => __('Sticky Header Text Logo Color', 'imic-framework-demo'),
				'subtitle'=> __('Default: #222222'),
				'options'       => array(
					'show_input'                => true,
					'show_initial'              => true,
					'show_alpha'                => true,
					'show_palette'              => false,
					'show_palette_only'         => false,
					'show_selection_palette'    => true,
					'max_palette_size'          => 10,
					'allow_empty'               => true,
					'clickout_fires_change'     => false,
					'choose_text'               => 'Choose',
					'cancel_text'               => 'Cancel',
					'show_buttons'              => true,
					'use_extended_classes'      => true,
					'palette'                   => null,  // show default
					'input_text'                => 'Select Color'
				),
				'default'   => array(
					'color'     => '#222222',
					'alpha'     => 1
				),
		),
        array(
			'id'          => 'main_nav_typo',
			'type'        => 'typography',
			'title'       => __('Navigation Typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 12px<br>Letter Spacing - 2px<br>Text transform - Uppercase', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => false,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => false,
			'letter-spacing' => true,
			'text-transform'=> true,
			'output'      => array('.main-navigation > ul > li > a'),
			'units'       =>'px',
			'default'     => array(
			),
		),
		array(
			'id'       => 'main_nav_color',
			'type'     => 'link_color',
			'title'    => __('Navigation Link Color', 'imic-framework-demo'),
			'subtitle' => __('Default Regular: #222222<br>Hover: Your primary color<br>Active: Your primary color', 'imic-framework-demo'),
			'desc'     => __('Set the main navigation parent links color, hover, active.', 'imic-framework-demo'),
			'output'   => array('.body .main-navigation > ul > li > a'),
			'default'  => array(
			)
		),
		array(
			'id'       => 'sticky_main_nav_color',
			'type'     => 'link_color',
			'title'    => __('Sticky Header Navigation Link Color', 'imic-framework-demo'),
			'subtitle' => __('Default Regular: #222222<br>Hover: Your primary color<br>Active: Your primary color', 'imic-framework-demo'),
			'desc'     => __('Set the main navigation parent links color, hover, active.', 'imic-framework-demo'),
			'output'   => array('.body .sticky-header .main-navigation > ul > li > a'),
			'default'  => array(
			)
		),
		array(  'id' => 'main_dropdown_background_alpha',
			'type' => 'color_rgba',
			'output' => array('background-color' => '.main-navigation > ul > li ul','border-bottom-color' => '.main-navigation > ul > li ul:before','border-right-color' => '.main-navigation > ul > li ul li ul:before'),
			'title' => __('Navigation Dropdown Background', 'imic-framework-demo'),
			'subtitle'=> __('Default: #ffffff'),
			'options'       => array(
				'show_input'                => true,
				'show_initial'              => true,
				'show_alpha'                => true,
				'show_palette'              => false,
				'show_palette_only'         => false,
				'show_selection_palette'    => true,
				'max_palette_size'          => 10,
				'allow_empty'               => true,
				'clickout_fires_change'     => false,
				'choose_text'               => 'Choose',
				'cancel_text'               => 'Cancel',
				'show_buttons'              => true,
				'use_extended_classes'      => true,
				'palette'                   => null,  // show default
				'input_text'                => 'Select Color'
			),
			'default'   => array(
				'color'     => '#ffffff',
				'alpha'     => 1
			),
		),
		array(
			'id'       => 'main_dropdown_border',
			'type'     => 'border',
			'title'    => __('Navigation Dropdown Links Border Bottom', 'imic-framework-demo'),
			'subtitle' => __('Default: 1px solid #f8f7f3', 'imic-framework-demo'),
			'output'   => array('.main-navigation > ul > li > ul li > a'),
			'top' 	   => false,
			'left' 	   => false,
			'right' 	   => false,
			'default'  => array(
				'border-color'  => '#f8f7f3',
				'border-style'  => 'solid',
				'border-width' => '1px',
			)
		),
        array(
			'id'          => 'main_dropdown_typo',
			'type'        => 'typography',
			'title'       => __('Navigation Dropdown Typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 12px<br>Line Height - 20px<br>Letter Spacing - 1px<br>Text transform - none', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => false,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform'=> true,
			'letter-spacing' => true,
			'output'      => array('.main-navigation > ul > li > ul li > a'),
			'units'       =>'px',
			'default'     => array(
			),
		),
		array(
			'id'       => 'main_dropdown_link_color',
			'type'     => 'link_color',
			'title'    => __('Navigation Dropdown Link Color', 'imic-framework-demo'),
			'subtitle' => __('Default Regular: #222222<br>Hover: Your primary color<br>Active: Your primary color', 'imic-framework-demo'),
			'desc'     => __('Set the dropdown menu links color, hover, active.', 'imic-framework-demo'),
			'output'   => array('.main-navigation > ul > li > ul li > a'),
			'default'  => array(
			)
		),
        array(
			'id'          => 'megamenu_col_typo',
			'type'        => 'typography',
			'title'       => __('Megamenu Column Title Typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 14px<br>Line Height - 20px<br>Letter Spacing - 0<br>Text transform - Uppercase<br>Color - #999999', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform'=> true,
			'letter-spacing' => true,
			'output'      => array('.main-navigation .megamenu-container .megamenu-sub-title'),
			'units'       =>'px',
			'default'     => array(
			),
		),
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-check-empty',
    'title' => __('Body', 'imic-framework-admin'),
    'subtitle' => __('Style typography, color and other settings for body content', 'imic-framework-admin'),
	'subsection' => true,
    'fields' => array(
		array(
			'id'       => 'content_padding_dimensions',
			'type'     => 'spacing',
			'units'    => array('px'),
			'mode'	   => 'padding',
			'left'	   => false,
			'right'	   => false,
			'output'   => array('.content'),
			'title'    => __('Top and Bottom padding for page content', 'imic-framework-demo'),
			'subtitle' => __('Enter top and bottom padding for page content. Default is 50px/50px', 'imic-framework-demo'),
			'default'            => array(
			'padding-top'     => '50px',
			'padding-bottom'  => '50px',
			'units'          => 'px',
			),
		),
		array(
			'id'       => 'content_min_height',
			'type'     => 'text',
			'title'    => __('Minimum Height for Content', 'imic-framework-demo'),
			'subtitle' => __('Enter minimum height for the page content part(Without px). Default is 400', 'imic-framework-demo'),
			'default'  => '400px'
		),
		array(
			'id'       => 'body_link_color',
			'type'     => 'link_color',
			'title'    => __('Links Color for Body Content', 'imic-framework-demo'),
			'subtitle' => __('Default Regular: #555555<br>Hover: Your primary color<br>Active: Your primary color', 'imic-framework-demo'),
			'desc'     => __('Set the dropdown menu links color, hover, active.', 'imic-framework-demo'),
			'output'   => array('a'),
			'default'  => array(
			)
		),
        array(
			'id'          => 'body_font_typo',
			'type'        => 'typography',
			'title'       => __('Body text default typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 14px<br>Line Height - 20px<br>Letter Spacing - 0px<br>Color - #666666<br>Text transform - none', 'imic-framework-demo'),
			'desc'		  => __('This applies to only the parts of your website where the content from page editor comes in'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'letter-spacing' => true,
			'text-transform' => true,
			'output'      => array('body'),
			'units'       =>'px',
			'default'     => array(
			),
		),
        array(
			'id'          => 'body_h1_font_typo',
			'type'        => 'typography',
			'title'       => __('H1 heading typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 36px<br>Line Height - 42px<br>Letter Spacing - 0px<br>Color - #333333<br>Text transform - none', 'imic-framework-demo'),
			'desc'		  => __('This applies to only the parts of your website where the content from page editor comes in'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform' => true,
			'letter-spacing' => true,
			'output'      => array('h1'),
			'units'       =>'px',
			'default'     => array(
			),
		),
        array(
			'id'          => 'body_h2_font_typo',
			'type'        => 'typography',
			'title'       => __('H2 heading typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 30px<br>Line Height - 36px<br>Letter Spacing - 0px<br>Color - #333333<br>Text transform - none', 'imic-framework-demo'),
			'desc'		  => __('This applies to only the parts of your website where the content from page editor comes in'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform' => true,
			'letter-spacing' => true,
			'output'      => array('h2'),
			'units'       =>'px',
			'default'     => array(
			),
		),
        array(
			'id'          => 'body_h3_font_typo',
			'type'        => 'typography',
			'title'       => __('H3 heading typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 24px<br>Line Height - 30px<br>Letter Spacing - 0px<br>Color - #333333<br>Text transform - none', 'imic-framework-demo'),
			'desc'		  => __('This applies to only the parts of your website where the content from page editor comes in'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform' => true,
			'letter-spacing' => true,
			'output'      => array('h3'),
			'units'       =>'px',
			'default'     => array(
			),
		),
        array(
			'id'          => 'body_h4_font_typo',
			'type'        => 'typography',
			'title'       => __('H4 heading typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto Condensed<br>Font weight - Bold<br>Font Size - 16px<br>Line Height - 22px<br>Letter Spacing - 2px<br>Color - #333333<br>Text transform - Uppercase', 'imic-framework-demo'),
			'desc'		  => __('This applies to only the parts of your website where the content from page editor comes in'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform' => true,
			'letter-spacing' => true,
			'output'      => array('h4'),
			'units'       =>'px',
			'default'     => array(
			),
		),
        array(
			'id'          => 'body_h5_font_typo',
			'type'        => 'typography',
			'title'       => __('H5 heading typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Bold<br>Font Size - 16px<br>Line Height - 22px<br>Letter Spacing - 0px<br>Color - #333333<br>Text transform - none', 'imic-framework-demo'),
			'desc'		  => __('This applies to only the parts of your website where the content from page editor comes in'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform' => true,
			'letter-spacing' => true,
			'output'      => array('h5'),
			'units'       =>'px',
			'default'     => array(
			),
		),
        array(
			'id'          => 'body_h6_font_typo',
			'type'        => 'typography',
			'title'       => __('H6 heading typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 12px<br>Line Height - 18px<br>Letter Spacing - 0px<br>Color - #333333<br>Text transform - none', 'imic-framework-demo'),
			'desc'		  => __('This applies to only the parts of your website where the content from page editor comes in'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'text-transform' => true,
			'letter-spacing' => true,
			'output'      => array('h6'),
			'units'       =>'px',
			'default'     => array(
			),
		),
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-chevron-down',
    'title' => __('Footer', 'imic-framework-admin'),
    'subtitle' => __('Style elements of footer including the copyrights and widgets area', 'imic-framework-admin'),
	'subsection' => true,
    'fields' => array(
        array(
			'id'=>'footer_wide_width',
			'type' => 'checkbox',
			'compiler'=>true,
			'title' => __('100% Footer Width', 'imic-framework-admin'), 
			'subtitle' => __('Check this box to set the footer to 100% of the browser width. Uncheck to follow site width. Only works with wide layout mode.', 'imic-framework-admin'),
			'default' => '0',
		),
		array(  'id' => 'footer_background_alpha',
				'type' => 'background',
				'output' => array('.site-footer'),
				'title' => __('Footer Background', 'imic-framework-demo'),
				'subtitle'=> __('Default: #F8F8F8'),
				'default'  => array(
					'background-color' => '#F8F8F8',
				)
		),
		array(
			'id'=> 'footer_padding',
			'type'=> 'spacing',
			'output'=> array('.site-footer'),
			'mode' => 'padding',
			'left'=> false,
			'right'=> false,
			'units'=> array('px'),
			'title'=> __('Footer Padding', 'imic-framework-demo'),
			'desc'=> __('Enter Top and Bottom padding values for the footer area. Do not include px in the fields', 'imic-framework-demo'),
			'default'=> array(
				'padding-top'=> '40px',
				'padding-bottom'=> '40px',
				'units'=> 'px',
			)
		),
		array(
			'id'       => 'footer_border',
			'type'     => 'border',
			'title'    => __('Border Top for Footer', 'imic-framework-demo'),
			'subtitle' => __('Default: 1px solid #EFEFEF', 'imic-framework-demo'),
			'output'   => array('.site-footer'),
			'top' 	   => false,
			'left' 	   => false,
			'right' 	   => false,
			'default'  => array(
				'border-color'  => '#EFEFEF',
				'border-style'  => 'solid',
				'border-width' => '1px',
			)
		),
		array(
			'id' => 'infobox_background_alpha',
			'type' => 'background',
			'output' => array('.quick-info'),
			'title' => __('Background for Info Bar', 'imic-framework-demo'),
			'subtitle'=> __('Default: #FFFFFF'),
			'default'  => array(
				'background-color' => '#FFFFFF',
			)
		),
		array(
			'id'=> 'infobox_padding',
			'type'=> 'spacing',
			'output'=> array('.quick-info'),
			'mode' => 'padding',
			'units'=> array('px'),
			'title'=> __('Padding for Info Bar', 'imic-framework-demo'),
			'desc'=> __('Enter padding values for the footer Quick Info Bar. Do not include px in the fields', 'imic-framework-demo'),
			'default'=> array(
				'padding-top'=> '25px',
				'padding-bottom'=> '20px',
				'padding-left'=> '0px',
				'padding-right'=> '0px',
				'units'=> 'px',
			)
		),	
		array(
			'id'       => 'infobox_border',
			'type'     => 'border',
			'title'    => __('Border for Info Bar', 'imic-framework-demo'),
			'subtitle' => __('Default: 1px solid #E4E4E3', 'imic-framework-demo'),
			'output'   => array('.quick-info'),
			'default'  => array(
				'border-color'  => '#E4E4E3',
				'border-style'  => 'solid',
				'border-width' => '1px',
			)
		),
	)
);

$this->sections[] = array(
    'icon' => 'el-icon-check-empty',
    'title' => __('Sub Pages', 'imic-framework-admin'),
    'subtitle' => __('Style options of inside/sub pages of the website.', 'imic-framework-admin'),
	'subsection' => true,
    'fields' => array(
		array(
			'id'       => 'subpage_header_height',
			'type'     => 'text',
			'title'    => __('Minimum Height for Sub Pages Header', 'imic-framework-demo'),
			'subtitle' => __('Enter minimum height for the sub pages header part(Without px). This can be overridden by individual page header meta field value. Default is 250', 'imic-framework-demo'),
			'desc' => __('Nivo Slider, Revolution Slider, Layer Slider comes with their auto height as per the images you upload for their slides aor settings of the slider itself.'),
			'default'  => '250'
		),
        array(
			'id'          => 'subpage_header_typo',
			'type'        => 'typography',
			'title'       => __('Sub Pages Header typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Roboto<br>Font weight - Normal<br>Font Size - 44px<br>Line Height - 66px<br>Letter Spacing - 1px<br>Color - #ffffff<br>Text transform - Uppercase', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'letter-spacing' => true,
			'text-transform' => true,
			'output'      => array('.page-header h2'),
			'units'       =>'px',
			'default'     => array(
			),
		),
        array(
			'id'          => 'subpage_header_desc_typo',
			'type'        => 'typography',
			'title'       => __('Sub Pages Header Description typography', 'imic-framework-demo'),
			'subtitle'       => __('<strong>Defaults:</strong><br>Font Family - Volkhov<br>Font weight - Book<br>Font Size - 15px<br>Font Style - Italic<br>Line Height - 24px<br>Letter Spacing - px<br>Color - #ffffff<br>Text transform - None', 'imic-framework-demo'),
			'google'      => true,
			'font-backup' => true,
			'subsets' 	  => true,
			'color' 		  => true,
			'font-family' => true,
			'font-style'  => true,
			'font-weight' => true,
			'preview' 	  => true,
			'text-align'	  => false,
			'font-size'	  => true,
			'line-height' => true,
			'letter-spacing' => true,
			'text-transform' => true,
			'output'      => array('.page-header .subtitle'),
			'units'       =>'px',
			'default'     => array(
			),
		),
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-podcast',
    'title' => __('Podcast Options', 'imic-framework-admin'),
    'fields' => array(
		array(
            'id' => 'podcast_title',
            'type' => 'text',
            'title' => __('Podcast Title', 'imic-framework-admin'),
            'placeholder' => 'e.g. '. get_bloginfo('name').''
        ),
		array(
            'id' => 'podcast_description',
            'type' => 'text',
            'title' => __('Podcast Description', 'imic-framework-admin'),
            'placeholder' => 'e.g. '. get_bloginfo('description').''
        ),
		array(
            'id' => 'podcast_website_url',
            'type' => 'text',
            'title' => __('Website Link', 'imic-framework-admin'),
            'placeholder' => 'e.g. '. home_url().''
        ),
		array(
            'id' => 'podcast_language',
            'type' => 'text',
            'title' => __('Language', 'imic-framework-admin'),
            'placeholder' => 'e.g. '.get_bloginfo('language').''
        ),
		array(
            'id' => 'podcast_copyright',
            'type' => 'text',
            'title' => __('Copyright', 'imic-framework-admin'),
			'desc' => __('Copy "&copy;" to put a copyright symbol.'),
            'placeholder' => 'e.g. Copyright &copy; ' . get_bloginfo('name').''
        ),
		array(
            'id' => 'podcast_webmaster_name',
            'type' => 'text',
            'title' => __('Webmaster Name', 'imic-framework-admin'),
            'placeholder' => 'e.g. Your name'
        ),
		array(
            'id' => 'podcast_webmaster_email',
            'type' => 'text',
            'title' => __('Webmaster Email', 'imic-framework-admin'),
            'placeholder' => 'e.g. ' . get_bloginfo('admin_email').''
        ),
		array(
            'id' => 'podcast_itunes_author',
            'type' => 'text',
            'title' => __('Author', 'imic-framework-admin'),
			'desc' => __('This will display at the "Artist" in the iTunes Store.'),
            'placeholder' => 'e.g. Primary Speaker or Church Name'
        ),
		array(
            'id' => 'podcast_itunes_subtitle',
            'type' => 'text',
            'title' => __('Subtitle', 'imic-framework-admin'),
			'desc' => __('Your subtitle should briefly tell the listener what they can expect to hear.'),
            'placeholder' => 'e.g. Preaching and teaching audio from'
        ),
		array(
            'id' => 'podcast_itunes_summary',
            'type' => 'textarea',
            'title' => __('Summary', 'imic-framework-admin'),
			'desc' => __('Keep your Podcast Summary short, sweet and informative. Be sure to include a brief statement about your mission and in what region your audio content originates.'),
            'placeholder' => 'e.g. Weekly teaching audio brought to you by'
        ),
		array(
            'id' => 'podcast_itunes_owner_name',
            'type' => 'text',
            'title' => __('Owner Name', 'imic-framework-admin'),
			'desc' => __('This should typically be the name of your Church.'),
            'placeholder' => 'e.g. ' . get_bloginfo('name').''
        ),
		array(
            'id' => 'podcast_itunes_owner_email',
            'type' => 'text',
            'title' => __('Owner Email', 'imic-framework-admin'),
			'desc' => __('Use an email address that you dont mind being made public. If someone wants to contact you regarding your Podcast this is the address they will use.'),
            'placeholder' => 'e.g. ' . get_bloginfo('admin_email').''
        ),
		array(
            'id' => 'podcast_itunes_cover_image',
            'type' => 'media',
            'url' => true,
            'title' => __('Cover Image', 'imic-framework-admin'),
			'desc' => __('This JPG will serve as the Podcast artwork in the iTunes Store. The image should be 1400px by 1400px'),
            'default' => array('url' => ''),
        ),
		array(
            'id' => 'podcast_itunes_top_category',
            'type' => 'text',
            'title' => __('Top Category', 'imic-framework-admin'),
			'desc' => __('Choose the appropriate top-level category for your Podcast listing in iTunes. <a href="http://www.apple.com/itunes/podcasts/specs.html#submitting" target="_blank">Reference</a>'),
			'default' => 'Religion & Spirituality'
        ),
		array(
            'id' => 'podcast_itunes_sub_category',
            'type' => 'text',
            'title' => __('Sub Category', 'imic-framework-admin'),
			'desc' => __('Choose the appropriate sub category for your Podcast listing in iTunes. <a href="http://www.apple.com/itunes/podcasts/specs.html#submitting" target="_blank">Reference</a>'),
			'default' => 'Christianity'
        ),
		array(
            'id' => 'podcast_itunes_feed_url',
            'type' => 'text',
            'title' => __('Feed URL', 'imic-framework-admin'),
			'desc' => __('This is your Feed URL to submit to iTunes'),
			'default' => ''.home_url('/').'feed/?post_type=sermon',
			'readonly' => true
        ),
		array(
			'id'   => 'info_normal',
			'type' => 'info',
			'desc' => __('Use the <a href="http://www.feedvalidator.org/check.cgi?url='.home_url('/').'feed/?post_type=sermon" target="_blank">Feed Validator</a> to diagnose and fix any problems before submitting your Podcast to iTunes.
						<p>Once your Podcast Settings are complete and your Sermons are ready, its time to <a href="http://www.apple.com/itunes/podcasts/specs.html#submitting" target="_blank">Submit Your Podcast</a> to the iTunes Store!</p>
						<p>Alternatively, if you want to track your Podcast subscribers, simply pass the Podcast Feed URL above through <a href="http://feedburner.google.com/" target="_blank">FeedBurner</a>. FeedBurner will then give you a new URL to submit to iTunes instead.</p>
						<p>Please read the <a href="http://www.apple.com/itunes/podcasts/creatorfaq.html" target="_blank">iTunes FAQ for Podcast Makers</a> for more information.</p>')
		)
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-calendar',
    'title' => __('Events Options', 'imic-framework-admin'),
    'fields' => array(
		array(
            'id' => 'event_contact_msg',
            'type' => 'textarea',
            'title' => __('Event Contact Form Message', 'imic-framework-admin'),
            'subtitle' => __('Enter message for Event contact form footer.', 'imic-framework-admin'),
            'default' => ''
        ),
		array(
			'id'       => 'event_countdown_position',
			'type'     => 'select',
			'title'    => __('Show Event', 'imic-framework-admin'), 
			'desc'     => __('Show event until.', 'imic-framework-admin'),
			'options'  => array('0'=>'End Time','1'=>'Start Time'),
			'default'  => '0',
		),
		array(
			'id'       => 'event_time_view',
			'type'     => 'select',
			'title'    => __('Show Event Time', 'imic-framework-admin'), 
			'desc'     => __('Show event time.', 'imic-framework-admin'),
			'options'  => array('0'=>'Start - End Time','1'=>'Start Time'),
			'default'  => '0',
		),
	)
);
$this->sections[] = array(
    'icon' => 'el-icon-calendar',
    'title' => __('Calendar Options', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'calendar_month_name',
            'type' => 'textarea',	
			'rows' => 2,
            'title' => __('Calendar Month Name', 'imic-framework-admin'),
            'desc' => __('Insert month name in local language by comma seperated to display on event calender like: January,February,March,April,May,June,July,August,September,October,November,December', 'imic-framework-admin'),
			'default' => 'January,February,March,April,May,June,July,August,September,October,November,December',
        ),
		array(
            'id' => 'calendar_month_name_short',
            'type' => 'textarea',	
			'rows' => 2,
            'title' => __('Calendar Month Name Short', 'imic-framework-admin'),
            'desc' => __('Insert month name short in local language by comma seperated to display on event calender like: Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec', 'imic-framework-admin'),
			'default' => 'Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec',
        ),
		array(
            'id' => 'calendar_day_name',
            'type' => 'textarea',	
			'rows' => 2,
            'title' => __('Calendar Day Name', 'imic-framework-admin'),
            'desc' => __('Insert day name in local language by comma seperated to display on event calender like: Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday', 'imic-framework-admin'),
			'default' => 'Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
        ),
		array(
            'id' => 'calendar_day_name_short',
            'type' => 'textarea',
			'rows' => 2,	
            'title' => __('Calendar Day Name Short', 'imic-framework-admin'),
            'desc' => __('Insert day name short in local language by comma seperated to display on event calender like: Sun,Mon,Tue,Wed,Thu,Fri,Sat', 'imic-framework-admin'),
			'default' => 'Sun,Mon,Tue,Wed,Thu,Fri,Sat',
        ),
		array(
    'id'       => 'event_feeds',
    'type'     => 'checkbox',
    'title'    => __('Show WP Events', 'imic-framework-admin'),
    'desc'     => __('Check if you wants to show WP Events in Calendar.', 'imic-framework-admin'),
    'default'  => '1'// 1 = on | 0 = off
),
		/*array(
            'id' => 'google_feed',
            'type' => 'text',	
            'title' => __('Google Calendar Feed URL', 'imic-framework-admin'),
            'desc' => __('Enter Google Feed URL for google events in Calendar.', 'imic-framework-admin'),
			'default' => '',
        ),*/
		array(
            'id' => 'google_feed_key',
            'type' => 'text',	
            'title' => __('Google Calendar API Key', 'imic-framework-admin'),
            'desc' => __('Enter Google Calendar Feed API Key.', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
            'id' => 'google_feed_id',
            'type' => 'text',	
            'title' => __('Google Calendar ID', 'imic-framework-admin'),
            'desc' => __('Enter Google Calendar ID.', 'imic-framework-admin'),
			'default' => '',
        ),
		array(
			'id'=>'event_default_color',
			'type' => 'color',
			'title' => __('Event Color', 'imic-framework-admin'), 
			'subtitle' => __('Pick a default color for Events.', 'imic-framework-admin'),
			'validate' => 'color',
			'transparent' => false,
			'default' => ''
			),
			array(
			'id'=>'recurring_event_color',
			'type' => 'color',
			'title' => __('Recurring Event Color', 'imic-framework-admin'), 
			'subtitle' => __('Pick a color for recurring Events.', 'imic-framework-admin'),
			'validate' => 'color',
			'transparent' => false,
			'default' => ''
			),
    ),
);
$this->sections[] = array(
    'icon' => 'el-icon-edit',
    'title' => __('Custom CSS/JS', 'imic-framework-admin'),
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('CSS Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your CSS code here.', 'imic-framework-admin'),
            'mode' => 'css',
            'theme' => 'monokai',
            'desc' => '',
            'default' => "#header{\nmargin: 0 auto;\n}"
        ),
        array(
            'id' => 'custom_js',
            'type' => 'ace_editor',
            //'required' => array('layout','equals','1'),	
            'title' => __('JS Code', 'imic-framework-admin'),
            'subtitle' => __('Paste your JS code here.', 'imic-framework-admin'),
            'mode' => 'javascript',
            'theme' => 'chrome',
            'desc' => '',
            'default' => "jQuery(document).ready(function(){\n\n});"
        )
    ),
);
$this->sections[] = array(
                'title' => __('Import / Export', 'imic-framework-admin'),
                'desc' => __('Import and Export your Theme Framework settings from file, text or URL.', 'imic-framework-admin'),
                'icon' => 'el-icon-refresh',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                       'title' => __('Import Export','imic-framework-admin'),
                        'subtitle' => __('Save and restore your Theme options','imic-framework-admin'),
                        'full_width' => false,
                    ),
                ),
            ); 
                       if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'imic-framework-admin'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }
        public function setHelpTabs() {
            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'imic-framework-admin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'imic-framework-admin')
            );
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'imic-framework-admin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'imic-framework-admin')
            );
            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'imic-framework-admin');
        }
        /**
          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'imic_options',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'imic-framework-admin'),
                'page_title'        => __('IMIC Options', 'imic-framework-admin'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyDzJyslYLbuwBAqc_UTRokHKAY1ZaXrotk', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                
                // OPTIONAL -> Give you extra features
                'page_priority'     => '57',                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => false,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE
                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );
            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/imithemes',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://twitter.com/imithemes',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that we sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'imic-framework-admin'), $v);
            } else {
                //$this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'imic-framework-admin');
            }
            // Add content after the form.
            //$this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'imic-framework-admin');
        }
    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}
/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;
/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';
        /*
          do your validation
          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;