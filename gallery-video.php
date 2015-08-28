<?php $video_link = get_post_meta(get_the_ID(),'imic_gallery_video_url',true);
global $column_class, $home_page; 
if($video_link!='') { 
$post_format_temp =get_post_format(get_the_ID());
$post_format =!empty($post_format_temp)?$post_format_temp:'image';
				$term_slug = get_the_terms(get_the_ID(), 'gallery-category');
				if($home_page=="home") { echo '<li class="format-video">'; $size = '400x400'; } 
				else { $size = '600x400'; 
						echo '<li class=" col-md-'.$column_class.' col-sm-'.$column_class.' grid-item format-'.$post_format.' ';
						if (!empty($term_slug)) {
						foreach ($term_slug as $term) {
						  echo $term->slug.' ';
						}
						} ?>"><?php } ?>
<a href="<?php echo esc_url($video_link); ?>" data-rel="prettyPhoto" class="media-box"><?php the_post_thumbnail($size); ?></a>
</li>
<?php } ?>