<?php
/*
Template Name: Event
*/
get_header();
imic_sidebar_position_module();
global $imic_options;
$event_view = $imic_options['event_time_view'];
$event_counter_view = $imic_options['event_countdown_position'];
$facebook = $imic_options['share_icon'][1];
$twitter = $imic_options['share_icon'][2];
$google = $imic_options['share_icon'][3];
$tumblr = $imic_options['share_icon'][4];
$pinterest = $imic_options['share_icon'][5];
$reddit = $imic_options['share_icon'][6];
$linkedin = $imic_options['share_icon'][7];
$email_share = $imic_options['share_icon'][8];
wp_enqueue_script('event_ajax', IMIC_THEME_PATH . '/js/event_ajax.js', '', '', true);
wp_localize_script('event_ajax', 'urlajax', array('ajaxurl' => admin_url('admin-ajax.php'),'facebook'=>$facebook,'twitter'=>$twitter,'google'=>$google,'tumblr'=>$tumblr,'pinterest'=>$pinterest,'reddit'=>$reddit,'linkedin'=>$linkedin,'email'=>$email_share));
if(is_home()) { $id = get_option('page_for_posts'); }
else { $id = get_the_ID(); }
$page_header = get_post_meta($id,'imic_pages_Choose_slider_display',true);
if($page_header==3) {
	get_template_part( 'pages', 'flex' );
}
elseif($page_header==4) {
	get_template_part( 'pages', 'nivo' );
}
elseif($page_header==5) {
	get_template_part( 'pages', 'revolution' );
}
elseif($page_header==6) {
	get_template_part( 'pages', 'layer' );
}
else {
	get_template_part( 'pages', 'banner' );
}
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$event_layout = get_post_meta(get_the_ID(),'imic_event_layout_type',true);
$event_column = get_post_meta(get_the_ID(),'imic_temp_event_columns_layout',true);
$currentEventTime = date('Y-m'); 
$prev_month = date('Y-m', strtotime('-1 month', strtotime($currentEventTime)));
$next_months = date('Y-m', strtotime('+1 month', strtotime($currentEventTime))); 
//wp_enqueue_script('event_ajax', IMIC_THEME_PATH . '/js/event_ajax.js', '', '', true);
//wp_localize_script('event_ajax', 'urlajax', array('ajaxurl' => admin_url('admin-ajax.php')));
$event_category = get_post_meta(get_the_ID(),'imic_advanced_event_list_taxonomy',true);
if($event_category!=''){
$event_categories= get_term_by('id',$event_category,'event-category');
if(!empty($event_categories)){
$event_category= $event_categories->slug; }} 
if($event_layout=='0'||$event_layout==2) { 
$event_count = get_post_meta(get_the_ID(),'imic_events_count',true);
$event_count = ($event_count!='')?$event_count:10; ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            	<div class="row">
                    <div class="col-md-3 col-sm-3 events-list-sidebar" id="sidebar-col">
                        <div id="ajax_events">
                            <div class="event-page-cal listing-header">
                                <?php if($event_layout==0) { ?>
                                <span class="month"><?php echo esc_attr(date_i18n('M')); ?></span>
                                <span class="year"><?php echo esc_attr(date_i18n('Y')); ?></span>
                                <a href="javascript:void(0)" rel="<?php echo $event_category; ?>" class="upcomingEvents actions left" id="<?php echo $prev_month; ?>"><i class="fa fa-angle-left"></i></a>
                                <a href="javascript:void(0)" rel="<?php echo $event_category; ?>" class="upcomingEvents actions right" id="<?php echo $next_months; ?>"><i class="fa fa-angle-right"></i></a>
                                <?php } else { echo '<span class="month">'.__('Events','framework').'</span><a href="javascript:" rel="'.$event_category.'" class="pastevents" id="past-'.$event_count.'"><span class="year">'.__('Past','framework').'</span></a>'; } ?>
                                <div id="load-next-events" class="load-events" style="display:none;"><img src="<?php echo IMIC_THEME_PATH; ?>/images/loader.gif"></div>
                            </div>
                            <?php if(is_active_sidebar($pageSidebar)) { ?>
                        <!-- Sidebar -->
                            <?php dynamic_sidebar($pageSidebar); ?>
                        <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9" id="content-col">
                        <div class="element-block events-listing">
                            <div class="events-listing-header">
                                <ul class="sort-source" data-sort-id="events" data-option-key="filter">
                                <?php $event_cats = get_terms("event-category");?>
                                            <li data-option-value="*" class="active"><a href="#"> <?php _e('Show All','framework'); ?></a></li>
                                     	<?php foreach($event_cats as $event_cat) { ?>
                                            <li data-option-value=".<?php echo $event_cat->slug; ?>"><a href="#"><?php echo esc_attr($event_cat->name); ?></a></li>
                                    	<?php } ?>
                                </ul>
                            </div>
                            
                            <ul id="monthly-events" class="events-listing-content sort-destination isotope-events" data-sort-id="events">
                            <?php if($event_layout==0) { $events = imic_recur_events('','',$event_category,$currentEventTime); ksort($events); }
							else { $events = imic_recur_events('future','',$event_category,''); ksort($events); }
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
								} ?>">
                                	<div class="event-list-item-date">
                                    	<span class="event-date">
                                        	<span class="event-day"><?php echo esc_attr(date_i18n('d',$key)); ?></span>
                                        	<span class="event-month"><?php echo esc_attr(date_i18n('M',$key)).', ';  echo esc_attr(date_i18n('y',$key)); ?></span>
                                        </span>
                                    </div>
                                    <div class="event-list-item-info">
                                    	<div class="lined-info">
                                        	<h4><a href="<?php echo esc_url($custom_event_url); ?>" class="event-title"><?php echo get_the_title($value); ?></a></h4>
                                        </div>
                                    	<div class="lined-info">
                                        	<?php if($event_view==0) { ?>
                                        	<span class="meta-data"><i class="fa fa-clock-o"></i> <?php echo esc_attr(date_i18n('l', $key)); ?>, <span class="event-time"><?php echo date_i18n(get_option('time_format'), $st_time); if($end_date_event!='') { echo ' - '.date_i18n(get_option('time_format'), $end_date_event); } ?></span> <?php } else { ?>
											<span class="meta-data"><i class="fa fa-clock-o"></i> <?php echo esc_attr(date_i18n('l', $key)); ?>, <span class="event-time"><?php echo date_i18n(get_option('time_format'), $st_time); ?></span> 					
											<?php } if($key<date('U')) { echo '<span class="label label-default">'.__('Passed','framework').'</span>'; } elseif(date('U')>$st_time&&date('U')<$key) { echo '<span class="label label-success">'.__('Going On','framework').'</span>'; } else { echo '<span class="label label-primary">'.__('Upcoming','framework').'</span>'; } ?></span>
                                        </div>
                                        <?php if($event_address!='') { ?>
                                    	<div class="lined-info event-location">
                                        	<span class="meta-data"><i class="fa fa-map-marker"></i> <span class="event-location-address"><?php echo $event_address; ?></span></span>
                                        </div><?php } ?>
                                    </div>
                                    <div class="event-list-item-actions"><?php if($key>date('U')) { $event_registration = get_post_meta($value,'imic_event_registration',true); ?>
                                    	<?php $event_custom_url = get_post_meta($value,'imic_custom_event_registration',true);
											$event_custom_url_target = get_post_meta($value,'imic_custom_event_registration_target',true);
										 ?>
										<?php $event_registration = get_post_meta($value,'imic_event_registration',true);  ?>
										<?php if(!empty($event_custom_url)) { ?>
											<a href="<?php echo $event_custom_url; ?>" class="btn btn-default btn-transparent" <?php if($event_custom_url_target==1) { ?>target="_blank"<?php } ?>><?php _e('Register','framework'); ?> <i class="fa fa-sign-out"></i></a>
											<?php } elseif($event_registration==1) { ?>
											<a id="register-<?php echo ($value+2648).'|'.$key; ?>" href="#" class="btn btn-default btn-transparent event-tickets event-register-button"><?php _e('Register','framework'); ?></a>
										<?php } ?>
                                    <?php } ?>
                                    	<ul class="action-buttons"><?php if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') { ?>
                                        	<li title="Share event"><a href="#" data-trigger="focus" data-placement="top" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li><?php } $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { ?>
                                        	<li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li><?php } $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { ?>
                                        	<li title="Contact event manager"><a id="contact-<?php echo ($value+2648).'|'.$key; ?>" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li><?php } ?>
                                        </ul>
                                    </div>
                                </li>
                                <?php if($total++>$event_count) { break; } endforeach; } ?>
                            </ul>
                        </div>
                    </div>
              	</div>
           	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php } else { ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="events-listing-header">
                    <ul class="sort-source" data-sort-id="events" data-option-key="filter">
                        <?php $gallery_cats = get_terms("event-category");?>
                                            <li data-option-value="*" class="active"><a href="#"> <?php _e('Show All','framework'); ?></a></li>
                                     	<?php foreach($gallery_cats as $gallery_cat) { ?>
                                            <li data-option-value=".<?php echo $gallery_cat->slug; ?>"><a href="#"><?php echo esc_attr($gallery_cat->name); ?></a></li>
                                    	<?php } ?>
                    </ul>
                </div>
                <div class="row">
                <div class="col-md-<?php echo $class; ?>">
                <div class="row">
                    <ul class="sort-destination" data-sort-id="events">
                    <?php $events = imic_recur_events('future','',$event_category,'');
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
								$event_address = get_post_meta($value,'imic_event_address2',true);
								$term_slug = get_the_terms($value, 'event-category');
								echo '<li class=" col-md-'.$event_column.' col-sm-6 event-list-item event-item event-dynamic grid-item format-standard';
								if (!empty($term_slug)) {
								foreach ($term_slug as $term) {
								  echo ' '.$term->slug;
								}
								} ?>">
                            <div class="grid-item-inner">
                            <?php if(has_post_thumbnail($value)) { ?>
                             	<a href="<?php echo esc_url($custom_event_url); ?>" class="media-box">
                                	<?php echo get_the_post_thumbnail($value,'600x400'); ?>
                                </a><?php } ?>
                                <div class="grid-content">
                                	<h3><a href="<?php echo esc_url($custom_event_url); ?>" class="event-title"><?php echo get_the_title($value); ?></a></h3>
                                    <span class="meta-data"><i class="fa fa-calendar"></i> <span class="event-date"><?php echo esc_attr(date_i18n(get_option('date_format'),$key)); ?></span><?php _e(' at ','framework'); ?><span class="event-time"><?php echo esc_attr(date_i18n(get_option('time_format'), $st_time)); ?></span></span><?php if($event_address!='') { ?>
                                    <span class="meta-data event-location-address"><i class="fa fa-map-marker"></i> <?php echo $event_address; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="grid-footer clearfix"><?php if($key>date('U')) { $event_registration = get_post_meta($value,'imic_event_registration',true); ?>
                                    	<?php $event_custom_url = get_post_meta($value,'imic_custom_event_registration',true);
											$event_custom_url_target = get_post_meta($value,'imic_custom_event_registration_target',true);
										 ?>
										<?php $event_registration = get_post_meta($value,'imic_event_registration',true);  ?>
										<?php if(!empty($event_custom_url)) { ?>
											<a href="<?php echo $event_custom_url; ?>" class="pull-right btn btn-primary btn-sm" <?php if($event_custom_url_target==1) { ?>target="_blank"<?php } ?>><?php _e('Register','framework'); ?> <i class="fa fa-sign-out"></i></a>
											<?php } elseif($event_registration==1) { ?>
											<a id="register-<?php echo ($value+2648).'|'.$key; ?>" href="#" class="pull-right btn btn-primary btn-sm event-tickets event-register-button"><?php _e('Register','framework'); ?></a>
										<?php } ?>
                                    <?php } ?>
                                    <ul class="action-buttons"><?php if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') { ?>
                                        <li title="Share event"><a href="#" data-trigger="focus" data-placement="right" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li><?php } $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { ?>
                                        <li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li><?php } $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { ?>
                                        <li title="Contact event manager"><a id="contact-<?php echo ($value+2648).'|'.$key; ?>" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li><?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; } ?>
                    </ul>
                    </div>
                    </div>
                    <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo $sidebar_column; ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
                </div>
         	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php } get_footer(); ?>