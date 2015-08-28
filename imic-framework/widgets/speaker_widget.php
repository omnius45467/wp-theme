<?php
/*** Widget code for Team ***/
class sermon_speakers extends WP_Widget {
	// constructor
	function sermon_speakers() {
		 $widget_ops = array('description' => __( "Display Speaker.", 'imic-framework-admin') );
         parent::WP_Widget(false, $name = __('Speakers','imic-framework-admin'), $widget_ops);
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
                $post_terms = get_terms('speaker-category');
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
			$cache = wp_cache_get( 'sermon_speakers', 'widget' );
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
	   $EventHeading = (!empty($post_title))? $post_title : __('Sermon Speakers','imic-framework-admin') ;
	   echo $args['before_widget'];
		if( !empty($instance['title']) ){
			echo $args['before_title'];
			echo apply_filters('widget_title',$EventHeading, $instance, $this->id_base);
			echo $args['after_title'];
		}
		$url = imic_get_template_url('template-speakers-sermon.php');
		query_posts(array('post_type'=>'speaker','posts_per_page'=>$numberEvent,'speaker-category'=>$category));
		if(have_posts()): echo '<ul>'; while(have_posts()):the_post();
		$position = get_post_meta(get_the_ID(),'imic_staff_position',true);
		echo '<li>';
		if ( '' != get_the_post_thumbnail() ) { echo get_the_post_thumbnail(get_the_ID(),'100x100'); }
                                    echo '<div class="people-info">
                                    	<h5 class="people-name"><a data-toggle="modal" data-target="#team-modal-'.(get_the_ID()+2648).'" href="#" class="">'.get_the_title().'</a></h5>
                                    	<span class="meta-data">'.$position.'</span>
                                   	</div>
                               	';
		echo '</li><div class="modal fade team-modal" id="team-modal-'.(get_the_ID()+2648).'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">'.__('Team Members','framework').'</h4>
                          </div>
                            <div class="modal-body">
                                <div class="staff-item">
                                <div class="row">
                                    <div class="col-md-5 col-sm-6">
                                    	'.get_the_post_thumbnail(get_the_ID(),'600x400',array('class'=>'img-thumbnail')).'
                                    </div>
                                    <div class="col-md-7 col-sm-6">
                                    	<h3>'.get_the_title().'</h3>
                                    	<span class="meta-data">'.get_post_meta(get_the_ID(),'imic_staff_position',true).'</span>';
                                        $post_id = get_post(get_the_ID());
											$content = $post_id->post_content;
											$content = apply_filters('the_content', $content);
											$content = str_replace(']]>', ']]>', $content);
											echo $content;
										if(get_post_meta(get_the_ID(),'imic_display_sermon_url',true)==1) {
											
											if($url!='') {
										echo '<a class="btn btn-primary" href="'.esc_url(add_query_arg('speakers',get_the_ID(),$url)).'">'.__('View all Sermons','framework').'</a>'; } }
                                    echo '</div>
                                </div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>';
		endwhile; echo '</ul>'; wp_reset_query();
		else:
			_e('No Team Member Found','imic-framework-admin');		
		endif;
	   echo $args['after_widget'];
	   if ( ! $this->is_preview() ) {
			$cache[ $args['widget_id'] ] = ob_get_flush();
			wp_cache_set( 'sermon_speakers', $cache, 'widget' );
		} else {
			ob_end_flush();
		}
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("sermon_speakers");'));
?>