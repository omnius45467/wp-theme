<?php
$the_categories = wp_kses_post($instance['categories']);
$post_title = wp_kses_post($instance['title']);
$numberPosts = (!empty($instance['number_of_posts']))? $instance['number_of_posts'] : 4 ;
$read_more_text = wp_kses_post($instance['read_more_text']);
$allpostsbtn = wp_kses_post($instance['allpostsbtn']);
$allpostsurl = sow_esc_url($instance['allpostsurl']);
?>
<?php query_posts( array ( 'post_type' => 'post', 'category_name' => ''. $the_categories .'', 'posts_per_page' => $numberPosts ) );
if(have_posts()) : 
if(!empty($instance['title'])){ ?>
<?php if(!empty($instance['allpostsurl'])){ ?><a href="<?php echo $allpostsurl; ?>" class="btn btn-default pull-right"><?php echo $allpostsbtn; ?></a><?php } ?>
<h3 class="panel-title">
<?php echo $post_title; ?>
</h3>
<?php } ?>
<ul class="blog-classic-listing">
<?php while(have_posts()) : the_post();
$title = '<h3 class="post-title"><a href="'.esc_url(get_permalink(get_the_ID())).'">'.get_the_title().'</a></h3>';
$post_author_id = get_post_field( 'post_author', get_the_ID() );
$meta_data = '<span class="meta-data"><i class="fa fa-calendar"></i> '.esc_html(get_the_date()).__(' by ','framework').'<a href="'. esc_url(get_author_posts_url($post_author_id)).'">'.esc_attr(get_the_author_meta( 'display_name', $post_author_id )).'</a></span>';
$content = imic_excerpt();
if ( has_post_thumbnail() ) {
	$image .= '<div class="post-media">
   	<a href="'.esc_url(get_permalink(get_the_ID())).'" class="media-box">'.get_the_post_thumbnail(get_the_ID(),$image_size,array('class'=>'post-thumb')).'</a>
  	</div>'; }
$post_format_temp =get_post_format();
$post_format =!empty($post_format_temp)?$post_format_temp:'image';
if($post_format=="image") { ?>
<li <?php post_class('post-list-item format-image'); ?>>
	<div class="row">
    	<?php if ( has_post_thumbnail() ) { ?>
		<div class="col-md-4">
			<?php echo $image; ?>
		</div>
        <?php } ?>
		<?php if ( has_post_thumbnail() ) { ?><div class="col-md-8"><?php } else { ?><div class="col-md-12"><?php } ?>
            <div class="post-excerpt">
                <?php if(!empty($instance['show_post_meta'])){ ?><?php echo $meta_data; ?><?php } ?>
                <?php echo $title; ?>
                <?php if(!empty($instance['excerpt_length'])){ ?><?php echo $content; ?><?php } ?>
                <?php if(!empty($instance['show_post_meta'])){ ?><span class="meta-data post-cats"><?php the_category('| '); if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></span><?php } ?>
                <?php if($read_more_text!=""){ ?><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php echo $read_more_text; ?></a><?php } ?>
            </div>
     	</div>
	</div>
</li>
<?php }
elseif($post_format=="gallery") {
	$gallery = '';
	$image_data=  get_post_meta(get_the_ID(),'imic_gallery_images',false);
	$gallery .=  imic_gallery_flexslider(get_the_ID());     
	if (count($image_data) > 0) {
	$gallery .= '<ul class="slides">';
	foreach ($image_data as $custom_gallery_images) {
	$large_src = wp_get_attachment_image_src($custom_gallery_images, 'full');
	$gallery .= '<li class="item"><a href="' . esc_url($large_src[0]) . '" data-rel="prettyPhoto[' . get_the_title() . ']">';
	$gallery .= wp_get_attachment_image($custom_gallery_images, '600x400');
	$gallery .= '</a></li>';
	}
	$gallery .= '</ul>'; }
	$gallery .= '</div>'; ?>
<li <?php post_class('post-list-item format-gallery'); ?>>
	<div class="row">
    	<?php if($image_data != ""){ ?>
		<div class="col-md-4">
            <div class="post-media">
              <?php echo $gallery; ?>
            </div>
       	</div>
        <?php } ?>
		<?php if($image_data != ""){ ?><div class="col-md-8"><?php } else { ?><div class="col-md-12"><?php } ?>
            <div class="post-excerpt">
                <?php if(!empty($instance['show_post_meta'])){ ?><?php echo $meta_data; ?><?php } ?>
                <?php echo $title; ?>
                <?php if(!empty($instance['excerpt_length'])){ ?><?php echo $content; ?><?php } ?>
                <?php if(!empty($instance['show_post_meta'])){ ?><span class="meta-data post-cats"><?php the_category('| '); if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></span><?php } ?>
                <?php if($read_more_text!=""){ ?><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php echo $read_more_text; ?></a><?php } ?>
            </div>
      	</div>
  	</div>
</li>
<?php }
elseif($post_format=="link") { ?>
<li <?php post_class('post-list-item format-link'); ?>>
	<div class="row">
    	<?php if ( has_post_thumbnail() ) { ?>
		<div class="col-md-4">
            <div class="post-media">
                <?php echo $image; ?>
            </div>
		</div>	
		<?php } ?>
		<?php if ( has_post_thumbnail() ) { ?><div class="col-md-8"><?php } else { ?><div class="col-md-12"><?php } ?>
            <div class="post-excerpt">
                <?php if(!empty($instance['show_post_meta'])){ ?><?php echo $meta_data; ?><?php } ?>
                <?php echo $title; ?>
                <?php if(!empty($instance['excerpt_length'])){ ?><?php echo $content; ?><?php } ?>
                <?php if(!empty($instance['show_post_meta'])){ ?><span class="meta-data post-cats"><?php the_category('| '); if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></span><?php } ?>
                <?php if($read_more_text!=""){ ?><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php echo $read_more_text; ?></a><?php } ?>
            </div>
       	</div>
   	</div>
</li>
<?php }
elseif($post_format=="audio") {
$audio_url = get_post_meta(get_the_ID(),'imic_gallery_uploaded_audio',true);
if (strpos($audio_url, 'soundcloud') > 0) {
	$data = imic_audio_soundcloud($audio_url,"100%",250);
}
else {
	$data = '<audio class="audio-player" src="'.esc_url($audio_url).'" type="audio/mp3" controls></audio>';
} ?>
<li <?php post_class('post-list-item format-audio'); ?>>
	<div class="row">
    	<?php if($audio_url != ""){ ?>
		<div class="col-md-4">
            <div class="post-media">
                <?php echo $data; ?>
            </div>
       	</div>
        <?php } ?>
		<?php if($audio_url != ""){ ?><div class="col-md-8"><?php } else { ?><div class="col-md-12"><?php } ?>
            <div class="post-excerpt">
                <?php if(!empty($instance['show_post_meta'])){ ?><?php echo $meta_data; ?><?php } ?>
                <?php echo $title; ?>
                <?php if(!empty($instance['excerpt_length'])){ ?><?php echo $content; ?><?php } ?>
                <?php if(!empty($instance['show_post_meta'])){ ?><span class="meta-data post-cats"><?php the_category('| '); if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></span><?php } ?>
                <?php if($read_more_text!=""){ ?><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php echo $read_more_text; ?></a><?php } ?>
            </div>
       	</div>
    </div>
</li>
<?php }
elseif($post_format=="video") {
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
} } ?>
<li <?php post_class('post-list-item format-video'); ?>>
	<div class="row">
    	<?php if($video_option != ""){ ?>
		<div class="col-md-4">
            <div class="post-media">
                <?php echo $video_code; ?>
            </div>
       	</div>
        <?php } ?>
		<?php if($video_option != ""){ ?><div class="col-md-8"><?php } else { ?><div class="col-md-12"><?php } ?>
            <div class="post-excerpt">
                <?php if(!empty($instance['show_post_meta'])){ ?><?php echo $meta_data; ?><?php } ?>
                <?php echo $title; ?>
                <?php if(!empty($instance['excerpt_length'])){ ?><?php echo $content; ?><?php } ?>
                <?php if(!empty($instance['show_post_meta'])){ ?><span class="meta-data post-cats"><?php the_category('| '); if (comments_open()) { echo comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%','pull-right meta-data', 'comments-link',__('Comments are off for this post','framework')); } ?></span><?php } ?>
                <?php if($read_more_text!=""){ ?><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php echo $read_more_text; ?></a><?php } ?>
            </div>
       	</div>
   	</div>
</li>
<?php } ?>
<?php endwhile; wp_reset_query(); ?>
</ul>
<?php endif; ?>