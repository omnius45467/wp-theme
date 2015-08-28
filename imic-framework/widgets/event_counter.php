<?php
/*** Widget code for Event Counter ***/
class event_counter extends WP_Widget {
	// constructor
	function event_counter() {
		 $widget_ops = array('description' => __( "Show counter for event.", 'imic-framework-admin') );
         parent::WP_Widget(false, $name = __('Event Counter','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $category = esc_attr($instance['category']);
		} else {
			 $title = '';
           $category='';
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo $title; ?>" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
       
        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Category', 'imic-framework-admin'); ?></label>
            <select class="spType_event_cat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
            <option value=""><?php _e('All','imic-framework-admin'); ?></option>
                <?php
                $post_terms = get_terms('event-category');
                if(!empty($post_terms)){
                      foreach ($post_terms as $term) {
                         
                        $term_name = $term->name;
                        $term_id = $term->slug;
                        $activePost = ($term_id == $category)? 'selected' : '';
                        echo '<option value="'. $term_id .'" '.$activePost.'>' . $term_name . '</p>';
                    }
                }
                ?>
            </select> 
        </p> 
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['category'] = strip_tags($new_instance['category']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
           $cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'event_counter', 'widget' );
		}
		if ( ! is_array( $cache ) ) {
			$cache = array();
		}
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}
		ob_start();
	   extract( $args );
           
	   // these are the widget options
	   $post_title = apply_filters('widget_title', $instance['title']);
	   $post_title = ($post_title=='')?__('Upcoming Events','imic-framework-admin'):$post_title;
       $category = apply_filters('widget-category', empty($instance['category']) ?'': $instance['category'], $instance, $this->id_base);
	   $EventHeading = $post_title;
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo '<i class="fa fa-calendar"></i> '.apply_filters('widget_title',$EventHeading, $instance, $this->id_base);
			echo $args['after_title'];
		}
		wp_reset_postdata();
		wp_enqueue_script('imic_jquery_countdown');
		wp_localize_script('imic_jquery_countdown', 'upcoming_data', array('c_time' =>time()));
		wp_enqueue_script('imic_counter_init');
		global $imic_options;
		$events = imic_recur_events('future','nos',$category);
		ksort($events);
		if(!empty($events)) { $total = 1;
			foreach($events as $key=>$value) {
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
				$event_end_date = get_post_meta($value,'imic_event_end_dt',true);
				$event_end_date = strtotime($event_end_date);
				$st_date = date('Y-m-d',$key);
				$en_tm = date('G:i',$event_end_date);
				$counter_time = $key;
				echo '<section class="upcoming-event format-standard event-list-item event-dynamic">';
				if(has_post_thumbnail($value)) {
                            echo '<a href="'.esc_url($custom_event_url).'" class="media-box">'.
                                get_the_post_thumbnail($value,'600x400').'
                            </a>'; }
                            echo '<div class="upcoming-event-content">
                                <span class="label label-primary upcoming-event-label">'.__('Next coming event','framework').'</span>
                                <div id="event-counter-'.$this->id.'" class="counter clearfix" data-date="'.$counter_time.'">
                                    <div class="timer-col"> <span id="days"></span> <span class="timer-type">'.__('Days','framework').'</span> </div>
                                    <div class="timer-col"> <span id="hours"></span> <span class="timer-type">'.__('Hours','framework').'</span> </div>
                                    <div class="timer-col"> <span id="minutes"></span> <span class="timer-type">'.__('Minutes','framework').'</span> </div>
                                    <div class="timer-col"> <span id="seconds"></span> <span class="timer-type">'.__('Seconds','framework').'</span> </div>
                                </div>
                                <h3><a href="'.esc_url($custom_event_url).'" class="event-title">'.get_the_title($value).'</a></h3>
                                <span class="meta-data">On <span class="event-date">'.date_i18n(get_option('date_format'), $key).'</span>'.__(' at ','framework').'<span class="event-time">'.date_i18n(get_option('time_format'), $st_time).'</span>'.__(' at','framework').'</span>';
								$address = get_post_meta($value,'imic_event_address2',true); if($address!='') {
                              	echo '<span class="meta-data event-location"> <span class="event-location-address">'.$address.'</span></span>'; }
                            echo '</div>
                            <div class="upcoming-event-footer">'; $event_registration = get_post_meta($value,'imic_event_registration',true); if($event_registration==1) {
                            	echo '<a id="imicregister-'.($value+2648).'|'.$key.'" href="#" class="pull-right btn btn-primary btn-sm event-tickets event-register-button">'.__('Register','framework').'</a>'; }
                                echo '<ul class="action-buttons">'; if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') { 
                                    echo '<li title="Share event"><a href="#" data-trigger="focus" data-placement="top" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li>'; } $event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') { 
                                    echo '<li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li>'; } $event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') { 
                                    echo '<li title="Contact event manager"><a id="imiccontact-'.($value+2648).'|'.$key.'" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li>'; }
                                echo '</ul>
                            </div>
                        </section>';
								if (++$total > 1) { break; }
			} 
		}else{
			echo '<section class="upcoming-event format-standard event-list-item event-dynamic">
			<div class="upcoming-event-content">
			<h3>'.
			__('No Upcoming Events Found','imic-framework-admin').
			'</h3></div></div>';		
		}
	   echo $args['after_widget'];
	   
	   if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'event_counter', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("event_counter");'));
?>