<?php
if (!function_exists('imic_register_featured_box')) {
    add_action('admin_init', 'imic_register_featured_box');
    function imic_register_featured_box() {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_';
        $meta_box = array(
            'id' => 'template-home14',
            'title' => __("Featured Area Settings", 'framework'),
            'pages' => array('page'),
            'context' => 'normal',
            'fields' => array(
                array(
					'name' => __('Featured Area Switch', 'framework'),
					'id' => $prefix . 'featured_area_switch',
					'desc' => __("Switch for Featured Area.", 'framework'),
					'type' => 'select',
					'options' => array(
						'0' => __('Disable','framework'),
						'1' => __('Enable','framework'),
				),
				),
				array(
					'name' => __('Featured Layout', 'framework'),
					'id' => $prefix . 'featured_layout',
					'desc' => __("Featured Area Layout.", 'framework'),
					'type' => 'select',
					'options' => array(
						'round' => __('Rounded','framework'),
						'rect' => __('Rectangle','framework'),
				),
				),
				array(
					'name' => __('Featured Area Column', 'framework'),
					'id' => $prefix . 'featured_area_column',
					'desc' => __("Select Column for Featured Area.", 'framework'),
					'type' => 'select',
					'options' => array(
						'4' => __('Three','framework'),
						'3' => __('Four','framework'),
						'6' => __('Two', 'framework'),
				),
				),
				array(
					'name' => __('Featured Hover Effect', 'framework'),
					'id' => $prefix . 'featured_hover_effect',
					'desc' => __("Hover Effect for Featured Area.", 'framework'),
					'type' => 'select',
					'options' => array(
						'1' => __('Yes','framework'),
						'0' => __('No','framework'),
				),
				),
            )
        );
        new RW_Meta_Box($meta_box);
    }
}
add_action( 'admin_init', 'add_fields_clone' );
add_action( 'save_post', 'imic_update_fields_data', 10, 2 );
/**
 * Add custom Meta Box to Posts post type
 */
function add_fields_clone() 
{
    add_meta_box('template-home12',__('Featured Section','framework'),'imic_feilds_output','page','normal','core');
}
/**
 * Print the Meta Box content
 */
function imic_feilds_output() 
{
    global $post;
	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'featured_block_meta_box', 'featured_block_meta_box_nonce' );
    $feat_data = get_post_meta( $post->ID, 'feat_data', true );
?>
<div id="field_group">
    <div id="field_wrap">
    <?php 
    if ( isset( $feat_data['image_url'] ) ) 
    {
        for( $i = 0; $i < count( $feat_data['image_url'] ); $i++ ) 
        {
        ?>
        <div class="field_row">
          <div class="field_left">
          <div class="form_field">
              <label><?php _e('Title','framework'); ?></label>
              <input type="text"
                     class="meta_feat_title"
                     name="featured[feat_title][]"
                     value="<?php echo esc_html( $feat_data['feat_title'][$i] ); ?>"
              />
            </div>
            <div class="form_field">
              <label><?php _e('Image','framework'); ?></label>
              <input type="text"
                     class="meta_image_url"
                     name="featured[image_url][]"
                     value="<?php echo esc_html( $feat_data['image_url'][$i] ); ?>"
              />
            </div>
            <div class="form_field">
              <label><?php _e('Desc','framework'); ?></label>
              <input type="text"
                     class="meta_image_desc"
                     name="featured[image_desc][]"
                     value="<?php echo esc_html( $feat_data['image_desc'][$i] ); ?>"
              />
            </div>
            <div class="form_field">
              <label><?php _e('Link','framework'); ?></label>
              <input type="text"
                     class="meta_feat_url"
                     name="featured[feat_url][]"
                     value="<?php echo esc_html( $feat_data['feat_url'][$i] ); ?>"
              />
            </div>
          </div>
          <div class="field_right image_wrap">
          <?php $image = wp_get_attachment_image_src( $feat_data['image_url'][$i], '200x125' ); ?>
            <img src="<?php echo $image[0]; ?>" height="125" width="200" />
          </div>
          <div class="field_right">
            <input class="button" type="button" value="<?php _e('Choose Image','framework'); ?>" onclick="add_image(this)" /><br />
            <input class="button" type="button" value="<?php _e('Remove','framework'); ?>" onclick="remove_field(this)" />
          </div>
          <div class="clear" /></div> 
        </div>
        <?php
        } // endif
    } // endforeach
    ?>
    </div>
    <div style="display:none" id="master-row">
    <div class="field_row">
        <div class="field_left">
        <div class="form_field">
                <label><?php _e('Title','framework'); ?></label>
                <input class="meta_feat_title" value="" type="text" name="featured[feat_title][]" />
            </div>
            <div class="form_field">
                <label><?php _e('Image','framework'); ?></label>
                <input class="meta_image_url" value="" type="text" name="featured[image_url][]" />
            </div>
            <div class="form_field">
                <label><?php _e('Desc','framework'); ?></label>
                <input class="meta_image_desc" value="" type="text" name="featured[image_desc][]" />
            </div>
            <div class="form_field">
                <label><?php _e('URL','framework'); ?></label>
                <input class="meta_feat_url" value="" type="text" name="featured[feat_url][]" />
            </div>
        </div>
        <div class="field_right image_wrap">
        </div> 
        <div class="field_right"> 
            <input type="button" class="button" value="<?php _e('Choose Image','framework'); ?>" onclick="add_image(this)" />
            <br />
            <input class="button" type="button" value="<?php _e('Remove','framework'); ?>" onclick="remove_field(this)" /> 
        </div>
        <div class="clear"></div>
    </div>
    </div>
    <div id="add_field_row">
      <input class="button" type="button" value="<?php _e('Add Featured Field','framework'); ?>" onclick="add_field_row();" />
    </div>
</div>
  <?php
}
/**
 * Save post action, process fields
 */
function imic_update_fields_data( $post_id, $post_object ) 
{
	if ( ! isset( $_POST['featured_block_meta_box_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['featured_block_meta_box_nonce'], 'featured_block_meta_box' ) ) {
		return;
	}
    // Doing revision, exit earlier **can be removed**
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
    // Doing revision, exit earlier
    if ( 'revision' == $post_object->post_type )
        return;
    // Verify authenticity
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['featured'] ) ) {
		return;
	}
    if ( $_POST['featured'] ) 
    {
        // Build array for saving post meta
        $feat_data = array();
        for ($i = 0; $i < count( $_POST['featured']['image_url'] ); $i++ ) 
        {
            if ( '' != $_POST['featured']['image_url'][ $i ] ) 
            {
				$feat_data['feat_title'][]  = $_POST['featured']['feat_title'][ $i ];
                $feat_data['image_url'][]  = $_POST['featured']['image_url'][ $i ];
                $feat_data['image_desc'][] = $_POST['featured']['image_desc'][ $i ];
				$feat_data['feat_url'][]  = $_POST['featured']['feat_url'][ $i ];
            }
        }
        if ( $feat_data ) 
            update_post_meta( $post_id, 'feat_data', $feat_data );
        else 
            delete_post_meta( $post_id, 'feat_data' );
    } 
    // Nothing received, all fields are empty, delete option
    else 
    {
        delete_post_meta( $post_id, 'feat_data' );
    }
}
function add_admin_scripts( $hook ) {
    global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'page' === $post->post_type ) {     
            wp_enqueue_script(  'myscript', IMIC_THEME_PATH.'/js/clone_fields.js' );
			wp_enqueue_style(  'myscript', IMIC_THEME_PATH.'/css/clone_fields.css' );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );