<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/*
 *
 * 	imic Framework Theme Functions
 * 	------------------------------------------------
 * 	imic Framework v2.0
 * 	Copyright imic  2014 - http://www.imicreation.com/
 * 	imic_theme_activation()
 * 	imic_maintenance_mode()
 * 	imic_custom_login_logo()
 * 	imic_add_nofollow_cat()
 * 	imic_admin_bar_menu()
 * 	imic_admin_css()
 * 	imic_analytics()
 * 	imic_custom_styles()
 * 	imic_custom_script()
 * 	imic_content_filter()
 *	imic_register_sidebars()
 *	imic_event_grid()
 *	imic_event_time_columns()
 *	imic_afterSavePost()
 *	imic_get_cat_list()
 *	imic_widget_titles()
 *	imic_month_translate()
 *	imic_RevSliderShortCode()
 *	imic_query_arg()
 *	imicAddQueryVarsFilter()
 *	ImicConvertDate()
 *	imic_cat_count_flag()
 *	imic_recur_events()
 *	imic_custom_taxonomies_terms_links()
 *	imic_get_all_sidebars()
 *	imic_register_meta_box()
 *	imic_wp_get_attachment()
 * 	imic_gallery_flexslider()
 *	imic_social_staff_icon()
 *	imic_event_status_view()
 *	imic_video_embed()
 *	imic_video_youtube()
 *	imic_video_vimeo()
 *	imic_audio_soundcloud()
 *	imic_orderby_include()
 *	imic_share_buttons()
 *	imic_custom_excerpt_length()
 *	imic_contact_event_manager()
 *	imic_book_event_ticket()
 *	imic_get_event_details()
 *  imic_search_button_header
 *  imic_cart_button_header
 *	IMIC SIDEBAR POSITION
 * 	bbpress local host access
 *	
 */
/* THEME ACTIVATION
  ================================================== */
if (!function_exists('imic_theme_activation')) {
    function imic_theme_activation() {
        global $pagenow;
        if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
            #provide hook so themes can execute theme specific functions on activation
            do_action('imic_theme_activation');
          }
    }
    add_action('admin_init', 'imic_theme_activation');
}
/* MAINTENANCE MODE
  ================================================== */
if (!function_exists('imic_maintenance_mode')) {
    function imic_maintenance_mode() {
        $options = get_option('imic_options');
        $custom_logo = $custom_logo_output = $maintenance_mode = "";
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        $custom_logo_output = '<img src="' . $custom_logo['url'] . '" alt="maintenance" style="height: 62px!important;margin: 0 auto; display: block;" />';
        if (isset($options['enable_maintenance'])) {
            $maintenance_mode = $options['enable_maintenance'];
        } else {
            $maintenance_mode = false;
        }
        if ($maintenance_mode) {
            if (!current_user_can('edit_themes') || !is_user_logged_in()) {
                wp_die($custom_logo_output . '<p style="text-align:center">' . __('We are currently in maintenance mode, please check back shortly.', 'framework') . '</p>', __('Maintenance Mode', 'framework'));
            }
        }
    }
    add_action('get_header', 'imic_maintenance_mode');
}
/* CUSTOM LOGIN LOGO
  ================================================== */
if (!function_exists('imic_custom_login_logo')) {
    function imic_custom_login_logo() {
        $options = get_option('imic_options');
        $custom_logo = "";
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        echo '<style type="text/css">
			    .login h1 a { background-image:url(' . $custom_logo['url'] . ') !important; background-size: auto !important; width: auto !important; height: 95px !important; }
			</style>';
    }
    add_action('login_head', 'imic_custom_login_logo');
}
/* CATEGORY REL FIX
  ================================================== */
if (!function_exists('imic_add_nofollow_cat')) {
    function imic_add_nofollow_cat($text) {
        $text = str_replace('rel="category tag"', "", $text);
        return $text;
    }
    add_filter('the_category', 'imic_add_nofollow_cat');
}
/* CUSTOM ADMIN MENU ITEMS
  ================================================== */
if (!function_exists('imic_admin_bar_menu')) {
    function imic_admin_bar_menu() {
        global $wp_admin_bar;
        if (current_user_can('manage_options')) {
            $theme_customizer = array(
                'id' => '2',
                'title' => __('Color Customizer', 'framework'),
                'href' => admin_url('/customize.php'),
                'meta' => array('target' => 'blank')
            );
            $wp_admin_bar->add_menu($theme_customizer);
        }
    }
    add_action('admin_bar_menu', 'imic_admin_bar_menu', 99);
}
/* ADMIN CUSTOM POST TYPE ICONS
  ================================================== */
if (!function_exists('imic_admin_css')) {
    function imic_admin_css() {
        $mywp_version = get_bloginfo('version');
        if ($mywp_version < 3.8) {
            ?>
            <style type="text/css" media="screen">
                #menu-posts-event .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/portfolio.png) no-repeat 6px 7px!important;
                    background-size: 17px 15px;
                }
                #menu-posts-events:hover .wp-menu-image, #menu-posts-events.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/portfolio_rollover.png) no-repeat 6px 7px!important;
                }
                #menu-posts-staff .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/team.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-staff:hover .wp-menu-image, #menu-posts-staff.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/team_rollover.png) no-repeat 6px 11px!important;
                }
                #menu-posts-sermons .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/jobs.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-sermons:hover .wp-menu-image, #menu-posts-sermons.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/jobs_rollover.png) no-repeat 6px 11px!important;
                }
                #menu-posts-gallery .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/showcase.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-gallery:hover .wp-menu-image, #menu-posts-gallery.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/showcase_rollover.png) no-repeat 6px 11px!important;
                }
                #menu-posts-slide .wp-menu-image img {
                    width: 16px;
                }
                #toplevel_page_imic_theme_options .wp-menu-image img {
                    width: 11px;
                    margin-top: -2px;
                    margin-left: 3px;
                }
                .toplevel_page_imic_theme_options #adminmenu li#toplevel_page_imic_theme_options.wp-has-current-submenu a.wp-has-current-submenu, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow div, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow {
                    background: #222;
                    border-color: #222;
                }
                #wpbody-content {
                    min-height: 815px;
                }
                .wp-list-table th#thumbnail, .wp-list-table td.thumbnail {
                    width: 80px;
                }
                .wp-list-table td.thumbnail img {
                    max-width: 100%;
                    height: auto;
                }
            </style>
            <?php
        } else {
            ?>
            <style type="text/css" media="screen">
                .icon16.icon-post:before, #adminmenu #menu-posts-event div.wp-menu-image:before
                {
                    content: "\f337";
                }
                .icon16.icon-post:before, #adminmenu #menu-posts-sermons div.wp-menu-image:before
                {
                    content: "\f110";
                }
                .icon16.icon-post:before, #adminmenu #menu-posts-staff div.wp-menu-image:before
                {
                    content: "\f307";
                }
                .icon16.icon-post:before, #adminmenu #menu-posts-gallery div.wp-menu-image:before
                {
                    content: "\f161";
                }
                #menu-posts-slide .wp-menu-image img {
                    width: 16px;
                }
                #toplevel_page_imic_theme_options .wp-menu-image img {
                    width: 11px;
                    margin-top: -2px;
                    margin-left: 3px;
                }
                .toplevel_page_imic_theme_options #adminmenu li#toplevel_page_imic_theme_options.wp-has-current-submenu a.wp-has-current-submenu, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow div, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow {
                    background: #222;
                    border-color: #222;
                }
                #wpbody-content {
                    min-height: 815px;
                }
                .wp-list-table th#thumbnail, .wp-list-table td.thumbnail {
                    width: 80px;
                }
                .wp-list-table td.thumbnail img {
                    max-width: 100%;
                    height: auto;
                }
            </style>	
            <?php
        }
    }
    add_action('admin_head', 'imic_admin_css');
}
/* ----------------------------------------------------------------------------------- */
/* Show analytics code in footer */
/* ----------------------------------------------------------------------------------- */
if (!function_exists('imic_analytics')) {
    function imic_analytics() {
        $options = get_option('imic_options');
        if ($options['tracking-code'] != "") {
            echo '<script>';
            echo $options['tracking-code'];
            echo '</script>';
        }
    }
    add_action('wp_head', 'imic_analytics');
}
/* CUSTOM CSS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_styles')) {
    function imic_custom_styles() {
        $options = get_option('imic_options');
        $HeaderLogoHeight = $options['logo_upload']['height'];
        $NavLineHeight = $options['logo_upload']['height'] + 33;
        $DropDownLevel = $options['logo_upload']['height'] + 40;
        $StickyHeight = $options['sticky_header_height'];
        $StickyDropDownLevel = $options['sticky_header_height'] + 8;
        $LogoIcon = $options['sticky_header_height'] - 30;
        $LogoIconMar = $LogoIcon / 2;
        $StickyLogoHeight = $options['sticky_header_height'] -20;
		$logo_type = $options['logo_type'];
		if ($HeaderLogoHeight < $StickyLogoHeight){
			$StickyLogoHeight = $HeaderLogoHeight;
		}
        $HeaderHeight4 = $options['logo_upload']['height'] + 72;
        $PHeaderHeight = $NavLineHeight + 270;
		$headericonslink = $options['main_nav_color']['regular'];
		$headericonslinkhover = $options['main_nav_color']['hover'];
		$headericonslinkactive = $options['main_nav_color']['active'];
		$sheadericonslink = $options['sticky_main_nav_color']['regular'];
		$sheadericonslinkhover = $options['sticky_main_nav_color']['hover'];
		$sheadericonslinkactive = $options['sticky_main_nav_color']['active'];
        // OPEN STYLE TAG
        echo '<style type="text/css">' . "\n";
		if($logo_type==1) {
		echo '.site-logo img{height:'.esc_attr($HeaderLogoHeight).'px;}
		.site-header.sticky-header{height:'.esc_attr($StickyHeight).'px;}
		.site-header.sticky-header .site-logo img{height:'.esc_attr($StickyLogoHeight).'px;}
		.main-navigation > ul > li > a{line-height:'.esc_attr($NavLineHeight).'px;}
		.sticky-header .main-navigation > ul > li > a{line-height:'.esc_attr($StickyHeight).'px;}
		.search-module-opened, .cart-module-opened{top:'.esc_attr($NavLineHeight).'px;}
		.search-module-trigger, .cart-module-trigger{line-height:'.esc_attr($NavLineHeight).'px;}
		.sticky-header .search-module-trigger, .sticky-header .cart-module-trigger{line-height:'.esc_attr($StickyHeight).'px;}
		.header-style2 .body{padding-top:'.esc_attr($NavLineHeight).'px;}
		.header-style2 .main-navigation > ul > li ul, .header-style4 .main-navigation > ul > li ul, .header-style5 .main-navigation > ul > li ul{top:'.esc_attr($DropDownLevel).'px;}
		.header-style2 .sticky-header .main-navigation > ul > li ul, .header-style4 .sticky-header .main-navigation > ul > li ul, .header-style5 .sticky-header .main-navigation > ul > li ul{top:'.esc_attr($StickyDropDownLevel).'px;}
		.header-style4 .body{padding-top:'.esc_attr($HeaderHeight4).'px;}
		@media only screen and (max-width: 767px) {.header-style4 .body{padding-top:'.esc_attr($NavLineHeight).'px;}}
		#menu-toggle{line-height:'.esc_attr($NavLineHeight).'px;}
		.sticky-header #menu-toggle{line-height:'.esc_attr($StickyHeight).'px;}
		@media only screen and (max-width: 992px) {.main-navigation{top:'.esc_attr($NavLineHeight).'px;}.header-style4 .main-navigation{top:'.esc_attr($NavLineHeight).'px;}.sticky-header .main-navigation{top:'.esc_attr($StickyHeight).'px;}.header-style4 .sticky-header .main-navigation{top:'.esc_attr($StickyHeight).'px;}}
		@media only screen and (max-width: 767px) {.header-style5 .body{padding-top:'.esc_attr($NavLineHeight).'px;}}
		';
		}
		echo '
		.sticky-header .search-module-opened, .sticky-header .cart-module-opened{top:'.esc_attr($StickyHeight).'px;}
		.sticky-header .search-module-trigger, .sticky-header .cart-module-trigger{line-height:'.esc_attr($StickyHeight).'px;}
		.site-header.sticky-header{height:'.esc_attr($StickyHeight).'px;}
		.sticky-header .main-navigation > ul > li > a{line-height:'.esc_attr($StickyHeight).'px;}
		.sticky-header .site-logo .text-logo{margin-top:'.esc_attr($LogoIconMar).'px;}
		.header-style2 .sticky-header .main-navigation > ul > li ul, .header-style4 .sticky-header .main-navigation > ul > li ul, .header-style5 .sticky-header .main-navigation > ul > li ul{top:'.esc_attr($StickyDropDownLevel).'px;}
		.search-module-trigger, .cart-module-trigger{color:'.esc_attr($headericonslink).';}
		.search-module-trigger:hover, .cart-module-trigger:hover{color:'.esc_attr($headericonslinkhover).';}
		.search-module-trigger:active, .cart-module-trigger:active{color:'.esc_attr($headericonslinkactive).';}
		.sticky-header .search-module-trigger, .sticky-header .cart-module-trigger{color:'.esc_attr($sheadericonslink).';}
		.sticky-header .search-module-trigger:hover, .sticky-header .cart-module-trigger:hover{color:'.esc_attr($sheadericonslinkhover).';}
		.sticky-header .search-module-trigger:active, .sticky-header .cart-module-trigger:active{color:'.esc_attr($sheadericonslinkactive).';}
		@media only screen and (max-width: 767px) {.header-style3 .site-header{position:relative;} .header-style3 .body{padding-top:0; }}
		';
        // Custom CSS
        $custom_css = $options['custom_css'];
        if ($options['theme_color_type'][0] == 1) {
            $primaryColor = $options['primary_theme_color'];
            echo '.text-primary, .btn-primary .badge, .btn-link,a.list-group-item.active > .badge,.nav-pills > .active > a > .badge, p.drop-caps:first-child:first-letter, .accent-color, .posts-listing .post-time, h3.title .title-border i, .upcoming-events .event-cats a:hover, .nav-np .next:hover, .nav-np .prev:hover, .basic-link, .pagination > li > a:hover,.pagination > li > span:hover,.pagination > li > a:focus,.pagination > li > span:focus, .staff-item .meta-data, .flexslider .flex-prev:hover, .flexslider .flex-next:hover, .event-list-item:hover .action-buttons > li > a:hover, .accordion-heading:hover .accordion-toggle, .accordion-heading:hover .accordion-toggle.inactive, .accordion-heading:hover .accordion-toggle i, .smaller-cont .lined-info h4 a, .quick-info h4, .sort-source li.active a, .event-ticket h4, .event-ticket .ticket-ico, .tag-cloud a:hover, .main-navigation > ul > li > ul > li a:hover, .events-listing-content .event-title, .twitter-widget .date, .woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price{
	color:'.esc_attr($primaryColor).';
}
a:hover{
	color:'.esc_attr($primaryColor).';
}
a:hover{
	color:'.esc_attr($primaryColor).';
}
.basic-link:hover{
	opacity:.9
}
p.drop-caps.secondary:first-child:first-letter, .accent-bg, .fa.accent-color, .btn-primary,.btn-primary.disabled,.btn-primary[disabled],fieldset[disabled] .btn-primary,.btn-primary.disabled:hover,.btn-primary[disabled]:hover,fieldset[disabled] .btn-primary:hover,.btn-primary.disabled:focus,.btn-primary[disabled]:focus,fieldset[disabled] .btn-primary:focus,.btn-primary.disabled:active,.btn-primary[disabled]:active,fieldset[disabled] .btn-primary:active,.btn-primary.disabled.active,.btn-primary[disabled].active,fieldset[disabled] .btn-primary.active,.dropdown-menu > .active > a,.dropdown-menu > .active > a:hover,.dropdown-menu > .active > a:focus,.nav-pills > li.active > a,.nav-pills > li.active > a:hover,.nav-pills > li.active > a:focus,.pagination > .active > a,.pagination > .active > span,.pagination > .active > a:hover,.pagination > .active > span:hover,.pagination > .active > a:focus,.pagination > .active > span:focus,.label-primary,.progress-bar-primary,a.list-group-item.active,a.list-group-item.active:hover,a.list-group-item.active:focus, .accordion-heading .accordion-toggle.active, .accordion-heading:hover .accordion-toggle.active,.panel-primary > .panel-heading, .carousel-indicators .active, .flex-control-nav a:hover, .flex-control-nav a.flex-active, .flexslider .flex-control-nav a.background--dark.flex-active, .media-box .media-box-wrapper, .notice-bar, .featured-block figure, .media-box .zoom .icon, .media-box .expand .icon, .latest-sermon-content, .page-header, .icon-box.icon-box-style1:hover .ico, .event-page-cal, .fc-event, .sermon-media-left.sermon-links, .nav-tabs li a:active, .nav-tabs li.active a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .page-header-overlay, #bbpress-forums div.bbp-topic-tags a:hover, .bbp-search-form input[type="submit"]:hover, .bbp-topic-pagination .current{
  background-color: '.esc_attr($primaryColor).';
}
.btn-primary:hover,.btn-primary:focus,.btn-primary:active,.btn-primary.active,.open .dropdown-toggle.btn-primary, .top-menu li a:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce a.button.alt:active, .woocommerce button.button.alt:active, .woocommerce input.button.alt:active, .woocommerce #respond input#submit.alt:active, .woocommerce #content input.button.alt:active, .woocommerce-page a.button.alt:active, .woocommerce-page button.button.alt:active, .woocommerce-page input.button.alt:active, .woocommerce-page #respond input#submit.alt:active, .woocommerce-page #content input.button.alt:active, .wpcf7-form .wpcf7-submit{
  background: '.esc_attr($primaryColor).';
  opacity:.9
}
p.demo_store, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt, .woocommerce span.onsale, .woocommerce-page span.onsale, .wpcf7-form .wpcf7-submit, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_layered_nav ul li.chosen a, .woocommerce-page .widget_layered_nav ul li.chosen a, .ticket-cost{
	background: '.esc_attr($primaryColor).';
}
.nav .open > a,.nav .open > a:hover,.nav .open > a:focus,.pagination > .active > a,.pagination > .active > span,.pagination > .active > a:hover,.pagination > .active > span:hover,.pagination > .active > a:focus,.pagination > .active > span:focus,a.thumbnail:hover,a.thumbnail:focus,a.thumbnail.active,a.list-group-item.active,a.list-group-item.active:hover,a.list-group-item.active:focus,.panel-primary,.panel-primary > .panel-heading, .flexslider .flex-prev:hover, .flexslider .flex-next:hover, .btn-primary.btn-transparent, .counter .timer-col #days, .event-list-item:hover .event-list-item-date .event-date, .icon-box.icon-box-style1 .ico, .event-prog .timeline-stone, .event-ticket-left .ticket-handle, .bbp-topic-pagination .current{
	border-color:'.esc_attr($primaryColor).';
}
.panel-primary > .panel-heading + .panel-collapse .panel-body, #featured-events ul.slides, .woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message{
	border-top-color:'.esc_attr($primaryColor).';
}
.panel-primary > .panel-footer + .panel-collapse .panel-body, .nav-tabs li a:active, .nav-tabs li.active a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .title .title-border{
	border-bottom-color:'.esc_attr($primaryColor).';
}

/* Theme Options Styling */';
        }
		$site_width = $options['site_width'];
        $site_width=!empty($site_width)?$site_width:1080;
		$site_width_spaced=!empty($site_width)?$site_width+40:1120;
		$header_five_nav=!empty($site_width)?$site_width+70:1150;
		$header_five_lefter=$header_five_nav / 2;
		echo '@media (min-width:1200px){.container{width:'.$site_width.'px;}}
		body.boxed .body{max-width:'.$site_width_spaced.'px}
		@media (min-width: 1200px) {body.boxed .body .site-header, body.boxed .body .topbar{width:'.$site_width_spaced.'px;}}
		.header-style5 .site-header, .lead-content-wrapper{width:'.$header_five_nav.'px; margin-left: -'.$header_five_lefter.'px;}';
		if ($options['footer_wide_width'] == 1) {
			echo '.site-footer > .container{width:100%;}';
		}
		if (!$options['subpage_header_height'] == '' && !is_home() && !is_front_page()) {
			$subpage_hheight = $options['subpage_header_height'];
			echo '.page-header, .hero-slider.flexslider, .hero-slider.flexslider ul.slides li{height:'.$subpage_hheight.'px}';
		}
		if ($options['header_wide_width'] == 1) {
			echo '.header-style1 .container.for-navi, .header-style1 .topbar > .container, .header-style2 .container.for-navi, .header-style2 .topbar > .container, .header-style3 .container.for-navi, .header-style3 .topbar > .container, .header-style4 .container.for-navi, .header-style4 .topbar > .container{width:100%;}';
		}
		if ($options['sidebar_position'] == 2) {
			echo ' #content-col, #sidebar-col{float:right!important;}';
		}
		
        if ($custom_css) {
            echo "\n" . '/*========== User Custom CSS Styles ==========*/' . "\n";
            echo $custom_css;
        }
        // CLOSE STYLE TAG
        echo "</style>" . "\n";
    }
    add_action('wp_head', 'imic_custom_styles');
}
/* CUSTOM JS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_script')) {
    function imic_custom_script() {
        $options = get_option('imic_options');
        $custom_js = $options['custom_js'];
        if ($custom_js) {
            echo'<script type ="text/javascript">';
            echo $custom_js;
            echo '</script>';
        }
    }
    add_action('wp_footer', 'imic_custom_script');
}
/* SHORTCODE FIX
  ================================================== */
if (!function_exists('imic_content_filter')) {
    function imic_content_filter($content) {
        // array of custom shortcodes requiring the fix 
        $block = join("|", array("imic_button", "icon", "iconbox", "imic_image", "anchor", "paragraph", "divider", "heading", "alert", "blockquote", "dropcap", "code", "label", "container", "spacer", "span", "one_full", "one_half", "one_third", "one_fourth", "one_sixth","two_third", "progress_bar", "imic_count", "imic_tooltip", "imic_video", "htable", "thead", "tbody", "trow", "thcol", "tcol", "pricing_table", "pt_column", "pt_package", "pt_button", "pt_details", "pt_price", "list", "list_item", "list_item_dt", "list_item_dd", "accordions", "accgroup", "acchead", "accbody", "toggles", "togglegroup", "togglehead", "togglebody", "tabs", "tabh", "tab", "tabc", "tabrow", "section", "page_first", "page_last", "page", "modal_box", "imic_form", "fullcalendar", "staff","fullscreenvideo"));
        // opening tag
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
        // closing tag
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);
        return $rep;
    }
    add_filter("the_content", "imic_content_filter");
}
/* REGISTER SIDEBARS
  ================================================== */
if (!function_exists('imic_register_sidebars')) {
    function imic_register_sidebars() {
        if (function_exists('register_sidebar')) {
			$options = get_option('imic_options');
			$footer_class = $options["footer_layout"];
            register_sidebar(array(
                'name' => __('Home Page Sidebar', 'framework'),
                'id' => 'main-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Home Page Sidebar Second', 'framework'),
                'id' => 'main-sidebar-2',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Contact Sidebar', 'framework'),
                'id' => 'inner-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Page Sidebar', 'framework'),
                'id' => 'page-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Events Sidebar', 'framework'),
                'id' => 'events-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Post Sidebar', 'framework'),
                'id' => 'post-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
			register_sidebar(array(
                'name' => __('Product Sidebar', 'framework'),
                'id' => 'product-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Footer Widgets', 'framework'),
                'id' => 'footer-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="col-md-'.$footer_class.' col-sm-'.$footer_class.' widget footer-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="footer-widget-title">',
                'after_title' => '</h4>'
            ));
        }
    }
    add_action('init', 'imic_register_sidebars', 35);
}
/* EVENT GRID FUNCTION
  ================================================== */
if (!function_exists('imic_event_grid')) {
function imic_event_grid() {
	global $imic_options;
	$event_view = $imic_options['event_time_view'];
	$event_counter_view = $imic_options['event_countdown_position'];
	$offset = get_option('timezone_string');
	if($offset=='') { $offset = "Australia/Melbourne"; }
	date_default_timezone_set($offset);
    $output = '';
	$output1 = '';
    $currentEventTime = $_POST['date'];
	$EventTerm = $_POST['term'];
    $prev_month = date('Y-m', strtotime('-1 month', strtotime($currentEventTime)));
    $next_months = date('Y-m', strtotime('+1 month', strtotime($currentEventTime)));
	echo '<span class="month">'.esc_attr(date_i18n('M',strtotime($currentEventTime))).'</span><span class="year">'.esc_attr(date_i18n('Y',strtotime($currentEventTime))).'</span>';
	echo '<a href="javascript:void(0)" rel="'.$EventTerm.'" class="upcomingEvents actions left" id="'.$prev_month.'"><i class="fa fa-angle-left"></i></a><a href="javascript:void(0)" rel="'.$EventTerm.'" class="upcomingEvents actions right" id="'.$next_months.'"><i class="fa fa-angle-right"></i></a><div id="load-next-events" class="load-events" style="display:none;"><img src="'.IMIC_THEME_PATH.'/images/loader.gif"></div>~!';
	$events = imic_recur_events($EventTerm,'',$EventTerm,$currentEventTime);
	ksort($events);
	if(!empty($events)) { 
		foreach($events as $key=>$value):
		$date_converted=date('Y-m-d',$key );
        $custom_event_url= imic_query_arg($date_converted,$value);
		$start_time = '23:59';
		$start_time_meta = get_post_meta($value,'imic_event_start_dt',true);
		if($start_time_meta!='') {
		$start_time_meta = strtotime($start_time_meta);
		$start_time = date('G:i',$start_time_meta); }
		$st_time = '';
		$st_time = date('Y-m-d',$key);
		$st_time = strtotime($st_time.' '.$start_time);
		if($event_counter_view==0) 
		{
			$end_date_event = $key; 
		} 
		else 
		{ 
			$end_time_meta = get_post_meta($value,'imic_event_end_dt',true);
			$end_date_event = '';
			if($end_time_meta!='') 
			{
				$end_time_meta = strtotime($end_time_meta);
				$end_time = date('G:i',$end_time_meta); 
			}
			$en_time = '';
			$en_time = date('Y-m-d',$key);
			$end_date_event = strtotime($en_time.' '.$end_time);
		}
		$event_address = get_post_meta($value,'imic_event_address2',true);
		$term_slug = get_the_terms($value, 'event-category');
		echo '<li class=" event-list-item event-dynamic grid-item';
		if (!empty($term_slug)) {
			foreach ($term_slug as $term) {
				echo ' '.$term->slug;
			}
		} echo '">
        <div class="event-list-item-date">
       	<span class="event-date">
        <span class="event-day">'.esc_attr(date_i18n('d',$key)).'</span>
        <span class="event-month">'.esc_attr(date_i18n('M',$key)).', '. esc_attr(date_i18n('y',$key)).'</span>
      	</span>
		</div>
    	<div class="event-list-item-info">
      	<div class="lined-info">
    	<h4><a class="event-title" href="'.esc_url($custom_event_url).'" class="event-title">'.get_the_title($value).'</a></h4>
       	</div>
       	<div class="lined-info">';
		if($event_view==0) {
     	echo '<span class="meta-data"><i class="fa fa-clock-o"></i> '.esc_attr(date_i18n('l', $key)).', <span class="event-time">'. esc_attr(date_i18n(get_option('time_format'), $st_time)); if($end_date_event!='') { echo ' - '.date_i18n(get_option('time_format'), $end_date_event); } echo '</span> '; } else {
		echo '<span class="meta-data"><i class="fa fa-clock-o"></i> '.esc_attr(date_i18n('l', $key)).', <span class="event-time">'. esc_attr(date_i18n(get_option('time_format'), $st_time)); echo '</span> '; }
		if($key<date('U')) { echo '<span class="label label-default">'.__('Passed','framework').'</span>'; } elseif(date('U')>$st_time&&date('U')<$key) { echo '<span class="label label-success">'.__('Going On','framework').'</span>'; } else { echo '<span class="label label-primary">'.__('Upcoming','framework').'</span>'; }
       	echo '</div>';
		if($event_address!='') {
      	echo '<div class="lined-info event-location">
       	<span class="meta-data"><i class="fa fa-map-marker"></i> <span class="event-location-address">'.esc_attr($event_address).'</span></span>
      	</div>'; }
      	echo '</div>
       	<div class="event-list-item-actions">';
		if($key>date('U')) { $event_registration = get_post_meta($value,'imic_event_registration',true);
        $event_custom_url = get_post_meta($value,'imic_custom_event_registration',true);
		$event_custom_url_target = get_post_meta($value,'imic_custom_event_registration_target',true);
		
		$event_registration = get_post_meta($value,'imic_event_registration',true);
		if(!empty($event_custom_url)) {
			$target = ($event_custom_url_target==1)?'_blank':'';
			echo '<a href="'.$event_custom_url.'" class="btn btn-default btn-transparent" target="'.$target.'">'. __('Register','framework').' <i class="fa fa-sign-out"></i></a>';
		} elseif($event_registration==1) {
			echo '<a id="register-'.($value+2648).'|'.$key.'" href="#" class="btn btn-default btn-transparent event-tickets event-register-button">'. __('Register','framework').'</a>';
		}}
       	echo '<ul class="action-buttons">';
		if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') { 
       	echo '<li title="Share event"><a href="#" data-trigger="focus" data-placement="top" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li>';
		} $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { 
       	echo '<li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li>';
		} $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { 
      	echo '<li title="Contact event manager"><a id="contact-'.($value+2648).'|'.$key.'" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li>'; }
      	echo '</ul>
       	</div>
      	</li>';
   	endforeach; 
}
else {
echo '<li class=" event-list-item event-dynamic grid-item"><div class="event-list-item-info">
      	<div class="lined-info">'.__('Sorry, there are no events for this month.', 'framework') . '</div></div></li>';
}
    die();
}
add_action('wp_ajax_nopriv_imic_event_grid', 'imic_event_grid');
add_action('wp_ajax_imic_event_grid', 'imic_event_grid');
}
// get taxonomies terms links
if (!function_exists('imic_custom_taxonomies_terms_links')) {
    function imic_custom_taxonomies_terms_links($id) {
    global $post;
	$out = '';
    // get post by post id
    $post = get_post($id);
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
    foreach ($taxonomies as $taxonomy) {   
        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( !empty( $terms ) ) {
                foreach ( $terms as $term ){
                $out = $term->name;
        }
        }
    }
    return $out;
}
}
//Manage Custom Columns for Event Post Type 
if (!function_exists('imic_event_time_columns')) {
    add_filter('manage_edit-event_columns', 'imic_event_time_columns');
    function imic_event_time_columns($columns) {
        $columns['Event'] = __('Event', 'framework');
		//$columns['Recurring'] = __('Recurring', 'framework');
        return $columns;
    }
}
if (!function_exists('imic_event_time_column_content')) {
    add_action('manage_event_posts_custom_column', 'imic_event_time_column_content', 10, 2);
    function imic_event_time_column_content($column_name, $post_id) {
        switch ($column_name) {
            case 'Event':
                $sdate = get_post_meta($post_id, 'imic_event_start_dt', true);
                $stime = get_post_meta($post_id, 'imic_event_start_tm', true);
				$edate = get_post_meta($post_id, 'imic_event_end_dt', true);
                $etime = get_post_meta($post_id, 'imic_event_end_tm', true);
                echo '<abbr title="'.$sdate .' '.$stime.'">'.$sdate.'</abbr><br title="'.$edate.' '.$etime.'">'.$edate;
                break;
			case 'Recurring':
                $frequency = get_post_meta($post_id, 'imic_event_frequency', true);
				$frequency_count = get_post_meta($post_id, 'imic_event_frequency_count', true);
				if($frequency==1){ $sent = "Every Day"; }
				elseif($frequency==2){ $sent = "Every 2nd Day"; }
				elseif($frequency==3){ $sent = "Every 3rd Day"; }
				elseif($frequency==4){ $sent = "Every 4th Day"; }
				elseif($frequency==5){ $sent = "Every 5th Day"; }
				elseif($frequency==6){ $sent = "Every 6th Day"; }
				elseif($frequency==30){ $sent = "Every Month"; }
				else{ $sent = "Every week"; }
				if($frequency>0) {
                echo '<abbr title="'.$sent .' '.$sent.'">'.$sent.'</abbr><br>'.$frequency_count.' time';
				}
                break;
        }
    }
}
if (!function_exists('imic_sortable_event_column')) {
    add_filter('manage_edit-event_sortable_columns', 'imic_sortable_event_column');
    function imic_sortable_event_column($columns) {
        $columns['Event'] = 'event';
        return $columns;
    }
}
//Event Recurring Date/Time
function imic_afterSavePost()
{
	if(isset($_GET['post']))
	 { 
	 $postId = $_GET['post'];
	$post_type = get_post_type($postId);
	if($post_type=='event')
	{
		
		$sdate = get_post_meta($postId,'imic_event_start_dt',true);
		$end_event_date = get_post_meta($postId,'imic_event_end_dt',true);
		if($end_event_date=='') { update_post_meta($postId,'imic_event_end_dt',$sdate); }
		$frequency = get_post_meta($postId,'imic_event_frequency',true);
		$frequency_count = get_post_meta($postId,'imic_event_frequency_count',true);
		$value = strtotime($sdate);
		if($frequency==30) {
		$svalue = strtotime("+".$frequency_count." month", $value);
		$suvalue = date('Y-m-d',$svalue);
		}
		else {
		$svalue = $frequency*$frequency_count*86400;
		$suvalue = $svalue+$value;
		$suvalue = date('Y-m-d',$suvalue);
		}
		update_post_meta($postId,'imic_event_frequency_end',$suvalue);
	} 
	}
}
imic_afterSavePost();
//Add New Custom Menu Option
if ( !class_exists('IMIC_Custom_Nav')) {
class IMIC_Custom_Nav {
public function add_nav_menu_meta_boxes() {
   
add_meta_box(
'mega_nav_link',
__('Mega Menu','framework'),
array( $this, 'nav_menu_link'),
'nav-menus',
'side',
'low'
);
}
public function nav_menu_link() {
    
     global $_nav_menu_placeholder, $nav_menu_selected_id;
	$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
    
        ?>
<div id="posttype-wl-login" class="posttypediv">
<div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
<ul id ="wishlist-login-checklist" class="categorychecklist form-no-clear">
<li>
<label class="menu-item-title">
<input type="checkbox" class="menu-item-object-id" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object-id]" value="<?php echo $_nav_menu_placeholder; ?>"> <?php _e('Create Column','framework'); ?>
</label>
    <input type="hidden" class="menu-item-db-id" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-db-id]" value="0">
    <input type="hidden" class="menu-item-object" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object]" value="page">
<input type="hidden" class="menu-item-parent-id" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-parent-id]" value="0">
   <input type="hidden" class="menu-item-type" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" value="">
<input type="hidden" class="menu-item-title" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" value="<?php _e('Column','framework'); ?>">
<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-classes]" value="custom_mega_menu">
</li>
</ul>
</div>
<p class="button-controls">
<span class="add-to-menu">
<input type="submit" class="button-secondary submit-add-to-menu right" value="<?php _e('Add to Menu','framework'); ?>" name="add-post-type-menu-item" id="submit-posttype-wl-login">
<span class="spinner"></span>
</span>
</p>
</div>
<?php }
}
}
$custom_nav = new IMIC_Custom_Nav;
add_action('admin_init', array($custom_nav, 'add_nav_menu_meta_boxes'));
//Get All Post Types
if(!function_exists('imic_get_all_types')){
add_action( 'wp_loaded', 'imic_get_all_types');
function imic_get_all_types(){
   $args = array(
   'public'   => true,
   );
$output = 'names'; // names or objects, note names is the default
return $post_types = get_post_types($args, $output); 
}
}
/* -------------------------------------------------------------------------------------
  Get Cat List.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_get_cat_list')) {
    function imic_get_cat_list() {
        $amp_categories_obj = get_categories('exclude=1');
         
        $amp_categories = array();
        if(count($amp_categories_obj)>0){
        foreach ($amp_categories_obj as $amp_cat) {
            $amp_categories[$amp_cat->cat_ID] = $amp_cat->name;
        }}
        return $amp_categories;
    }
}
/* -------------------------------------------------------------------------------------
  Filter the Widget Title.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_widget_titles')) {
    add_filter('dynamic_sidebar_params', 'imic_widget_titles', 20);
    function imic_widget_titles(array $params) {
        // $params will ordinarily be an array of 2 elements, we're only interested in the first element
        $widget = & $params[0];
        $id = $params[0]['id'];
        if ($id == 'footer-sidebar') {
            $widget['before_title'] = '<h4 class="widgettitle">';
            $widget['after_title'] = '</h4>';
        } else {
            $widget['before_title'] = '<h3 class="widgettitle">';
            $widget['after_title'] = '</h3>';
        }
        return $params;
    }
}
/* -------------------------------------------------------------------------------------
  Filter the Widget Text.
  ----------------------------------------------------------------------------------- */
add_filter('widget_text', 'do_shortcode');
/* -------------------------------------------------------------------------------------
Month Translate in Default.
  ----------------------------------------------------------------------------------- */
    if(!function_exists('imic_month_translate')){
function imic_month_translate( $str ) {
  
	$options = get_option('imic_options');
       $months = $options["calendar_month_name"];
    $months = explode(',',$months);
  if(count($months)<=1){
  $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
}
$sb = array();
foreach($months as $month) { $sb[] = $month; } 
    $engMonth = array("January","February","March","April","May","June","July","August","September","October","November","December");
    $trMonth = $sb;
    $converted = str_replace($engMonth, $trMonth, $str);
    return $converted;
    }
    /* -------------------------------------------------------------------------------------
  Filter the  Month name of Post.
  ----------------------------------------------------------------------------------- */
add_filter( 'get_the_time', 'imic_month_translate' );
add_filter( 'the_date', 'imic_month_translate' );
add_filter( 'get_the_date', 'imic_month_translate' );
add_filter( 'comments_number', 'imic_month_translate' );
add_filter( 'get_comment_date', 'imic_month_translate' );
add_filter( 'get_comment_time', 'imic_month_translate' );
add_filter( 'date_i18n', 'imic_month_translate' );
}
/* -------------------------------------------------------------------------------------
  Short Month Translate in Default.
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_short_month_translate')){
function imic_short_month_translate( $str ) {
    
       $options = get_option('imic_options');
       $months = $options["calendar_month_name_short"];
    $months = explode(',',$months);
  if(count($months)<=1){
  $months = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
}
$sb = array();
foreach($months as $month) { $sb[] = $month; } 
    $engMonth = array("/\bJan\b/","/\bFeb\b/","/\bMar\b/","/\bApr\b/","/\bMay\b/","/\bJun\b/","/\bJul\b/","/\bAug\b/","/\bSep\b/","/\bOct\b/","/\bNov\b/","/\bDec\b/");
    $trMonth = $sb;
    $converted = preg_replace($engMonth, $trMonth, $str);
    return $converted;
}
/* -------------------------------------------------------------------------------------
  Filter the  Sort Month name of Post.
  ----------------------------------------------------------------------------------- */
add_filter( 'get_the_time', 'imic_short_month_translate' );
add_filter( 'the_date', 'imic_short_month_translate' );
add_filter( 'get_the_date', 'imic_short_month_translate' );
add_filter( 'comments_number', 'imic_short_month_translate' );
add_filter( 'get_comment_date', 'imic_short_month_translate' );
add_filter( 'get_comment_time', 'imic_short_month_translate' );
add_filter( 'date_i18n', 'imic_short_month_translate' );
}
 if(!function_exists('imic_day_translate')){
function imic_day_translate( $str ) {
	$options = get_option('imic_options');
       $days = $options["calendar_day_name"];
    $days = explode(',',$days);
  if(count($days)<=1){
  $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
}
$sb = array();
foreach($days as $month) { $sb[] = $month; } 
    $engDay = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
    $trDay = $sb;
    $converted = str_replace($engDay, $trDay, $str);
    return $converted;
    }
    /* -------------------------------------------------------------------------------------
  Filter the  Day name of Post.
  ----------------------------------------------------------------------------------- */
add_filter('date_i18n', 'imic_day_translate');
}
/* -------------------------------------------------------------------------------------
  RevSlider ShortCode
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_RevSliderShortCode')){
function imic_RevSliderShortCode(){
     $slidernames = array();
    if(class_exists('RevSlider')){
     $sld = new RevSlider();
                $sliders = $sld->getArrSliders();
        if(!empty($sliders)){
           
        foreach($sliders as $slider){
          $title=$slider->getParam('title','false');
           $shortcode=$slider->getParam('shortcode','false');
            $slidernames[$shortcode]=$title;
        }}
           
}
return $slidernames;
        }}
		
if(!function_exists('imic_layerslidershortcode')) {
	function imic_layerslidershortcode() {
		$layersliders = array();
		if(class_exists('LS_Sliders')){
		$filters = array('page' => 1, 'limit' => 100);
		// Find sliders
		$sliders = LS_Sliders::find($filters);
		if(!empty($sliders)) :
			foreach($sliders as $key => $item) :
				$name = !empty($item['slug']) ? $item['slug'] : $item['id'];
				$layersliders['[layerslider id=&quot;'.$name.'&quot;]']='[layerslider id=&quot;'.$name.'&quot;]';
			endforeach;
		endif;
		}
		return $layersliders;
	}
}
/** -------------------------------------------------------------------------------------
 * Add Query Arg
 * @param  ID,param1,param2 of current Post.
 * @return  Url with Query arg which is passed default is event_date.
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_query_arg')){
 function imic_query_arg($date_converted,$id){
        $custom_event_url=esc_url(add_query_arg('event_date',$date_converted,get_permalink($id)));
    return $custom_event_url;
  }
}
/** -------------------------------------------------------------------------------------
 * Query Var Filter
 * @description event_date parameter is added to query_vars filter
----------------------------------------------------------------------------------- */
if(!function_exists('imicAddQueryVarsFilter')){
function imicAddQueryVarsFilter( $vars ){
  $vars[] = "event_date";
  $vars[] = "event_cat";
  $vars[] = "pg";
  $vars[] = "speakers";
  return $vars;
}
add_filter('query_vars','imicAddQueryVarsFilter');
}
/** -------------------------------------------------------------------------------------
 * Convert the Format String from php to fullcalender
 * @see http://arshaw.com/fullcalendar/docs/utilities/formatDate/
 * @param $format
----------------------------------------------------------------------------------- */
if(!function_exists('ImicConvertDate')){
	 function ImicConvertDate($format) {
	 	$format_rules = array('a'=>'t',
			 'A'=>'T',
			 'B'=>'',
			 'c'=>'u',
			 'd'=>'dd',
			 'D'=>'ddd',
			 'F'=>'MMMM',
			 'g'=>'h',
			 'G'=>'H',
			 'h'=>'hh',
			 'H'=>'HH',
			 'i'=>'mm',
			 'I'=>'',
			 'j'=>'d',
			 'l'=>'dddd',
			 'L'=>'',
			 'm'=>'MM',
			 'M'=>'MMM',
			 'n'=>'M',
			 'O'=>'',
			 'r'=>'',
			 's'=>'ss',
			 'S'=>'S',
			 't'=>'',
			 'T'=>'',
			 'U'=>'',
			 'w'=>'',
			 'W'=>'',
			 'y'=>'yy',
			 'Y'=>'yyyy',
			 'z'=>'',
			 'Z'=>'');
	 	  $ret = '';
	 	for ($i=0; $i<strlen($format); $i++) {
	 		if (isset($format_rules[$format[$i]])) {
	 			$ret .= $format_rules[$format[$i]];
	 		} else {
	 			$ret .= $format[$i];
	 		}
	 	}
	 	return $ret;
}}
/** -------------------------------------------------------------------------------------
 * Return 0 if category have any post
 ----------------------------------------------------------------------------------- */
if(!function_exists('imic_cat_count_flag')){
function imic_cat_count_flag(){
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
             $flag=1;
              if(!empty($term)){
                 $flag= $output=($term->count==0)?0:1;
              }
             global $cat;
             if(!empty($cat)){
                  $cat_data= get_category($cat);
                $flag=($cat_data->count==0)?0:1;
             }
             return $flag;
}}
if (!function_exists('imic_dateDiff')) {
function imic_dateDiff($start, $end) {
  $start_ts = strtotime($start);
  $end_ts = strtotime($end);
  $diff = $end_ts - $start_ts;
  return round($diff / 86400);
}
}
//Event Global Function
if (!function_exists('imic_recur_events')) {
function imic_recur_events($status,$featured="nos",$term='',$month='') {
	global $imic_options;
	$show_event = (isset($imic_options['event_countdown_position']))?$imic_options['event_countdown_position']:'0';
	$offset = get_option('timezone_string');
		if($offset=='') { $offset = "Australia/Melbourne"; }
	date_default_timezone_set($offset);
$featured = ($featured=="yes")?"no":"nos";
$today = date('Y-m-d');
if($month!="") {
	$stop_date = $month;
	$curr_month = date('Y-m-t 23:59', strtotime('-1 month', strtotime($stop_date)));
	$current_end_date = date('Y-m-d H:i:s', strtotime($stop_date . ' + 1 day'));
	$previous_month_end = strtotime(date('Y-m-d 00:01', strtotime($stop_date)));
	$next_month_start = strtotime(date('Y-m-d 00:01', strtotime('+1 month', strtotime($stop_date))));
	query_posts(array('post_type' => 'event','event-category' => $term,'meta_key' => 'imic_event_start_dt','meta_query' => array('relation' => 'AND',array('key' => 'imic_event_frequency_end','value' => $curr_month,'compare' => '>'),array('key' => 'imic_event_start_dt','value' => date('Y-m-t 23:59', strtotime($stop_date)),'compare' => '<')),'orderby' => 'meta_value','order' => 'ASC','posts_per_page' => -1));
}
else {
if($status=='future') {
query_posts(array('post_type' => 'event', 'event-category'=>$term, 'meta_key' => 'imic_event_start_dt', 'meta_query' => array(array('key' => 'imic_event_frequency_end', 'value' => $today, 'compare' => '>='),array('key' => 'imic_featured_event', 'value' => $featured, 'compare' => '!=')), 'orderby' => 'meta_value', 'order' => 'ASC', 'posts_per_page' => -1)); }
else {
	query_posts(array('post_type' => 'event', 'event-category'=>$term, 'meta_key' => 'imic_event_start_dt', 'meta_query' => array(array('key' => 'imic_featured_event', 'value' => $featured, 'compare' => '!=')), 'orderby' => 'meta_value', 'order' => 'ASC', 'posts_per_page' => -1));
} }
					$event_add = array();
$sinc = 1;
if (have_posts()):
    while (have_posts()):the_post();
        $eventDate = get_post_meta(get_the_ID(), 'imic_event_start_dt', true);
        $frequency = get_post_meta(get_the_ID(), 'imic_event_frequency', true);
        $frequency_count = get_post_meta(get_the_ID(), 'imic_event_frequency_count', true);
		$frequency_active = get_post_meta(get_the_ID(),'imic_event_frequency_type',true);
		$frequency_type = get_post_meta(get_the_ID(),'imic_event_frequency_type',true);
		$frequency_month_day = get_post_meta(get_the_ID(),'imic_event_day_month',true);
		$frequency_week_day = get_post_meta(get_the_ID(),'imic_event_week_day',true);
        if ($frequency_active > 0) 
		{
            $frequency_count = $frequency_count;
        } 
		else 
		{ 
			$frequency_count = 0; 
		}
        $seconds = $frequency * 86400;
        $fr_repeat = 0;
        while ($fr_repeat <= $frequency_count) 
		{
            $eventDate = get_post_meta(get_the_ID(), 'imic_event_start_dt', true);
			$eventEndDate = get_post_meta(get_the_ID(),'imic_event_end_dt',true);
			$inc = '';
			$eventEndDate = strtotime($eventEndDate);
            $eventDate = strtotime($eventDate);
			$diff_start = date('Y-m-d',$eventDate);
			$diff_end = date('Y-m-d', $eventEndDate);
			$days_extra = imic_dateDiff($diff_start, $diff_end);
			if($days_extra>0) 
			{
				$start_day = 0;
				while($start_day<=$days_extra) 
				{
					$diff_sec = 86400*$start_day;
					$new_date = $eventDate+$diff_sec;
					$str_only_date = date('Y-m-d',$new_date);
					$en_only_time = date("G:i", $eventEndDate);
					$start_dt_tm = strtotime($str_only_date.' '.$en_only_time);
					if($start_dt_tm>date('U')) 
					{
						$eventDate = $new_date;
						break;
					}
					$start_day++;
				}
			}
			if($days_extra<1) 
			{
				if($frequency_type==1||$frequency_type==0) 
				{
					if($frequency==30) 
					{
						$eventDate = strtotime("+".$fr_repeat." month", $eventDate);
						$eventEndDate = strtotime("+".$fr_repeat." month", $eventEndDate);
					}
					else 
					{
						$new_date = $seconds * $fr_repeat;
            			$eventDate = $eventDate + $new_date;
						$eventEndDate = $eventEndDate + $new_date;
					}
				}
				else 
				{
					$eventTime = date('G:i',$eventDate);
					$eventDate = strtotime( date('Y-m-01',$eventDate) );
					if($fr_repeat==0) 
					{ 
						$fr_repeat = $fr_repeat+1; 
					}
					$eventDate = strtotime("+".$fr_repeat." month", $eventDate);
					$next_month = date('F',$eventDate);
					$next_event_year = date('Y',$eventDate);
					$eventDate = date('Y-m-d '.$eventTime, strtotime($frequency_month_day.' '.$frequency_week_day.' of '.$next_month.' '.$next_event_year));
					$eventDate = strtotime($eventDate);
					} 
				}
				$st_dt = date('Y-m-d',$eventDate);
				if($show_event==0) 
				{
					$en_tm = date("G:i",$eventEndDate);
				}
				else
				{
					$en_tm = date("G:i",$eventDate);
				}
				$dt_tm = strtotime($st_dt.' '.$en_tm);
				if($month!='') 
				{
					if(($dt_tm > $previous_month_end) && ($dt_tm < $next_month_start))
					{
						$event_add[$dt_tm + $sinc + $inc] = get_the_ID();
               			$sinc++;
					}
				}
				else 
				{
					if($status=="future") 
					{
            			if ($dt_tm >= date('U')) 
						{
                			$event_add[$dt_tm + $sinc + $inc] = get_the_ID();
                			$sinc++;
            			} 
					}
					else 
					{
						if ($dt_tm <= date('U')) 
						{
                			$event_add[$dt_tm + $sinc + $inc] = get_the_ID();
                			$sinc++;
            			} 	
					} 
				} 
				if($days_extra<1) 
				{ 
					$fr_repeat++; 
				} 
				else 
				{ 
					$fr_repeat = 1000000; 
				}
        	} 
    endwhile;
endif; wp_reset_query(); return $event_add; }
}
//Get all Sidebars
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
//Meta Box for Sidebar on all Posts/Page
if (!function_exists('imic_register_meta_box')) {
    add_action('admin_init', 'imic_register_meta_box');
    function imic_register_meta_box() {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_';
        $meta_box = array(
            'id' => 'template-sidebar1',
            'title' => __("Select Sidebar", 'framework'),
            'pages' => array('post', 'page', 'event', 'staff', 'product', 'sermon'),
            'context' => 'normal',
            'fields' => array(
                array(
                    'name' => 'Select Sidebar from list',
                    'id' => $prefix . 'select_sidebar_from_list',
                    'desc' => __("Select Sidebar from list, if using page builder then please add sidebar from element only.", 'framework'),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars(),
                ),
				array(
					'name' => __('Columns Layout', 'framework'),
					'id' => $prefix . 'sidebar_columns_layout',
					'desc' => __("Select Columns Layout .", 'framework'),
					'type' => 'select',
					'options' => array(
						'3' => __('One Fourth', 'framework'),
						'4' => __('One Third','framework'),
						'6' => __('Half','framework'),
							),
					'std' => 3,
				),
                array(
                    'name' => 'Select Sidebar Position',
                    'id' => $prefix . 'select_sidebar_position',
                    'desc' => __("Select Sidebar Postion", 'framework'),
                    'type' => 'radio',
                    'options' => array(
						'2' => 'Left',
						'1' => 'Right'
					),
					'default' => '1'
                ),
            )
        );
        new RW_Meta_Box($meta_box);
    }
}
//Attachment Meta Box
if(!function_exists('imic_attachment_url')){
function imic_attachment_url( $fields, $post ) {
$meta = get_post_meta($post->ID, 'meta_link', true);
$fields['meta_link'] = array(
'label' => __('Image URL','framework'),
'input' => 'text',
'value' => $meta,
'show_in_edit' => true,
);
return $fields;
}
add_filter( 'attachment_fields_to_edit', 'imic_attachment_url', 10, 2 );
}
/**
* Update custom field on save
*/
if(!function_exists('imic_update_attachment_url')){
function imic_update_attachment_url($attachment){
global $post;
update_post_meta($post->ID, 'meta_link', $attachment['attachments'][$post->ID]['meta_link']);
return $attachment;
}
add_filter( 'attachment_fields_to_save', 'imic_update_attachment_url', 4);
}
/**
* Update custom field via ajax
*/
if(!function_exists('imic_save_attachment_url')){
function imic_save_attachment_url() {
$post_id = $_POST['id'];
$meta = $_POST['attachments'][$post_id ]['meta_link'];
update_post_meta($post_id , 'meta_link', $meta);
clean_post_cache($post_id);
}
add_action('wp_ajax_save-attachment-compat', 'imic_save_attachment_url', 0, 1);
}
//Get Attachment details
if (!function_exists('imic_wp_get_attachment')) {
function imic_wp_get_attachment( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	if(!empty($attachment)) {
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title,
		'url' => $attachment->meta_link
	); }
} }
/** -------------------------------------------------------------------------------------
 * Gallery Flexslider
 * @param ID of current Post.
 * @return Div with flexslider parameter.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_gallery_flexslider')) {
    function imic_gallery_flexslider($id) {
		$speed = (get_post_meta(get_the_ID(), 'imic_gallery_slider_speed', true)!='')?get_post_meta(get_the_ID(), 'imic_gallery_slider_speed', true):5000;
        $pagination = get_post_meta(get_the_ID(), 'imic_gallery_slider_pagination', true);
        $auto_slide = get_post_meta(get_the_ID(), 'imic_gallery_slider_auto_slide', true);
        $direction = get_post_meta(get_the_ID(), 'imic_gallery_slider_direction_arrows', true);
        $effect = get_post_meta(get_the_ID(), 'imic_gallery_slider_effects', true);
        $pagination = !empty($pagination) ? $pagination : 'yes';
        $auto_slide = !empty($auto_slide) ? $auto_slide : 'yes';
        $direction = !empty($direction) ? $direction : 'yes';
        $effect = !empty($effect) ? $effect : 'slide';
        return '<div class="flexslider galleryflex" data-autoplay="' . $auto_slide . '" data-pagination="' . $pagination . '" data-arrows="' . $direction . '" data-style="' . $effect . '" data-pause="yes" data-speed='.$speed.'>';
    }
}
if (!function_exists('imic_social_staff_icon')) {
function imic_social_staff_icon() {
        $output = '';
        $staff_icons = get_post_meta(get_the_ID(), 'imic_social_icon_list', false);
        if (!empty($staff_icons[0]) || get_post_meta(get_the_ID(), 'imic_staff_member_email', true) != '') {
            $output.='<ul class="social-icons-colored">';
            if (!empty($staff_icons[0])) {
                foreach ($staff_icons[0] as $list => $values) {
                    if (!empty($values[1])) {
                        $className = preg_replace('/\s+/', '-', strtolower($values[0]));
                        $className = 'fa fa-' . $className;
                        $output.='<li class="'.$values[0].'"><a href="' . $values[1] . '" target ="_blank"><i class="' . $className . '"></i></a></li>';
                    }
                }
            }
            if (get_post_meta(get_the_ID(), 'imic_staff_member_email', true) != '') {
                $output.='<li class="email"><a href="mailto:' . get_post_meta(get_the_ID(), 'imic_staff_member_email', true) . '"><i class="fa fa-envelope"></i></a></li>';
            }
            $output.='</ul>';
        }
        return $output;
    }
}
//Event Status View Ajax Call
if (!function_exists('imic_event_status_view')) {
function imic_event_status_view() {
	global $imic_options;
	$event_view = $imic_options['event_time_view'];
	$event_counter_view = $imic_options['event_countdown_position'];
	$status = $_POST['status'];
	$status_number = explode("-",$status);
	$status = $status_number[0];
	$count = $status_number[1];
	$term = $_POST['term'];
	$offset = get_option('timezone_string');
	if($offset=='') { $offset = "Australia/Melbourne"; }
	date_default_timezone_set($offset);
if($status == "future") {
$events = imic_recur_events('future','',$term,''); 
echo '<span class="month">'.__('Events','framework').'</span><a href="javascript:" rel="'.$term.'" class="pastevents" id="past-'.$count.'"><span class="year">'.__('Past','framework').'</span></a><div id="load-next-events" class="load-events" style="display:none;"><img src="'. IMIC_THEME_PATH.'/images/loader.gif"></div>~!'; 
ksort($events); }
else {
$events = imic_recur_events('past','',$term,''); 
echo '<span class="month">'.__('Events','framework').'</span><a href="javascript:" rel="'.$term.'" class="pastevents" id="future-'.$count.'"><span class="year">'.__('Future','framework').'</span></a><div id="load-next-events" class="load-events" style="display:none;"><img src="'. IMIC_THEME_PATH.'/images/loader.gif"></div>~!'; 
krsort($events); }	
								if(!empty($events)) { 
								$total = 1;
								foreach($events as $key=>$value):
								$date_converted=date('Y-m-d',$key );
                				$custom_event_url= imic_query_arg($date_converted,$value);
								$start_time = '23:59';
								$start_time_meta = get_post_meta($value,'imic_event_start_dt',true);
								if($start_time_meta!='') {
								$start_time_meta = strtotime($start_time_meta);
								$start_time = date('G:i',$start_time_meta); }
								$st_time = '';
								$st_time = date('Y-m-d',$key);
								$st_time = strtotime($st_time.' '.$start_time);
								if($event_counter_view==0) 
								{
									$end_date_event = $key; 
								} 
								else 
								{ 
									$end_time_meta = get_post_meta($value,'imic_event_end_dt',true);
									$end_date_event = '';
									if($end_time_meta!='') {
									$end_time_meta = strtotime($end_time_meta);
									$end_time = date('G:i',$end_time_meta); }
									$en_time = '';
									$en_time = date('Y-m-d',$key);
									$end_date_event = strtotime($en_time.' '.$end_time);
								}
								$event_address = get_post_meta($value,'imic_event_address2',true);
								$term_slug = get_the_terms($value, 'event-category');
								echo '<li class=" event-list-item event-dynamic grid-item';
								if (!empty($term_slug)) {
								foreach ($term_slug as $term) {
								  echo ' '.$term->slug;
								}
								} echo '">
                                	<div class="event-list-item-date">
                                    	<span class="event-date">
                                        	<span class="event-day">'.esc_attr(date_i18n('d',$key)).'</span>
                                        	<span class="event-month">'.esc_attr(date_i18n('M',$key)).', '.  esc_attr(date_i18n('y',$key)).'</span>
                                        </span>
                                    </div>
                                    <div class="event-list-item-info">
                                    	<div class="lined-info">
                                        	<h4><a class="event-title" href="'.esc_url($custom_event_url).'" class="event-title">'.get_the_title($value).'</a></h4>
                                        </div>
                                    	<div class="lined-info">';
										if($event_view==0) { 
                                        	echo '<span class="meta-data"><i class="fa fa-clock-o"></i> '.esc_attr(date_i18n('l', $key)).', <span class="event-time">'. esc_attr(date_i18n(get_option('time_format'), $st_time)); if($end_date_event!='') { echo ' - '.date_i18n(get_option('time_format'), $end_date_event); } echo '</span> '; } else {
											echo '<span class="meta-data"><i class="fa fa-clock-o"></i> '.esc_attr(date_i18n('l', $key)).', <span class="event-time">'. esc_attr(date_i18n(get_option('time_format'), $st_time)); echo '</span> '; }		
											 if($key<date('U')) { echo '<span class="label label-default">'.__('Passed','framework').'</span>'; } elseif(date('U')>$st_time&&date('U')<$key) { echo '<span class="label label-success">'.__('Going On','framework').'</span>'; } else { echo '<span class="label label-primary">'.__('Upcoming','framework').'</span>'; }
       	echo '</div>';
											if($event_address!='') {
                                    	echo '<div class="lined-info event-location">
                                        	<span class="meta-data"><i class="fa fa-map-marker"></i> <span class="event-location-address">'.$event_address.'</span></span>
                                        </div>'; }
                                    echo '</div>
                                    <div class="event-list-item-actions">';
									if($key>date('U')) { $event_registration = get_post_meta($value,'imic_event_registration',true);
										$event_custom_url = get_post_meta($value,'imic_custom_event_registration',true);
										$event_custom_url_target = get_post_meta($value,'imic_custom_event_registration_target',true);
										
										$event_registration = get_post_meta($value,'imic_event_registration',true);
										if(!empty($event_custom_url)) {
											$target = ($event_custom_url_target==1)?'_blank':'';
											echo '<a href="'.$event_custom_url.'" class="btn btn-default btn-transparent" target="'.$target.'">'. __('Register','framework').' <i class="fa fa-sign-out"></i></a>';
										} elseif($event_registration==1) {
											echo '<a id="register-'.($value+2648).'|'.$key.'" href="#" class="btn btn-default btn-transparent event-tickets event-register-button">'. __('Register','framework').'</a>';
										}}
                                    	echo '<ul class="action-buttons">';
										if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') { 
                                        	echo '<li title="Share event"><a href="#" data-trigger="focus" data-placement="top" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li>';
											} $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { 
                                        	echo '<li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li>';
											} $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { 
                                        	echo '<li title="Contact event manager"><a id="contact-'.($value+2648).'|'.$key.'" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li>'; }
                                        echo '</ul>
                                    </div>
                                </li>';
                                if($total++>=$count) { break; } endforeach; }
								else {
echo '<li class=" event-list-item event-dynamic grid-item"><div class="event-list-item-info">
      	<div class="lined-info">'.__('Sorry, there are no past events.', 'framework') . '</div></div></li>';
}
					die();
}
add_action('wp_ajax_nopriv_imic_event_status_view', 'imic_event_status_view');
add_action('wp_ajax_imic_event_status_view', 'imic_event_status_view');
}
/* VIDEO EMBED FUNCTIONS
  ================================================== */
if (!function_exists('imic_video_embed')) {
    function imic_video_embed($url, $width = 500, $height = 300) {
        if (strpos($url, 'youtube') || strpos($url, 'youtu.be')) {
            return imic_video_youtube($url, $width, $height);
        } else {
            return imic_video_vimeo($url, $width, $height);
        }
    }
}
/* Video Youtube
  ================================================== */
if (!function_exists('imic_video_youtube')) {
    function imic_video_youtube($url, $width = 560, $height = 315) {
		if($url!='') {
        if (stristr($url,'youtu.be/'))
        { preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $video_id); return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[4] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>'; }
    else 
        { preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch\?v=|(.*?)&v=|v\/|e\/|.+\/|watch.*v=|)([a-z_A-Z0-9]{11})/i', $url, $video_id); return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[6] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>';
		} }
    }
}
/* Video Vimeo
  ================================================== */
if (!function_exists('imic_video_vimeo')) {
   function imic_video_vimeo($url, $width = 500, $height = 281) {
	   if($url!='') {
        preg_match('/https?:\/\/vimeo.com\/(\d+)$/', $url, $video_id);
        return '<iframe src="//player.vimeo.com/video/' . $video_id[1] . '?title=0&amp;byline=0&amp;autoplay=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" allowfullscreen></iframe>'; }
    }
}
/* Soundcloud Audio
====================================================== */
//Get the SoundCloud URL
if (!function_exists('imic_audio_soundcloud')) {
   function imic_audio_soundcloud($url, $width = "100%", $height = 450) {
$getValues=file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url.'&iframe=true');
$decodeiFrame=substr($getValues, 1, -2);
$jsonObj = json_decode($decodeiFrame);
return str_replace('height="400"', 'height="450"', $jsonObj->html);
   }
}
//
add_filter( 'get_terms_orderby', 'imic_orderby_include', 10, 2 );
function imic_orderby_include( $orderby, $args ) {
if ( isset( $args['orderby'] ) && 'include' == $args['orderby'] ) {
$include = implode(',', array_map( 'absint', $args['include'] ));
$orderby = "FIELD( t.term_id, $include )";
}
return $orderby;
}
 /**
 * IMIC SHARE BUTTONS
 */
if(!function_exists('imic_share_buttons')){
function imic_share_buttons(){
$posttitle = get_the_title();
$postpermalink = get_permalink();
$posttype = get_post_type(get_the_ID());
if ($posttype == 'event'){
	$date = get_query_var('event_date');
	if(empty($date)){
	   $date= get_post_meta(get_the_ID(),'imic_event_start_dt',true);
	}
	$date = strtotime($date);
	$date = date('Y-m-d',$date);
	$postpermalink = esc_url(imic_query_arg($date,get_the_ID()));
}
$postexcerpt = get_the_excerpt();
global $imic_options;
			
            echo '<div class="social-share-bar">';
			if($imic_options['sharing_style'] == '0'){
				if($imic_options['sharing_color'] == '0'){
					echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="social-icons-colored">';
				}elseif($imic_options['sharing_color'] == '1'){
					echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="social-icons-colored share-buttons-tc">';
				}elseif($imic_options['sharing_color'] == '2'){
					echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="social-icons-colored share-buttons-gs">';
				}
			} elseif($imic_options['sharing_style'] == '1'){
				if($imic_options['sharing_color'] == '0'){
					echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="social-icons-colored share-buttons-squared">';
				}elseif($imic_options['sharing_color'] == '1'){
					echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="social-icons-colored share-buttons-tc share-buttons-squared">';
				}elseif($imic_options['sharing_color'] == '2'){
					echo '<h4><i class="fa fa-share-alt"></i> '.__('Share','framework').'</h4>';
            		echo '<ul class="social-icons-colored share-buttons-gs share-buttons-squared">';
				}
			};
                	echo '<li class="share-title"></li>';
					if($imic_options['share_icon']['1'] == '1'){
                   		echo '<li class="facebook-share"><a href="https://www.facebook.com/sharer/sharer.php?u=' . $postpermalink . '&amp;t=' . $posttitle . '" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a></li>';
					}
					if($imic_options['share_icon']['2'] == '1'){
                     	echo '<li class="twitter-share"><a href="https://twitter.com/intent/tweet?source=' . $postpermalink . '&amp;text=' . $posttitle . ':' . $postpermalink . '" target="_blank" title="Tweet"><i class="fa fa-twitter"></i></a></li>';
					}
					if($imic_options['share_icon']['3'] == '1'){
                    echo '<li class="google-share"><a href="https://plus.google.com/share?url=' . $postpermalink . '" target="_blank" title="Share on Google+"><i class="fa fa-google-plus"></i></a></li>';
					}
					if($imic_options['share_icon']['4'] == '1'){
                    	echo '<li class="tumblr-share"><a href="http://www.tumblr.com/share?v=3&amp;u=' . $postpermalink . '&amp;t=' . $posttitle . '&amp;s=" target="_blank" title="Post to Tumblr"><i class="fa fa-tumblr"></i></a></li>';
					}
					if($imic_options['share_icon']['5'] == '1'){
                    	echo '<li class="pinterest-share"><a href="http://pinterest.com/pin/create/button/?url=' . $postpermalink . '&amp;description=' . $postexcerpt . '" target="_blank" title="Pin it"><i class="fa fa-pinterest"></i></a></li>';
					}
					if($imic_options['share_icon']['6'] == '1'){
                    	echo '<li class="reddit-share"><a href="http://www.reddit.com/submit?url=' . $postpermalink . '&amp;title=' . $posttitle . '" target="_blank" title="Submit to Reddit"><i class="fa fa-reddit"></i></a></li>';
					}
					if($imic_options['share_icon']['7'] == '1'){
                    	echo '<li class="linkedin-share"><a href="http://www.linkedin.com/shareArticle?mini=true&url=' . $postpermalink . '&amp;title=' . $posttitle . '&amp;summary=' . $postexcerpt . '&amp;source=' . $postpermalink . '" target="_blank" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a></li>';
					}
					if($imic_options['share_icon']['8'] == '1'){
                    	echo '<li class="email-share"><a href="mailto:?subject=' . $posttitle . '&amp;body=' . $postexcerpt . ':' . $postpermalink . '" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>';
					}
                echo '</ul>
            </div>';
	}
}
/*======================
Change Excerpt Length*/
if (!function_exists('imic_custom_excerpt_length')) {
function imic_custom_excerpt_length( $length ) {
	return 520;
}
add_filter( 'excerpt_length', 'imic_custom_excerpt_length', 999 );
}
//Contact Event Manager
if (!function_exists('imic_contact_event_manager')) {
function imic_contact_event_manager(){
	$event_id = $_POST['itemnumber'];
	$event_id = explode('-',$event_id);
	$event_id_dt = explode('|',$event_id[1]);
	$event_id = $event_id_dt[0];
	$event_id = $event_id-2648;
	$name = $_POST['name'];
	$lname = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	//$address = $_POST['address'];
	$notes = $_POST['notes'];
	$event_title = get_the_title($event_id);
	$event_manager_email = get_post_meta($event_id,'imic_event_manager',true);
	$manager_email = esc_attr($event_manager_email);
	$e_subject = __('Query for Event','framework');
	$e_body = __("You have been contacted by $name, for ","framework").$event_title. PHP_EOL . PHP_EOL;
	$body = __("Your message has been delivered to Event Manager for ","framework").$event_title. PHP_EOL . PHP_EOL;
$e_content = '';
$e_content .= __("Name: ","framework").$name.' '. $lname. PHP_EOL . PHP_EOL;
$e_content .= __("Email: ","framework").$email. PHP_EOL . PHP_EOL;
$e_content .= __("Phone: ","framework").$phone. PHP_EOL . PHP_EOL;
$e_content .= __("Notes: ","framework").$notes. PHP_EOL . PHP_EOL;
$e_reply = __("You can contact ","framework").$name.__(" via email, ","framework").$email;
$reply = __("You can contact manager via email, ","framework").$manager_email;
$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );
$user_msg = wordwrap( $body . $e_content . $reply, 70 );
$headers = __("From: ","framework").$email. PHP_EOL;
$headers .= __("Reply-To: ","framework").$email. PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
$user_headers = "From: $manager_email" . PHP_EOL;
$user_headers .= "Reply-To: $email" . PHP_EOL;
$user_headers .= "MIME-Version: 1.0" . PHP_EOL;
$user_headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$user_headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
if(mail($manager_email, $e_subject, $msg, $headers)&&mail($email, $e_subject, $user_msg, $user_headers)) {
	echo "<div class=\"alert alert-success\">Thank you <strong>$name</strong>, your message has been submitted to us.</div>";
} else {
	echo '<div class="alert alert-error">ERROR!</div>';
}
	die();
}
add_action('wp_ajax_nopriv_imic_contact_event_manager', 'imic_contact_event_manager');
add_action('wp_ajax_imic_contact_event_manager', 'imic_contact_event_manager');
}
//Book Event Ticket
if (!function_exists('imic_book_event_ticket')) {
function imic_book_event_ticket() {
	$event_id = $_POST['itemnumber'];
	$event_id = explode('-',$event_id);
	$event_id_dt = explode('|',$event_id[1]);
	$event_id = $event_id_dt[0];
	$event_dt = $event_id_dt[1];
	$event_dt = date(get_option('date_format'),$event_dt);
	$event_id = $event_id-2648;
	$date = $_POST['date'];
	$name = $_POST['name'];
	$lname = $_POST['lastname'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$members = $_POST['members'];
	$event_title = get_the_title($event_id);
	$reg_old = get_post_meta($event_id,'imic_reg_number',true);
	if(isset($reg_old)||!empty($reg_old)) {
		$reg_no = $reg_old+2648+$event_id;
		update_post_meta($event_id,'imic_reg_number',$reg_no); }
	$event_registration = get_post_meta($event_id,'imic_reg_number',true);
	$event_manager_email = get_post_meta($event_id,'imic_event_manager',true);
	$admin_email = ($event_manager_email!='')?$event_manager_email:get_option('admin_email');
	$e_subject = __('Registration for Event','framework');
$e_body = $name.__(" has been registered for ","framework").$event_title. PHP_EOL . PHP_EOL;
$body = __("You have been registered successfully for ","framework").$event_title. PHP_EOL . PHP_EOL;
$e_content = '';
$e_content .= __("Registration Number: ","framework").$event_registration. PHP_EOL . PHP_EOL;
$e_content .= __("Event: ","framework").$event_title. PHP_EOL . PHP_EOL;
$e_content .= __("Event Date: ","framework").$event_dt. PHP_EOL . PHP_EOL;
$e_content .= __("Name: ","framework").$name.' '. $lname. PHP_EOL . PHP_EOL;
$e_content .= __("Email: ","framework").$email. PHP_EOL . PHP_EOL;
$e_content .= __("Phone: ","framework").$phone. PHP_EOL . PHP_EOL;
$e_content .= __("Ticket Count: ","framework").$members. PHP_EOL . PHP_EOL;
$e_reply = __("You can contact ","framework").$name.__(" via email, ","framework").$email;
$reply = __("You can contact via email, ","framework").$admin_email;
$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );
$user_msg = wordwrap( $body . $e_content . $reply, 70 );
$headers = __("From: ","framework").$email. PHP_EOL;
$headers .= __("Reply-To: ","framework").$email. PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
$user_headers = "From: $admin_email" . PHP_EOL;
$user_headers .= "Reply-To: $email" . PHP_EOL;
$user_headers .= "MIME-Version: 1.0" . PHP_EOL;
$user_headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$user_headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
if(mail($admin_email, $e_subject, $msg, $headers)&&mail($email, $e_subject, $user_msg, $user_headers)) {
	echo $event_registration;
} else {
	echo 'ERROR!';
}
	die();
}
add_action('wp_ajax_nopriv_imic_book_event_ticket', 'imic_book_event_ticket');
add_action('wp_ajax_imic_book_event_ticket', 'imic_book_event_ticket');
}
//Event Preview function for Calendar
if (!function_exists('imic_get_event_details')) {
function imic_get_event_details() {
	global $imic_options;
	$offset = get_option('timezone_string');
	if($offset=='') { $offset = "Australia/Melbourne"; }
	date_default_timezone_set($offset);
	$id = $_POST['id'];
	$data = explode("|",$id);
	$id = $data[0];
	$key = $data[1];
	$output = '';
	$custom_event_url = '';
	//$key = '';
	$date_converted=date('Y-m-d',$key );
	$start_time = '23:59';
	$start_time_meta = get_post_meta($id,'imic_event_start_dt',true);
	if($start_time_meta!='') {
	$start_time_meta = strtotime($start_time_meta);
	$start_time = date('G:i',$start_time_meta); }
	$st_time = '';
	$st_time = date('Y-m-d',$key);
	$st_time = strtotime($st_time.' '.$start_time);
    $custom_event_url= imic_query_arg($date_converted,$id);
	$output .= '<ul class=" sort-destination events-ajax-caller">';
	$output .= '<li class="event-item event-dynamic">';
	$output .= '<div class="grid-item-inner">';
	$output .= '<div class="preview-event-bar">
                            <div id="counter" class="counter-preview top-header" data-date="'.$key.'">
                         		<div class="timer-col"> <span id="days"></span> <span class="timer-type">'.__('d','framework').'</span> </div>
                        		<div class="timer-col"> <span id="hours"></span> <span class="timer-type">'.__('h','framework').'</span> </div>
                      			<div class="timer-col"> <span id="minutes"></span> <span class="timer-type">'.__('m','framework').'</span> </div>
                         		<div class="timer-col"> <span id="seconds"></span> <span class="timer-type">'.__('s','framework').'</span> </div>
                            </div>
                        </div>';
	$event_address = get_post_meta($id,'imic_event_address2',true);
	
	if ( '' != get_the_post_thumbnail($id) ) { 
	$output .= '<a href="'.esc_url($custom_event_url).'" class="media-box">'.get_the_post_thumbnail($id,'full').'</a>'; }
	$output .= '<div id="load-preview-events" class="load-events" style="display:none;"><img src="'.IMIC_THEME_PATH.'/images/loader.gif"></div>';
	$output .= '<div class="grid-content">';
	$output .= '<h3><a class="event-title" href="'.esc_url($custom_event_url).'">'.get_the_title($id).'</a></h3>';
	$address1 = get_post_meta($id,'imic_event_address1',true);
	$address2 = get_post_meta($id,'imic_event_address2',true);
  	$output .= '<span class="meta-data"><i class="fa fa-calendar"></i> <span class="event-date">'.esc_attr(date_i18n(get_option('date_format'),$key)).'</span>'.__(' at ','framework').'<span class="event-time">'.date_i18n(get_option('time_format'), $st_time).'</span></span>';
	if($event_address!='') {
                                    $output .= '<span class="meta-data event-location-address"><i class="fa fa-map-marker"></i> '.$event_address.'</span>'; }
	$output .= '</div>';
	$output .= '<div class="grid-footer clearfix">';
	if($key>date('U')) { $event_registration = get_post_meta($value,'imic_event_registration',true);
        $event_custom_url = get_post_meta($value,'imic_custom_event_registration',true);
		$event_custom_url_target = get_post_meta($value,'imic_custom_event_registration_target',true);
		
		$event_registration = get_post_meta($value,'imic_event_registration',true);
		if(!empty($event_custom_url)) {
			$target = ($event_custom_url_target==1)?'_blank':'';
			echo '<a href="'.$event_custom_url.'" class="btn btn-default btn-transparent" target="'.$target.'">'. __('Register','framework').' <i class="fa fa-sign-out"></i></a>';
		} elseif($event_registration==1) {
			echo '<a id="register-'.($value+2648).'|'.$key.'" href="#" class="btn btn-default btn-transparent event-tickets event-register-button">'. __('Register','framework').'</a>';
	}}
 	$output .= '<ul class="action-buttons">';
	if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') {
  	$output .= '<li title="Share event"><a href="#" data-trigger="focus" data-placement="right" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li>'; } 
	$event_map = get_post_meta($id,'imic_event_address2',true); if($event_map!='') {
 	$output .= '<li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li>'; } 
	$event_contact_info = get_post_meta($id,'imic_event_manager',true); if($event_contact_info!='') {
   	$output .= '<li title="Contact event manager"><a id="contact-'.($id+2648).'|'.$key.'" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li>'; } 
  	$output .= '</ul></div>';
	
    $output .= '</div></div></li></ul>';
	echo $output;
	die();
}
add_action('wp_ajax_nopriv_imic_get_event_details', 'imic_get_event_details');
add_action('wp_ajax_imic_get_event_details', 'imic_get_event_details');
}

 /**
 * IMIC SEARCH BUTTON
 */
if(!function_exists('imic_search_button_header')){
function imic_search_button_header(){
global $imic_options;
			
            echo '<div class="search-module hidden-xs">
                	<a href="#" class="search-module-trigger"><i class="fa fa-search"></i></a>
                    <div class="search-module-opened">
                    	 <form method="get" id="searchform" action="' .home_url('/').'/">
                        	<div class="input-group input-group-sm">
                        		<input type="text" name="s" id="s" class="form-control">
                            	<span class="input-group-btn"><button name ="submit" type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
                       		</div>
                        </form>
                    </div>
                </div>';
	}
}
 /**
 * IMIC CART BUTTON
 */

if(!function_exists('imic_cart_button_header')){
function imic_cart_button_header(){
global $imic_options, $woocommerce;
			if(class_exists('Woocommerce')):
				if(!$woocommerce->cart->cart_contents_count): ?>
					<div class="cart-module hidden-xs">
						<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" class="cart-module-trigger"><i class="fa fa-shopping-cart"></i></a>
					</div>
				<?php else: ?>
				<div class="cart-module hidden-xs">
						<a href="#" class="cart-module-trigger" id="cart-module-trigger"><i class="fa fa-shopping-cart"></i><span class="cart-tquant"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'framework'), $woocommerce->cart->cart_contents_count);?></span></a>
						<div class="cart-module-opened">
							<ul class="cart-module-items">
                            	<?php
									$count = 1;
								 foreach($woocommerce->cart->cart_contents as $cart_item): ?>
                                    <li>
                                        <a href="<?php echo get_permalink($cart_item['product_id']); ?>">
                                        <?php $thumbnail_id = ($cart_item['variation_id']) ? $cart_item['variation_id'] : $cart_item['product_id']; ?>				
                                        <?php echo get_the_post_thumbnail($thumbnail_id, 'theme-small-thumb'); ?>
                                        <span class="cart-module-item-name"><?php echo $cart_item['data']->post->post_title; ?></span>
                                        <span class="cart-module-item-quantity"><?php echo $cart_item['quantity']; ?> x <?php echo $woocommerce->cart->get_product_subtotal($cart_item['data'], 1); ?></span>
                                        </a>
                                    </li>
                                <?php if ($count++ > 2){break;}  endforeach; ?>
							</ul>
							<div class="cart-module-footer">
								<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id')); ?>" class="basic-link"><i class="fa fa-long-arrow-left"></i> <?php _e('View full cart', 'framework'); ?></a>
								<a href="<?php echo get_permalink(get_option('woocommerce_checkout_page_id')); ?>" class="basic-link"><?php _e('Checkout', 'framework'); ?> <i class="fa fa-long-arrow-right"></i></a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endif;
	}
}
/**
 * IMIC SIDEBAR POSITION
*/
if(!function_exists('imic_sidebar_position_module')){
	function imic_sidebar_position_module(){
		$sidebar_position = get_post_meta(get_the_ID(),'imic_select_sidebar_position',true);
		if($sidebar_position == 2){
		echo ' <style type="text/css">#content-col, #sidebar-col{float:right!important;}</style>';	
		} elseif($sidebar_position == 1){
		echo ' <style type="text/css">#content-col, #sidebar-col{float:left!important;}</style>';	
		}
	}
}
//bbpress LocalHost Access
/* add_filter( 'bbp_verify_nonce_request_url', 'my_bbp_verify_nonce_request_url', 999, 1 );
function my_bbp_verify_nonce_request_url( $requested_url )
{
    return 'http://localhost:8888' . $_SERVER['REQUEST_URI'];
} */
/* GET TEMPLATE URL
   ================================================*/
if(!function_exists('imic_get_template_url')) {
function imic_get_template_url($TEMPLATE_NAME){
  $url;
 $pages = query_posts(array(
     'post_type' =>'page',
     'meta_key'  =>'_wp_page_template',
     'meta_value'=> $TEMPLATE_NAME
 ));
 $url = null;
 if(isset($pages[0])) {
     $url = get_page_link($pages[0]->ID);
 }
 wp_reset_query();
 return $url;
}
}
?>