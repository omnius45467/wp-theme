<?php 
get_header();
imic_sidebar_position_module();
global $imic_options;
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
$feat_data = get_post_meta( $id, 'feat_data', true );

$event_details = get_post_meta($id,'imic_event_extra_info',false);
$event_address = get_post_meta($id,'imic_event_address2',true);
$date = get_query_var('event_date');
if(empty($date)){
   $date= get_post_meta(get_the_ID(),'imic_event_start_dt',true);
}
$event_time=get_post_meta(get_the_ID(),'imic_event_start_dt',true);
$event_time = strtotime($event_time);
$event_end_time=get_post_meta(get_the_ID(),'imic_event_end_dt',true);
$event_end_time = strtotime($event_end_time);
$date = strtotime($date);
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="single-event-content event-list-item event-dynamic">
                <div class="container">
                    <div class="row">
                    <div class="col-md-<?php echo $class; ?>" id="content-col">
                    <div class="row">
                    <?php while(have_posts()):the_post(); ?>
                        <div class="col-md-3 col-sm-4">
                        	<h2 class="event-title"><?php the_title(); ?></h2>
                            <span class="event-date hidden"><?php echo date(get_option('date_format'),$date); ?></span>
      						<span class="hidden"><?php _e('From ','framework'); ?><span class="event-time"><?php echo date_i18n(get_option('time_format'),$event_time); ?></span><?php echo __(' to ','framework'). date_i18n(get_option('time_format'),$event_end_time); ?></span>
                            <span class="meta-data event-location-address"><i class="fa fa-map-marker"></i> <?php echo $event_address; ?></span>
                            <hr class="sm">
                            <a href="<?php echo esc_url(imic_query_arg($date,$id)); ?>" class="event-title hidden"></a>
                            <ul class="list-group">
                            <?php if(!empty($event_details[0])) {
								foreach($event_details[0] as $key=>$value) { ?>
                              	<li class="list-group-item"> <span class="badge"><?php if(!empty($value[1])) { echo $value[1]; } ?></span> <?php if(!empty($value[0])) { echo $value[0]; } ?> </li>
                           	<?php } } ?>
                              	<li class="list-group-item">
                            <ul class="action-buttons"><?php if($event_address!='') { ?>
                               	<li title="<?php _e('Get directions','framework'); ?>" class="hidden-xs"><a href="#" class="cover-overlay-trigger"><i class="icon-compass"></i></a></li><?php } $event_contact_info = get_post_meta(get_the_id(),'imic_event_manager',true); if($event_contact_info!='') { ?>
                                <li title="<?php _e('Contact event manager','framework'); ?>"><a id="contact-<?php echo (get_the_ID()+2648).'|'.$date; ?>" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li><?php } ?>
                                <li title="<?php _e('Print','framework'); ?>"><a href="javascript:window.print()"><i class="icon-printer"></i></a></li>
                            </ul></li>
                            </ul>
           					
                            <?php $event_custom_url = get_post_meta(get_the_ID(),'imic_custom_event_registration',true);
								$event_custom_url_target = get_post_meta(get_the_ID(),'imic_custom_event_registration_target',true);
							 ?>
							<?php $event_registration = get_post_meta(get_the_ID(),'imic_event_registration',true);  ?>
							<?php if(!empty($event_custom_url)) { ?>
								<a href="<?php echo $event_custom_url; ?>" class="btn btn-lg btn-block btn-primary" <?php if($event_custom_url_target==1) { ?>target="_blank"<?php } ?>><?php _e('Register','framework'); ?> <i class="fa fa-sign-out"></i></a>
								<?php } elseif($event_registration==1) { ?>
								<a id="register-<?php echo (get_the_ID()+2648).'|'.$date; ?>" href="#" class="btn btn-lg btn-block btn-primary event-tickets event-register-button"><?php _e('Register','framework'); ?></a>
							<?php } ?>
                        </div>
                        <div class="col-md-9 col-sm-8">
                        	<div class="event-details">
                            	<div class="event-details-left">
                                <?php if(has_post_thumbnail()) {
                           			the_post_thumbnail('600x400',array('class'=>'temp-thumbnail'));  } ?>
                                    <div class="clearfix"></div>
                                    <div class="col-md-12">
                                    	<?php the_content(); ?>
                                    </div>
                               	</div>
                                <?php //Event Schedule
								if(!empty($feat_data)) {
									$total_featured = count($feat_data['sch_title']); ?>
                                <div class="event-details-right">
                           			<h3 class="heading-wbg"><?php _e('The Schedule','framework'); ?></h3>
                                    <div class="event-schedule">
                                    	<div class="timeline"></div>
                                        <?php $featured_count = 1; while($featured_count<=$total_featured) { ?>
                                        <div class="event-prog">
                                        	<span class="timeline-stone"></span>
                                            <div class="event-prog-content">
                                            <?php $icon = $feat_data['line_icon'][$featured_count-1];
											if($icon!='') { ?>
                                            	<div class="event-pro-tag <?php echo esc_attr($feat_data['icon_type'][$featured_count-1]); ?>" data-appear-animation="fadeInRight"><i class="icon <?php echo esc_attr($icon); ?>"></i></div><?php } ?>
                                    			<strong><i class="fa fa-clock-o"></i> <?php echo esc_attr($feat_data['start_time'][$featured_count-1]).' - '.esc_attr($feat_data['end_time'][$featured_count-1]); ?> </strong>
                                                <span><?php echo esc_attr($feat_data['sch_title'][$featured_count-1]); ?></span>
                                            </div>
                                       	</div>
										<?php $featured_count++; } ?>
                                    </div>
                                </div>
                                <?php } // End Event Schedule?>
                        </div>
<div class="clearfix"></div>
                        <?php if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') { ?>
							<?php imic_share_buttons(); ?>
						<?php } ?>
                        </div>
                        <?php endwhile; ?>
                        </div>

<div class="clearfix"></div>
</div>
                        <?php //Sidebar
						if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo $sidebar_column; ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } //End Sidebar ?>
                    
                </div>
           	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>