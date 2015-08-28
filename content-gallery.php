<?php global $blog_masonry, $grid_column; 
$gallery = '';
$title = '<h3 class="post-title"><a href="'.esc_url(get_permalink(get_the_ID())).'">'.get_the_title().'</a></h3>';
$post_author_id = get_post_field( 'post_author', get_the_ID() );
$meta_data = '<span class="meta-data"><i class="fa fa-calendar"></i> '.esc_html(get_the_date()).__(' by ','framework').'<a href="'. esc_url(get_author_posts_url($post_author_id)).'">'.esc_attr(get_the_author_meta( 'display_name', $post_author_id )).'</a></span>';
$content = imic_excerpt();
$image_data=  get_post_meta(get_the_ID(),'imic_gallery_images',false);
								    $gallery .=  imic_gallery_flexslider(get_the_ID());     
						if (count($image_data) > 0) {
						$gallery .= '<ul class="slides">';
						foreach ($image_data as $custom_gallery_images) {
						$large_src = wp_get_attachment_image_src($custom_gallery_images, '1000x800');
						$gallery .= '<li class="item"><a href="' . esc_url($large_src[0]) . '" data-rel="prettyPhoto[' . get_the_title() . ']">';
						$gallery .= wp_get_attachment_image($custom_gallery_images, '600x400');
						$gallery .= '</a></li>';
						}
						$gallery .= '</ul>'; }
               	$gallery .= '</div>';
if($blog_masonry==0) { ?>
<article <?php post_class('post-list-item format-gallery'); ?>>
                            	<div class="post-media">
                                  <?php echo $gallery; ?>
                                </div>
                                <div class="post-excerpt">
                               		<?php echo $meta_data; ?>
                                	<?php echo $title; ?>
                              		<?php echo $content; ?>
                                    <span class="meta-data post-cats"><?php the_category('| '); if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></span>
                               		<a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php _e('Continue reading','framework'); ?></a>
                                </div>
                            </article>
<?php } elseif($blog_masonry==2) {
$title_single = '<h3 class="post-title">'.get_the_title().'</h3>'; ?>
<div class="title-row">
<?php if (comments_open()) { echo comments_popup_link('<i class="icon-dialogue-text"></i>'.__('','framework'), '<i class="icon-dialogue-text"></i>', '<i class="icon-dialogue-text"></i>','comments-go', 'comments-link',__('','framework')); } ?>
<h2><?php echo $title_single; ?></h2></div>
                           	<div class="meta-data">
                            	<?php echo $meta_data; ?>
                            	<span><i class="fa fa-archive"></i> <?php the_category(', '); ?></span>
                           	</div>
                            <div class="post-media">
                                <?php echo $gallery; ?>
                            </div>
                            <div class="post-content">
                                <?php the_content(); ?>
                            </div>
                            <?php if (has_tag()) {
									echo'<div class="meta-data post-tags">';
									echo'<i class="fa fa-tags"></i> ';
									the_tags('', ', ');
									echo'</div>';
								} ?>
<?php } else { ?>
<li class="col-md-<?php echo $grid_column; ?> col-sm-6 blog-item grid-item format-gallery">
                            <div class="grid-item-inner">
                            	<div class="post-media">
                                    <?php echo $gallery; ?>
                                </div>
                                <div class="grid-content">
                                	<?php echo $title; ?>
                              		<?php echo $content; ?>
                               		<?php echo $meta_data; ?>
                                </div>
                                <div class="grid-footer clearfix">
                                	<?php if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?>
                            		<a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php _e('Read post','framework'); ?></a>
                                </div>
                            </div>
                        </li>
<?php } ?>