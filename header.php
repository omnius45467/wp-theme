<!DOCTYPE html>
<!--// OPEN HTML //-->
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <?php
        $options = get_option('imic_options');
        /** Theme layout design * */
        $bodyClass = ($options['site_layout'] == 'boxed') ? ' boxed' : '';
        $style='';
       if($options['site_layout'] == 'boxed'){
            if (!empty($options['upload-repeatable-bg-image']['id'])) {
            $style = ' style="background-image:url(' . $options['upload-repeatable-bg-image']['url'] . '); background-repeat:repeat; background-size:auto;"';
        } else if (!empty($options['full-screen-bg-image']['id'])) {
            $style = ' style="background-image:url(' . $options['full-screen-bg-image']['url'] . '); background-repeat: no-repeat; background-size:cover;"';
        }
           else if(!empty($options['repeatable-bg-image'])) {
            $style = ' style="background-image:url(' . get_template_directory_uri() . '/images/patterns/' . $options['repeatable-bg-image'] . '); background-repeat:repeat; background-size:auto;"';
        }
        }
        ?>
        <!--// SITE TITLE //-->
        <title>
            <?php wp_title('|', true, 'right'); ?>
<?php bloginfo('name'); ?>
        </title>
        <!--// SITE META //-->
        <meta charset="<?php bloginfo('charset'); ?>" />
        <!-- Mobile Specific Metas
        ================================================== -->
<?php if ($options['switch-responsive'] == 1) { ?>
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
            <meta name="format-detection" content="telephone=no"><?php } ?>
        <!--// PINGBACK & FAVICON //-->
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php if (isset($options['custom_favicon']) && $options['custom_favicon'] != "") { ?><link rel="shortcut icon" href="<?php echo $options['custom_favicon']['url']; ?>" /><?php
        }
        $offset = get_option('timezone_string');
		if($offset=='') { $offset = "Australia/Melbourne"; }
	date_default_timezone_set($offset);
	$header_style = $options['header_layout'];
	$footer_skin = $options['footer_skin'];
        ?>
        <!-- CSS
        ================================================== -->
        <!--[if lte IE 9]><link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" media="screen" /><![endif]-->
        <?php //  WORDPRESS HEAD HOOK 
         wp_head(); ?>
    </head>
    <!--// CLOSE HEAD //-->
    <body <?php body_class($bodyClass.' '.$header_style.' '.$footer_skin); echo $style;  ?>>
        <!--[if lt IE 7]>
	<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
<![endif]-->
<div class="body"> 
<?php $menu_locations = get_nav_menu_locations();
if($header_style=="header-style4") { ?>
<div class="topbar">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-6 col-sm-6">
                    <ul class="social-icons-colored">
                    <?php
					$socialSites = $options['header_social_links'];
                foreach ($socialSites as $key => $value) {
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
						$string = substr($key, 3);
                        echo '<li class="'.$string.'"><a href="' . esc_url($value) . '" target="_blank"><i class="fa ' . $key . '"></i></a></li>';
                    }
                } ?>
                    </ul>
                </div>
                <?php if (!empty($menu_locations['top-menu'])) { ?>
            	<div class="col-md-6 col-sm-6">
                	<?php wp_nav_menu(array('theme_location' => 'top-menu', 'container' => '','items_wrap' => '<ul id="%1$s" class="top-navigation">%3$s</ul>')); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php } ?>
	<!-- Start Site Header -->
	<header class="site-header">
    	<div class="container for-navi">
        	<div class="site-logo">
            <h1>
                <a href="<?php echo esc_url( home_url() ); ?>">
                <?php $logo_type = $options['logo_type'];
				if($logo_type==0) {
					$logo_icon = $options['logo_icon'];
					$logo_text = $options['logo_text'];
					echo '<div class="text-logo">';
					if($logo_icon!='') { 
                    echo '<span class="logo-icon"><i class="fa '.esc_attr($logo_icon).'"></i></span>'; }
                    if($logo_text!='') { 
					echo '<span class="logo-text">'.$logo_text.'</span>'; }
					echo '</div>';
              	}
				else {
					echo '<img src="' . esc_url($options['logo_upload']['url']) . '" alt="Logo" class="default-logo">';
					if (!empty($imic_options['retina_logo_upload']['url'])) {
						echo '<img src="' . esc_url($options['retina_logo_upload']['url']) . '" alt="Logo" class="retina-logo" width="' . $imic_options['retina_logo_width'] .'" height="' . $imic_options['retina_logo_height'] .'">';
					} else {
						echo '<img src="' . esc_url($options['logo_upload']['url']) . '" alt="Logo" class="retina-logo" width="' . $imic_options['retina_logo_width'] .'" height="' . $imic_options['retina_logo_height'] .'">';
					}
				}?>
                </a>
            </h1>
            </div>
            
                <?php if ($options['enable-search'] == 1) {
                    imic_search_button_header();
                } ?>
                <?php if ($options['enable-cart'] == 1) {
                   echo imic_cart_button_header();
                } ?>
            <!-- Main Navigation -->
            <?php if (!empty($menu_locations['primary-menu'])) {
						echo '<nav class="main-navigation" role="navigation">';
                    	wp_nav_menu(array('theme_location' => 'primary-menu', 'container' => '','items_wrap' => '<ul id="%1$s" class="sf-menu">%3$s</ul>', 'walker' => new imic_mega_menu_walker)); 
						echo '</nav>'; } ?>
            <a href="#" class="visible-sm visible-xs" id="menu-toggle"><i class="fa fa-bars"></i></a>
    	</div>
	</header>