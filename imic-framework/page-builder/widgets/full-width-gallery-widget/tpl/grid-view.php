<?php
$the_categories = wp_kses_post($instance['categories']);
$post_title = wp_kses_post($instance['title']);
$grid_column = (!empty($instance['grid_column']))? $instance['grid_column'] : 5 ;
$numberPosts = (!empty($instance['number_of_posts']))? $instance['number_of_posts'] : 5 ;
?>
<?php query_posts(array('post_type' => 'gallery', 'gallery-category' => $the_categories, 'posts_per_page' => $numberPosts));
	if(have_posts()): ?>
<div class="gallery-updates cols<?php echo $grid_column; ?> clearfix">
    <ul>
		<?php while(have_posts()) : the_post();
        $thumb_id=get_post_thumbnail_id(get_the_ID());
        $post_format_temp =get_post_format();
        $post_format =!empty($post_format_temp)?$post_format_temp:'image';
        $term_slug = get_the_terms(get_the_ID(), 'gallery-category');
        echo '<li format-'.$post_format.' ';
            if (!empty($term_slug)) {
            foreach ($term_slug as $term) {
              echo $term->slug.' ';
            }
            } ?>">
            <?php switch (get_post_format()) {
            case 'image': ?>
            
            <?php if ( '' != get_the_post_thumbnail() ) { 
                    $image_id = get_post_thumbnail_id(get_the_ID()); 
                    $image = wp_get_attachment_image_src($image_id,'full',''); ?>
                <a href="<?php echo esc_url($image[0]); ?>" data-rel="prettyPhoto" class="media-box">
                    <?php the_post_thumbnail('800x600'); ?>
                </a><?php } ?>
            
            <?php 
            break;
            case 'gallery': ?>
            
            <?php $image_data=  get_post_meta(get_the_ID(),'imic_gallery_images',false);
                echo imic_gallery_flexslider(get_the_ID());     
                if (count($image_data) > 0) {
                echo '<ul class="slides">';
                foreach ($image_data as $custom_gallery_images) {
                $large_src = wp_get_attachment_image_src($custom_gallery_images, 'full');
                echo'<li class="item"><a href="' . esc_url($large_src[0]) . '" data-rel="prettyPhoto[' . get_the_title() . ']">';
                echo wp_get_attachment_image($custom_gallery_images, $size);
                echo'</a></li>';
                }
                echo '</ul>'; } echo '</div>'; ?>
            
            <?php break;
            case 'link':
            $link_url = get_post_meta(get_the_ID(),'imic_gallery_link_url',true);
            if (!empty($link_url)) {
            echo '<a href="' . $link_url . '" target="_blank" class="media-box">';
            the_post_thumbnail('800x600');
            echo'</a>';
            }
            break;
            case 'video':
            $video_url = get_post_meta(get_the_ID(),'imic_gallery_video_url',true);
            if (!empty($video_url)) {
            echo '<a href="' . $video_url . '" data-rel="prettyPhoto" class="media-box">';
            the_post_thumbnail('800x600');
            echo'</a>';
            }
            break;
            default:
            if(!empty($thumb_id)){
            $large_src_i = wp_get_attachment_image_src($thumb_id, 'full');
            echo'<a href="' . $large_src_i[0] . '" data-rel="prettyPhoto" class="media-box">';
            the_post_thumbnail('800x600');
            echo'</a>';
            }
            break;
            } ?>
        </li>
        <?php endwhile; ?>
    </ul>
<?php endif; ?>
<?php if($post_title!='') { ?>
<div class="gallery-updates-overlay">
	<div class="container">
		<?php if( !empty($instance['icon_image']) ) {
			$attachment = wp_get_attachment_image_src($instance['icon_image']);
			if(!empty($attachment)) {
				$icon_styles[] = 'background-image: url(' . sow_esc_url($attachment[0]) . ')';
				if(!empty($instance['icon_size'])) $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';
		
				?><div class="sow-icon-image" style="<?php echo implode('; ', $icon_styles) ?>"></div><?php
			}
		}
		else {
			$icon_styles = array();
			if(!empty($instance['icon_size'])) $icon_styles[] = 'font-size: '.intval($instance['icon_size']).'px';
		
			echo siteorigin_widget_get_icon($instance['icon'], $icon_styles);
		} ?>
		<h2><?php echo esc_attr($post_title); ?></h2>
	</div>
</div>
<?php } ?>
</div>