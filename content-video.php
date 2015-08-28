<?php
global $blog_masonry, $grid_column;
$video_code = '';
$video_option = get_post_meta(get_the_ID(),'imic_post_video_option',true);
if($video_option==1) { 
$video_url = get_post_meta(get_the_ID(),'imic_gallery_video_url',true);
$video_code = imic_video_embed($video_url,"500","281");
}
else {
$mp4_video = get_post_meta(get_the_ID(),'imic_post_mp4_video',false);
$webm_video = get_post_meta(get_the_ID(),'imic_post_webm_video',false);
$ogg_video = get_post_meta(get_the_ID(),'imic_post_ogg_video',false);
if(!empty($mp4_video)||!empty($webm_video)||!empty($ogg_video)) {
$self_video = array($mp4_video,$webm_video,$ogg_video);
if ( has_post_thumbnail(get_the_ID()) ) {
$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
$url = wp_get_attachment_image_src( $post_thumbnail_id ); }
if ( has_post_thumbnail(get_the_ID()) ) {
$video_code .= '<video width="640" height="360" id="player2" poster="'.$url[0].'" class="video-player" controls preload="none">'; } 
$video_type = array('mp4','webm','ogg');
$i=0;
foreach($self_video as $video_url) {
	foreach($video_url as $url) {
     	$video_code .= '<source type="video/'.$video_type[$i].'" src="'.esc_url($url).'" />';
	}
	$i++;
}
$video_code .= '<object width="640" height="360" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/vendor/mediaelement/flashmediaelement.swf"> 		
<param name="movie" value="'.get_template_directory_uri().'/vendor/mediaelement/flashmediaelement.swf" /> 
<param name="flashvars" value="controls=true&amp;file='.$mp4_video[0].'" />'. 		
get_the_post_thumbnail(get_the_ID(),'600x400').'
</object> 	
</video>';
} }
$title = '<h3 class="post-title"><a href="'.esc_url(get_permalink(get_the_ID())).'">'.get_the_title().'</a></h3>';
$post_author_id = get_post_field( 'post_author', get_the_ID() );
$meta_data = '<span class="meta-data"><i class="fa fa-calendar"></i> '.esc_html(get_the_date()).__(' by ','framework').'<a href="'. esc_url(get_author_posts_url($post_author_id)).'">'.esc_attr(get_the_author_meta( 'display_name', $post_author_id )).'</a></span>';
$content = imic_excerpt();
if($blog_masonry==0) { 
?>
<article <?php post_class('post-list-item format-video'); ?>>
                            	<div class="post-media">
                                    <?php echo $video_code; ?>
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
                            <div class="post-media fw-video">
                                <?php echo $video_code; ?>
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
<li class="col-md-<?php echo $grid_column; ?> col-sm-6 blog-item grid-item format-video">
                            <div class="grid-item-inner">
                            	<div class="post-media">
                                    <?php echo $video_code; ?>
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