<?php
/*
Template Name: Home
*/
get_header();
imic_sidebar_position_module();
global $imic_options;
$event_view = $imic_options['event_time_view'];
$event_counter_view = $imic_options['event_countdown_position'];
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
$pageSidebar2 = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list2', true);
if(!empty($pageSidebar2)&&is_active_sidebar($pageSidebar2)) {
$class2 = 9;  
}else{
$class2 = 12;  
}
//Section 1 Values
$section1_switch = get_post_meta($id,'imic_status_section1',true);
//Section 2 Values
$section2_switch = get_post_meta($id,'imic_status_section2',true);
//Featured Area Values
$featured_switch = get_post_meta($id,'imic_featured_area_switch',true);
$gallery_switch = get_post_meta($id,'imic_status_gallery',true);
$gallery_title = get_post_meta($id,'imic_gallery_title',true);
$feat_data = get_post_meta( $id, 'feat_data', true );
$featured_column = get_post_meta($id,'imic_featured_area_column',true);
$featured_effect = get_post_meta($id,'imic_featured_hover_effect',true);
$featured_effect = ($featured_effect==1)?'':'no-fade';
$featured_layout = get_post_meta($id,'imic_featured_layout',true);
$featured_image_size = ($featured_layout=='round')?'210x210':'600x400';
$featured_layout = ($featured_layout=='round')?'featured-block-rounded':'';
$home_page = "other";
if(is_page_template('template-home.php')||is_page_template('template-home-second.php')) {
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
<?php } } if($featured_switch==1) { if(!empty($feat_data)) { ?>
<!-- Lead Content -->
    <div class="lead-content clearfix <?php echo $counter_class; ?>">
    	<div class="lead-content-wrapper">
    		<div class="container">
            	<div class="row">
                <?php 
					$featured_count = 1; 
					$total_featured = count($feat_data['feat_title']);
					while($featured_count<=$total_featured) { 
					$image = wp_get_attachment_image_src( $feat_data['image_url'][$featured_count-1], $featured_image_size );
					$url = $feat_data['feat_url'][$featured_count-1]; 
					$img_html = '<figure>
                        	<a href="'.esc_url($url).'"><img src="'.esc_url($image[0]).'" alt=""></a>
                    	</figure>';
					$img = ($url!='')?$img_html:'<figure><img src="'.esc_url($image[0]).'" alt=""></figure>';
					?>
                    <div class="col-md-<?php echo $featured_column; ?> col-sm-<?php echo $featured_column.' featured-block featured-block-equal '.$featured_effect.' '.$featured_layout; ?> ">
                        <h3><?php echo esc_attr($feat_data['feat_title'][$featured_count-1]); ?></h3>
                        <?php echo $img; ?>
                   		<div class="featured-block-equal-cont"><p><?php echo esc_attr($feat_data['image_desc'][$featured_count-1]); ?></p></div>
                    </div>
                    <?php $featured_count++; } ?>
                </div>
        	</div>
        </div>
    </div><?php } } ?>
    <!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            
			<?php //Page Content
            if(have_posts()):while(have_posts()):the_post();
            the_content();
            endwhile; endif;
            ?>
            <?php if($section1_switch==1) { 
				$section1_sidebar = get_post_meta($id,'imic_section1_homepage_sidebar',true); 
				if(!empty($section1_sidebar)&&is_active_sidebar($section1_sidebar)) {
					$class1 = 8; 
					$smclass1 = 7; 
					}else{
					$class1 = 12;
					$smclass1 = 12;  
					} 
				$link_title = get_post_meta($id,'imic_section1_link_title',true); 
				$page_link = get_post_meta($id,'imic_section1_page_link',true);
				$heading = get_post_meta($id,'imic_section1_heading',true); 
				$event_type = get_post_meta($id,'imic_section1_event_type',true);
				$event_count = get_post_meta($id,'imic_section1_event_count',true);
				$event_category = get_post_meta($id,'imic_section1_event_category',true); 
				if($event_category!=''){
				$event_categories= get_term_by('id',$event_category,'event-category');
				if(!empty($event_categories)){
				$event_category= $event_categories->slug; }}
				$events = imic_recur_events($event_type,'',$event_category);
				if($event_type=='future') { ksort($events); } else { krsort($events); } ?>
            	<div class="row">
                <?php if(is_active_sidebar($section1_sidebar)) { ?>
                    <div class="col-md-4 col-sm-5" id="sidebar-col">
                        <?php dynamic_sidebar($section1_sidebar); ?>
                   	</div>
                    <?php } ?>
                    <div class="col-md-<?php echo $class1; ?> col-sm-<?php echo $smclass1; ?>" id="content-col">
                        <div class="element-block events-listing">
                            <div class="events-listing-header">
                                <?php if($page_link!='') { ?><a href="<?php echo esc_url($page_link); ?>" class="pull-right basic-link"><?php echo $link_title; ?></a><?php } ?>
                                <h3 class="element-title"><?php echo $heading; ?></h3>
                                <hr class="sm">
                            </div>
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
							} ?>
                            
                                <div class="event-list-item event-dynamic">
                                	<div class="event-list-item-date">
                                    	<span class="event-date">
                                        	<span class="event-day"><?php echo esc_attr(date_i18n('d', $key)); ?></span>
                                        	<span class="event-month"><?php echo esc_attr(date_i18n('M, ', $key)); echo esc_attr(date_i18n('y', $key)); ?></span>
                                        </span>
                                    </div>
                                    <div class="event-list-item-info">
                                    	<div class="lined-info">
                                        	<h4><a href="<?php echo esc_url($custom_event_url); ?>" class="event-title"><?php echo esc_attr(get_the_title($value)); ?></a></h4>
                                        </div>
                                    	<div class="lined-info">
                                        <?php if($event_view==0) { ?>
                                        	<span class="meta-data"><i class="fa fa-clock-o"></i> <?php echo esc_attr(date_i18n('l', $key)); ?>, <span class="event-time"><?php echo date_i18n(get_option('time_format'), $st_time); if($start_time_meta!='') { echo ' - '.date_i18n(get_option('time_format'), $end_date_event); } ?></span> <?php } else { ?>
											<span class="meta-data"><i class="fa fa-clock-o"></i> <?php echo esc_attr(date_i18n('l', $key)); ?>, <span class="event-time"><?php echo date_i18n(get_option('time_format'), $st_time); ?></span> 					
											<?php } if($key<date('U')) { echo '<span class="label label-default">'.__('Passed','framework').'</span>'; } elseif(date('U')>$st_time&&date('U')<$key) { echo '<span class="label label-success">'.__('Going On','framework').'</span>'; } else { echo '<span class="label label-primary">'.__('Upcoming','framework').'</span>'; } ?></span>
                                        </div>
                                        <?php if($event_address!='') { ?>
                                    	<div class="lined-info event-location">
                                        	<span class="meta-data"><i class="fa fa-map-marker"></i> <span class="event-location-address"><?php echo esc_attr($event_address); ?></span></span>
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
                                        	<li title="<?php _e('Share Event','framework'); ?>"><a href="#" data-trigger="focus" data-placement="top" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li><?php } $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { ?>
                                        	<li title="<?php _e('Get directions','framework'); ?>" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li><?php } $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { ?>
                                        	<li title="<?php _e('Contact event manager','framework'); ?>"><a id="contact-<?php echo ($value+2648).'|'.$key; ?>"  href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li><?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                <?php if (++$total > $event_count) { break; } } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="fw"><?php } if($section2_switch==1) { 
				$recent_section_excerpt_length = get_post_meta($id,'imic_section2_excerpt_length',true);
				$recent_section_excerpt_length = ($recent_section_excerpt_length!='')?$recent_section_excerpt_length:15;
				$post_excerpt_length = get_post_meta($id,'imic_section2_post_excerpt_length',true);
				$post_excerpt_length = ($post_excerpt_length!='')?$post_excerpt_length:10;
				$section2_sidebar = get_post_meta($id,'imic_section2_homepage_sidebar',true); 
				if(!empty($section2_sidebar)&&is_active_sidebar($section2_sidebar)) {
					$column = 8;
					}else{ 
					$column = 12;
					} 
				$recent_category_slug = '';
				$section2_heading = get_post_meta($id,'imic_section2_heading',true);
				$recent_title = get_post_meta($id,'imic_section2_recent_title',true);
				$status_recent_post = get_post_meta($id,'imic_status_latest_post',true);
				$recent_posts_count = get_post_meta(get_the_ID(),'imic_posts_to_show_on',true);
							$recent_posts_count = ($recent_posts_count=='')?3:$recent_posts_count;
							$recent_posts_blog_url = get_post_meta(get_the_ID(),'imic_visit_blog_url',true);
							$recent_post_type = get_post_meta(get_the_ID(),'imic_selected_post_type',true);
							if($recent_post_type=='post') {
							$recent_category = get_post_meta(get_the_ID(),'imic_post_category',true);
							} elseif($recent_post_type=='event') {
							$recent_category = get_post_meta(get_the_ID(),'imic_event_category',true);
							} elseif($recent_post_type=='gallery') {
							$recent_category = get_post_meta(get_the_ID(),'imic_gallery_category',true);
							} elseif($recent_post_type=='project') {
							$recent_category = get_post_meta(get_the_ID(),'imic_project_category',true);
							} elseif($recent_post_type=='product') {
							$recent_category = get_post_meta(get_the_ID(),'imic_product_category',true);
							} else { $recent_category = ''; }
							$post_options = get_post_meta(get_the_ID(),'imic_select_post_options',false);
							$post_content = get_post_meta(get_the_ID(),'imic_select_post_content',true);
							$thumb_hyperlink = get_post_meta(get_the_ID(),'imic_select_thumb_hyperlink',true);
							$title_hyperlink = get_post_meta(get_the_ID(),'imic_select_title_hyperlink',true);
							$visit_post_button_title = get_post_meta(get_the_ID(),'imic_visit_post_title',true);
							if($recent_category=='post') {
							if(!empty($recent_category)){
								$recent_category_slug = 'category_name';
							$recent_category= get_category($recent_category);
							$recent_category= $post_categories->slug; } }
							else {
							if(!empty($recent_category)){
							if($recent_post_type=='product') {
								$recent_category_slug = $recent_post_type.'_cat'; }
							else {
								$recent_category_slug = $recent_post_type.'-category'; }
							$recent_category= get_term_by('id',$recent_category,$recent_category_slug);
							if(!empty($recent_category)){
							$recent_category= $recent_category->slug; } } } ?>
                <div class="row">
                    <div class="col-md-<?php echo $column; ?>">
                        <h3><?php echo $section2_heading; ?></h3>
                        <hr class="sm">
                        <div class="row">
                        <?php 
						
						$latest_count = 0;
						query_posts(array('post_type'=>$recent_post_type,$recent_category_slug=>$recent_category,'posts_per_page'=>$recent_posts_count));
						global $product;
						$post_left_class = ( $wp_query->post_count==1)?12:(!empty($section2_sidebar)&&is_active_sidebar($section2_sidebar))?6:4;
						if(have_posts()): while(have_posts()):the_post();
						$post_class = 12; if($status_recent_post==1&&$latest_count==0) { $post_class = (!empty($section2_sidebar)&&is_active_sidebar($section2_sidebar))?6:8; 
						$latest_count=11; ?>
                        	<div class="col-md-<?php echo $post_left_class; ?>">
                            	<div class="very-latest-post format-standard">
                                	<div class="title-row">
                                		<!--<a href="blog-post.html#comments" class="comments-go" title="10 comments"><i class="icon-dialogue-text"></i></a>-->
                                	<?php  comments_popup_link('<i class="icon-dialogue-text"></i>','<i class="icon-dialogue-text"></i>','<i class="icon-dialogue-text"></i>','comments-go','<i class="icon-dialogue-text"></i>'); ?>
                                                <h4><?php echo $recent_title; ?></h4>
                                    </div>
                                    <?php if(in_array('thumb',$post_options)) { if($thumb_hyperlink=='single') { ?>
                                    <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="media-box post-thumb">
                                        <?php the_post_thumbnail('800x500'); ?>
                                    </a><?php } elseif($thumb_hyperlink=='image') { $post_thumbnail_id = get_post_thumbnail_id( get_the_ID() ); $image = wp_get_attachment_image_src($post_thumbnail_id,'1000x800'); ?><a href="<?php echo esc_url($image[0]); ?>" data-rel="prettyPhoto" class="media-box"><?php the_post_thumbnail('800x500'); ?></a>
				    <?php } else { ?>
                                    <?php the_post_thumbnail('800x500'); ?><?php } } else { ?>
                                    <?php the_post_thumbnail('800x500'); ?><?php } if(in_array('title',$post_options)) { if($title_hyperlink=='single') { ?>
                                    <h3 class="post-title"><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php the_title(); ?></a></h3>
                                    <?php } else { ?>
                                    <h3 class="post-title"><?php the_title(); ?></h3>
                                    <?php } } ?>
                                    <div class="meta-data"><?php if($recent_post_type=='post'||$recent_post_type=='sermon'||$recent_post_type=='gallery') {  _e('by ','framework'); ?><a href="<?php $post_author_id = get_post_field( 'post_author', get_the_ID() ); echo esc_url(get_author_posts_url($post_author_id)); ?>"><?php echo esc_attr(get_the_author_meta( 'display_name', $post_author_id )); ?></a><?php _e(' on ','framework'); echo esc_attr(get_the_date(get_option('date_format')));_e(' in ','framework'); the_category(', '); } elseif($recent_post_type=='product') { echo '<span class="price">'.$product->get_price_html().' </span> '; do_action( 'woocommerce_after_shop_loop_item' ); } else { echo '<span class="meta-data">'.esc_attr(get_post_meta(get_the_ID(),'imic_staff_position',true)).'</span>'; } ?></div>
                                    <?php if(in_array('text',$post_options)) { if($post_content=='excerpt') { echo imic_excerpt($recent_section_excerpt_length); } else { the_content(); } } if(in_array('more',$post_options)) { ?>
                                    <p><a href="<?php the_permalink(); ?>" class="basic-link"><?php _e('Continue reading ','framework'); ?><i class="fa fa-angle-right"></i></a></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } if($latest_count==11||$latest_count==0) { ?>
                            <div class="col-md-<?php echo $post_class; ?>">
                                <ul class="blog-classic-listing">
                                <?php } if($latest_count==0||$latest_count==1) {  ?>
                                    <li class="format-standard">
                                            <div class="row">
                                                
                                                <?php $col_class = 12; if(in_array('thumb',$post_options)) { echo '<div class="col-md-4">'; $col_class = 8; if($thumb_hyperlink=='single') { ?>
                                    <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="media-box post-thumb">
                                        <?php the_post_thumbnail('800x500'); ?>
                                    </a><?php } elseif($thumb_hyperlink=='image') { $post_thumbnail_id = get_post_thumbnail_id( get_the_ID() ); $image = wp_get_attachment_image_src($post_thumbnail_id,'1000x800'); ?><a href="<?php echo esc_url($image[0]); ?>" data-rel="prettyPhoto" class="media-box"><?php the_post_thumbnail('800x500'); ?></a>
									<?php } else { ?>
                                    <?php the_post_thumbnail('800x500'); ?><?php } echo '</div>'; } ?>
                                                <div class="col-md-<?php echo $col_class; ?>">
                                                    <?php if(in_array('title',$post_options)) { if($title_hyperlink=='single') { ?>
                                    <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><strong class="post-title"><?php the_title(); ?></strong></a>
                                    <?php } else { ?>
                                    <strong class="post-title"><?php the_title(); ?></strong>
                                    <?php } } ?>
                                                    <div class="meta-data"><?php if($recent_post_type=='post'||$recent_post_type=='sermon'||$recent_post_type=='gallery') {  _e('by ','framework'); ?><a href="<?php $post_author_id = get_post_field( 'post_author', get_the_ID() ); echo esc_url(get_author_posts_url($post_author_id)); ?>"><?php echo esc_attr(get_the_author_meta( 'display_name', $post_author_id )); ?></a><?php _e(' on ','framework'); echo esc_attr(get_the_date(get_option('date_format')));_e(' in ','framework'); the_category(', '); } elseif($recent_post_type=='product') { echo '<span class="price">'.$product->get_price_html().' </span> '; do_action( 'woocommerce_after_shop_loop_item' ); } else { echo '<span class="meta-data">'.get_post_meta(get_the_ID(),'imic_staff_position',true).' '.imic_social_staff_icon().'</span>'; } ?></div>
                                                    <?php if(in_array('text',$post_options)) { if($post_content=='excerpt') { echo imic_excerpt($post_excerpt_length); } else { the_content(); } } if(in_array('more',$post_options)) { ?>
                                    <p><a href="<?php the_permalink(); ?>" class="basic-link"><?php _e('Continue reading ','framework'); ?><i class="fa fa-angle-right"></i></a></p>
                                    <?php } ?>
                                                </div>
                                            </div>
                                        </li>
                              	<?php } $latest_count=1; endwhile; else: ?>
                                <div class="col-md-8">
                                <ul class="blog-classic-listing"><li>
                                <?php _e('No Posts to display','framework'); ?>
                                </li></ul></div>
                                <?php endif; wp_reset_query(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php if(is_active_sidebar($section2_sidebar)) { ?>
                    <div class="col-md-4">
                        <?php dynamic_sidebar($section2_sidebar); ?>
                   	</div>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
   	</div>
    <!-- End Body Content -->
    <?php if($gallery_switch==1) { ?>
    <!-- Gallery updates -->
    <div class="gallery-updates cols5 clearfix">
    	<ul>
        <?php query_posts(array('post_type'=>'gallery','posts_per_page'=>5));
			if(have_posts()):while(have_posts()):the_post();
			$post_format = get_post_format();
				$post_format = ($post_format=="")?"image":$post_format;
			get_template_part('gallery',$post_format); ?>
            
      	<?php endwhile; endif; wp_reset_query(); ?>
      	</ul>
        <?php if($gallery_title!='') { ?>
        <div class="gallery-updates-overlay">
        	<div class="container">
            	<i class="icon-multiple-image"></i>
                <h2><?php echo esc_attr($gallery_title); ?></h2>
            </div>
        </div>
        <?php } ?>
    </div>
<?php } get_footer(); ?>