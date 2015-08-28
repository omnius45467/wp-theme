<?php
/*** Widget code for Upcoming Events ***/
class upcoming_events extends WP_Widget {
	// constructor
	function upcoming_events() {
		 $widget_ops = array('description' => __( "Display Upcoming Events.", 'imic-framework-admin') );
         parent::WP_Widget(false, $name = __('Upcoming Events','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $number = esc_attr($instance['number']);
			 $category = esc_attr($instance['category']);
			 $status = esc_attr($instance['status']);
		} else {
			 $title = '';
			 $number = '';
           $category='';
		   $status = '';
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo $title; ?>" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <p>
	            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of events to show', 'imic-framework-admin'); ?></label>
	            <input class="spNumber_<?php echo $number; ?>" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
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
        <p>
            <label for="<?php echo $this->get_field_id('status'); ?>"><?php _e('Select Event Type', 'imic-framework-admin'); ?></label>
            <select class="spType_event_cat" id="<?php echo $this->get_field_id('status'); ?>" name="<?php echo $this->get_field_name('status'); ?>">
            <option value="future" <?php echo ($status=='future')?'selected':''; ?>><?php _e('Future','imic-framework-admin'); ?></option>
            <option value="past" <?php echo ($status=='past')?'selected':''; ?>><?php _e('Past','imic-framework-admin'); ?></option>
            </select> 
        </p> 
	<?php
	}
	// update widget
	function update($new_instance, $old_instance) {
		  $instance = $old_instance;
                // Fields
		  $instance['title'] = strip_tags($new_instance['title']);
		  $instance['number'] = strip_tags($new_instance['number']);
		  $instance['category'] = strip_tags($new_instance['category']);
		  $instance['status'] = strip_tags($new_instance['status']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
           $cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'upcoming_events', 'widget' );
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
	   $number = apply_filters('widget_number', $instance['number']);
       $category = apply_filters('widget-category', empty($instance['category']) ?'': $instance['category'], $instance, $this->id_base);
	   $numberEvent = (!empty($number))? $number : 4 ;
	   $EventHeading = $post_title;
	   $status = apply_filters('widget_status', $instance['status']);
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$EventHeading, $instance, $this->id_base);
			echo $args['after_title'];
		}
		wp_reset_postdata();
		global $imic_options;
		$event_view = $imic_options['event_time_view'];
		$event_counter_view = $imic_options['event_countdown_position'];
		$events = imic_recur_events($status,'nos',$category);
		if($status=='future') { ksort($events); } else { krsort($events); }
		if(!empty($events)) { $total = 1;
			echo '<div class="events-listing-content smaller-cont">'; 
			foreach($events as $key=>$value) {
				$style = '';
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
				echo '<div class="event-list-item">
                                	<div class="event-list-item-date">
                                    	<span class="event-date">
                                        	<span class="event-day">'.date_i18n('d', $key).'</span>
                                        	<span class="event-month">'.date_i18n('M, ', $key).date_i18n('y', $key).'</span>
                                        </span>
                                    </div>
                                    <div class="event-list-item-info">
                                    	<div class="lined-info event-title">
                                        	<h4><a href="'.$custom_event_url.'">'.get_the_title($value).'</a></h4>
                                        </div>';
										if($event_view==0) { 
                                        echo '<span class="meta-data"><i class="fa fa-clock-o"></i> '.date_i18n('l, ', $key); echo date_i18n(get_option('time_format'), $st_time); if($end_date_event!='') { echo ' - '.date_i18n(get_option('time_format'), $end_date_event); } echo '</span> '; }
										else {
										echo '<span class="meta-data"><i class="fa fa-clock-o"></i> '.date_i18n('l, ', $key); echo date_i18n(get_option('time_format'), $st_time); echo '</span> '; }
										 if($key<date('U')) { echo '<span class="label label-default">'.__('Passed','framework').'</span>'; } elseif(date('U')>$st_time&&date('U')<$key) { echo '<span class="label label-success">'.__('Going On','framework').'</span>'; } else { echo '<span class="label label-primary">'.__('Upcoming','framework').'</span>'; } echo '</span>';
										$address = get_post_meta($value,'imic_event_address2',true); if($address!='') {
                                        echo '<span class="meta-data"><i class="fa fa-map-marker"></i> '.$address.'</span>'; }
                                    echo '</div>
                                </div>';
								if (++$total > $numberEvent) { break; }
			} 
		}else{
			echo '<div class="event-list-item">
			<div class="event-list-item-info">
			<div class="lined-info event-title"><h4>'.
			__('No Upcoming Events Found','imic-framework-admin').
			'</div></div></div>';		
		} echo '</div>';
	   echo $args['after_widget'];
	   
	   if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'upcoming_events', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("upcoming_events");'));
?>