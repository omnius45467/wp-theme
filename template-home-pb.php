<?php
/*
Template Name: Home Page Builder
*/
get_header();
imic_sidebar_position_module();
global $imic_options;
//Get Page Banner Type
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
$home_page = "other";
if(is_page_template('template-home.php')||is_page_template('template-home-second.php')||is_page_template('template-home-pb.php')) {
	$home_page = "home"; }
$event_counter_switch = get_post_meta($id,'imic_event_counter',true);
//Get Event Category Slug for Counter
$event_cat = get_post_meta($id,'imic_counter_event_category',true);
if($event_cat!=''){
	$event_cat= get_term_by('id',$event_cat,'event-category');
	if(!empty($event_cat)){
		$event_cat= $event_cat->slug; 
	}
}
$counter_class = '';
if($event_counter_switch==1) {
wp_enqueue_script('imic_jquery_countdown');
wp_localize_script('imic_jquery_countdown', 'upcoming_data', array('c_time' =>time()));
wp_enqueue_script('imic_counter_init');
$counter_class = "has-counter";
$counter_title = get_post_meta($id,'imic_event_counter_title',true);
$events = imic_recur_events('future','nos',$event_cat);
if(!empty($events)) {
ksort($events);
$total = 1;
foreach($events as $key=>$value) {
	$date_converted=date('Y-m-d',$key );
  	$custom_event_url= imic_query_arg($date_converted,$value);
	$event_end_date = get_post_meta($value,'imic_event_end_dt',true);
	$event_end_date = strtotime($event_end_date);
	$st_date = date('Y-m-d',$key);
	$en_tm = date('G:i',$event_end_date);
	$counter_time = $key;
	$start_time = '23:59';
							$start_time_meta = get_post_meta($value,'imic_event_start_dt',true);
							if($start_time_meta!='') {
							$start_time_meta = strtotime($start_time_meta);
							$start_time = date('G:i',$start_time_meta); }
							$st_time = '';
							$st_time = date('Y-m-d',$key);
							$st_time = strtotime($st_time.' '.$start_time);
?>
<!--Event Counter Code-->
<div class="upcoming-event-bar event-dynamic">
        <div class="container">
            <div class="row">
            	<div class="col-md-5 col-sm-5">
                   <span class="label label-primary"><?php echo esc_attr($counter_title); ?></span>
                	<h3><a href="<?php echo esc_url($custom_event_url); ?>" class="event-title"><?php echo esc_attr(get_the_title($value)); ?></a></h3>
                   	<span class="meta-data"><?php _e('On','framework'); ?> <span class="event-date"><?php echo esc_attr(date_i18n(get_option('date_format'),$key)); ?></span> <?php _e('at ','framework'); ?><span class="event-time"><?php echo esc_attr(date_i18n(get_option('time_format'),$st_time)); ?></span> <?php _e('at','framework'); ?></span>
                    <?php $address = get_post_meta($value,'imic_event_address2',true); if($address!='') { ?>
                    <span class="meta-data event-location"> <span class="event-location-address"><?php echo esc_attr($address); ?></span></span><?php } ?>
                </div>
                <div class="col-md-5 col-sm-7">
                    <div id="counters" class="counter clearfix" data-date="<?php echo $counter_time; ?>">
                        <div class="timer-col"> <span id="days"></span> <span class="timer-type"><?php _e('Days','framework'); ?></span> </div>
                        <div class="timer-col"> <span id="hours"></span> <span class="timer-type"><?php _e('Hours','framework'); ?></span> </div>
                        <div class="timer-col"> <span id="minutes"></span> <span class="timer-type"><?php _e('Minutes','framework'); ?></span> </div>
                        <div class="timer-col"> <span id="seconds"></span> <span class="timer-type"><?php _e('Seconds','framework'); ?></span> </div>
                    </div>
                </div>
                <div class="col-md-2 text-align-right">
                    <ul class="action-buttons"><?php if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') { ?>
                        <li title="<?php _e('Share Event','framework'); ?>"><a href="#" data-trigger="focus" data-placement="top" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li><?php } $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { ?>
                        <li title="<?php _e('Get directions','framework'); ?>" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li><?php } $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { ?>
                        <li title="<?php _e('Contact event manager','framework'); ?>"><a id="contact-<?php echo ($value+2648).'|'.$key; ?>" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li><?php } ?>
                    </ul>
					<?php $event_custom_url = get_post_meta($value,'imic_custom_event_registration',true);
						$event_custom_url_target = get_post_meta($value,'imic_custom_event_registration_target',true);
					 ?>
					<?php $event_registration = get_post_meta($value,'imic_event_registration',true);  ?>
                    <?php if(!empty($event_custom_url)) { ?>
                    	<a href="<?php echo $event_custom_url; ?>" class="btn btn-primary btn-sm" <?php if($event_custom_url_target==1) { ?>target="_blank"<?php } ?>><?php _e('Register','framework'); ?> <i class="fa fa-sign-out"></i></a>
                        <?php } elseif($event_registration==1) { ?>
                    	<a id="register-<?php echo ($value+2648).'|'.$key; ?>" href="#" class="btn btn-primary btn-sm event-tickets event-register-button"><?php _e('Register','framework'); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php //Requires Only One Event
if (++$total > 1) { break; } } }
else {
//No Event Found ?>
<div class="upcoming-event-bar event-dynamic">
        <div class="container">
            <div class="row">
            	<div class="col-md-5 col-sm-5">
                	<span class="label label-primary"><?php _e('No Event Found','framework'); ?></span>
               	</div>
         	</div>
     	</div>
</div>                          
<?php } } ?>
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            
			<?php //Page Content
            if(have_posts()):while(have_posts()):the_post();
            the_content();
            endwhile; endif;
            ?>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>