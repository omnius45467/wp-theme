<?php global $column_class, $home_page; 
$post_format_temp =get_post_format(get_the_ID());
$post_format =!empty($post_format_temp)?$post_format_temp:'image';
				$term_slug = get_the_terms(get_the_ID(), 'gallery-category');
				if($home_page=="home") { echo '<li class="format-standard">'; $size = '400x400'; } 
				else { $size = '600x400';
				echo '<li class=" col-md-'.$column_class.' col-sm-'.$column_class.' grid-item format-'.$post_format.' ';
						if (!empty($term_slug)) {
						foreach ($term_slug as $term) {
						  echo $term->slug.' ';
						}
						} ?>">
						
                    <?php } $image_data=  get_post_meta(get_the_ID(),'imic_gallery_images',false);
						echo imic_gallery_flexslider(get_the_ID());     
						if (count($image_data) > 0) {
						echo '<ul class="slides">';
						foreach ($image_data as $custom_gallery_images) {
						$large_src = wp_get_attachment_image_src($custom_gallery_images, 'full');
						echo'<li class="item"><a href="' . esc_url($large_src[0]) . '" data-rel="prettyPhoto[' . get_the_title() . ']">';
						echo wp_get_attachment_image($custom_gallery_images, $size);
						echo'</a></li>';
						}
						echo '</ul>'; } ?>
               	</div>
          	</li>