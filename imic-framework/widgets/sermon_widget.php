<?php
/*** Widget code for Sermon ***/
class sermon_list extends WP_Widget {
	// constructor
	function sermon_list() {
		 $widget_ops = array('description' => __( "Display Sermons.", 'imic-framework-admin') );
         parent::WP_Widget(false, $name = __('Sermons','imic-framework-admin'), $widget_ops);
	}
	// widget form creation
	function form($instance) {
	    // Check values
                if( $instance) {
			 $title = esc_attr($instance['title']);
			 $number = esc_attr($instance['number']);
			 $category = esc_attr($instance['category']);
		} else {
			 $title = '';
			 $number = '';
       		$category='';
		}
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'imic-framework-admin'); ?></label>
            <input class="spTitle_<?php echo $title; ?>" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <p>
	            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of team member to show', 'imic-framework-admin'); ?></label>
	            <input class="spNumber_<?php echo $number; ?>" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
       <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Select Category', 'imic-framework-admin'); ?></label>
            <select class="spType_event_cat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
            <option value=""><?php _e('All','imic-framework-admin'); ?></option>
                <?php
                $post_terms = get_terms('sermon-category');
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
		  $instance['number'] = strip_tags($new_instance['number']);
		  $instance['category'] = strip_tags($new_instance['category']);
		  return $instance;
	}
	// display widget
	function widget($args, $instance) {
           $cache = array();
		if ( ! $this->is_preview() ) {
			$cache = wp_cache_get( 'sermon_list', 'widget' );
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
	   $number = apply_filters('widget_number', $instance['number']);
	   $numberEvent = (!empty($number))? $number : 4 ;
	   $category = apply_filters('widget-category', empty($instance['category']) ?'': $instance['category'], $instance, $this->id_base);
	   $type = apply_filters('widget-type', empty($instance['type']) ?'': $instance['type'], $instance, $this->id_base);
	   $EventHeading = (!empty($post_title))? $post_title : __('Recent Sermons','imic-framework-admin') ;
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo $args['before_title'];
			//echo apply_filters('widget_title',$EventHeading, $instance, $this->id_base);
			echo $args['after_title'];
		}
		query_posts(array('post_type'=>'sermon','posts_per_page'=>$numberEvent,'sermon-category'=>$category));
		$first = 1;
		if(have_posts()): echo '<ul>'; while(have_posts()):the_post();
		$mp4_video = get_post_meta(get_the_ID(),'imic_mp4_video',false);
		$webm_video = get_post_meta(get_the_ID(),'imic_webm_video',false);
		$ogg_video = get_post_meta(get_the_ID(),'imic_ogg_video',false);
		$vimeo_video = get_post_meta(get_the_ID(),'imic_vimeo_video',true);
		$youtube_video = get_post_meta(get_the_ID(),'imic_youtube_video',true);
		$post_author_id = get_post_meta(get_the_ID(),'imic_sermon_speaker',false);
		$self_audio = get_post_meta(get_the_ID(),'imic_self_audio',true);
		$download_pdf = get_post_meta(get_the_ID(),'imic_pdf_url',true);
		$soundcloud_audio = get_post_meta(get_the_ID(),'imic_soundcloud_audio',true);
		if($first==1) {
		echo '<li class="most-recent-sermon clearfix">
                                    <h3>'.apply_filters('widget_title',$EventHeading, $instance, $this->id_base).'</h3>
                                    <hr class="sm">';
									echo '<div class="latest-sermon-video fw-video">';
									if($vimeo_video!=''||$youtube_video!='') {
										if($vimeo_video!='') {
											$video_code = imic_video_embed($vimeo_video,"500","281"); }
											else {
												$video_code = imic_video_embed($youtube_video,"500","281"); }
                                    echo ''.$video_code.'';
									}
                                    echo '</div>';
                                    echo '<div class="latest-sermon-content">
                                        <h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>
                                        <div class="meta-data">'.__('by ','framework');
										$count = 1;
										foreach($post_author_id as $speaker) {
											$sep = ($count<count($post_author_id))?', ':'';
											echo get_the_title($speaker).$sep;
											$count++;
										}
										echo '</div>
                                        '.imic_excerpt(8).'
                                    </div>
                                    <div class="sermon-links">
                                        <ul class="action-buttons">';
										if(!empty($mp4_video)||!empty($webm_video)||!empty($ogg_video)||!empty($vimeo_video)||!empty($youtube_video)) { 
                                            echo '<li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Watch Video','framework').'"><i class="icon-video-cam"></i></a></li>'; }
										if($self_audio!=''||$soundcloud_audio!='') { 
                                            echo '<li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Listen Audio','framework').'"><i class="icon-headphones"></i></a></li>'; }
										if($self_audio!='') { 
                                            echo '<li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Download Audio','framework').'"><i class="icon-cloud-download"></i></a></li>'; }
										if($download_pdf!='') { 
                                            echo '<li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Download PDF','framework').'"><i class="icon-download-folder"></i></a></li>'; }
                                        echo '</ul>
                                    </div>
                               	</li>'; } else {
                                echo '<li>
                                 	<a href="'.get_permalink().'"><strong class="post-title">'.get_the_title().'</strong></a>
                                        <div class="meta-data">'.__('by ','framework');
										$count = 1;
										foreach($post_author_id as $speaker) {
											$sep = ($count<count($post_author_id))?', ':'';
											echo get_the_title($speaker).$sep;
											$count++;
										}
										echo '</div>
                                </li>'; }
								$first++;
		endwhile; echo '</ul>'; wp_reset_query();
		else:
			_e('No Sermons Found','imic-framework-admin');		
		endif;
	   echo $args['after_widget'];
	   if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'sermon_list', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("sermon_list");'));
?>