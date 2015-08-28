<?php
$event_category = wp_kses_post($instance['categories']);
$post_title = wp_kses_post($instance['title']);
$event_count = (!empty($instance['number_of_posts']))? $instance['number_of_posts'] : 4 ;
$event_type = (!empty($instance['event_type']))? $instance['event_type'] : 'future' ;
$allpostsbtn = wp_kses_post($instance['allpostsbtn']);
$allpostsurl = sow_esc_url($instance['allpostsurl']);
$events = imic_recur_events($event_type,'',$event_category);
if($event_type=='future') { ksort($events); } else { krsort($events); }
?>
<?php if(!empty($instance['title'])){ ?>
<?php if(!empty($instance['allpostsurl'])){ ?><a href="<?php echo $allpostsurl; ?>" class="btn btn-default pull-right"><?php echo $allpostsbtn; ?></a><?php } ?>
<h3 class="panel-title">
<?php echo $post_title; ?>
</h3>
<?php } ?>

<div class="events-listing-content">
 <?php $total = 1; foreach($events as $key=>$value) { 
  $event_address = get_post_meta($value,'imic_event_address2',true);
  $date_converted=date('Y-m-d',$key );
  $custom_event_url= imic_query_arg($date_converted,$value);
  $start_time = '23:59';
  $start_time_meta = get_post_meta($value,'imic_event_start_dt',true);
  if($start_time_meta!='') {
  	$start_time_meta = strtotime($start_time_meta);
    $start_time = date('G:i',$start_time_meta); }
  $st_time = '';
  $st_time = date('Y-m-d',$key);
  $st_time = strtotime($st_time.' '.$start_time); ?>
        
            <div class="event-list-item event-dynamic">
                <div class="event-list-item-date" <?php if(empty($instance['show_post_meta'])){ ?>style="width:20%;"<?php } ?>>
                    <span class="event-date">
                        <span class="event-day"><?php echo esc_attr(date_i18n('d', $key)); ?></span>
                        <span class="event-month"><?php echo esc_attr(date_i18n('M, ', $key)); echo esc_attr(date_i18n('y', $key)); ?></span>
                    </span>
                </div>
                <div class="event-list-item-info" <?php if(empty($instance['show_post_meta'])){ ?>style="width:78%; margin-right:0; border-right:0;"<?php } ?>>
                    <div class="lined-info">
                        <h4><a href="<?php echo esc_url($custom_event_url); ?>" class="event-title"><?php echo esc_attr(get_the_title($value)); ?></a></h4>
                    </div>
                    <div class="lined-info">
                        <span class="meta-data"><i class="fa fa-clock-o"></i> <?php echo esc_attr(date_i18n('l', $key)); ?>, <span class="event-time"><?php echo date_i18n(get_option('time_format'), $st_time); if($start_time_meta!='') { echo ' - '.date_i18n(get_option('time_format'), $key); } ?></span> <?php if($key<date('U')) { echo '<span class="label label-default">'.__('Passed','framework').'</span>'; } elseif(date('U')>$st_time&&date('U')<$key) { echo '<span class="label label-success">'.__('Going On','framework').'</span>'; } else { echo '<span class="label label-primary">'.__('Upcoming','framework').'</span>'; } ?></span>
                    </div>
                    <div class="lined-info event-location">
                        <span class="meta-data"><i class="fa fa-map-marker"></i> <span class="event-location-address"><?php echo esc_attr($event_address); ?></span></span>
                    </div>
                </div>
                <?php if(!empty($instance['show_post_meta'])){ ?>
                	<div class="event-list-item-actions">
						<?php if($key>date('U')) { $event_registration = get_post_meta($value,'imic_event_registration',true); ?>
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
                            <li title="<?php _e('Share Event','framework'); ?>"><a href="#" data-trigger="focus" data-placement="top" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li><?php } $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { ?>
                            <li title="<?php _e('Get directions','framework'); ?>" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li><?php } $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { ?>
                            <li title="<?php _e('Contact event manager','framework'); ?>"><a id="contact-<?php echo ($value+2648).'|'.$key; ?>"  href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li><?php } ?>
                        </ul>
                	</div>
                <?php } ?>
            </div>
            <?php if (++$total > $event_count) { break; } } ?>
        </div>