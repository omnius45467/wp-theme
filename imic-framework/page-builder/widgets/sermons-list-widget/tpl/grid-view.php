<?php
$the_categories = wp_kses_post($instance['categories']);
$post_title = wp_kses_post($instance['title']);
$numberPosts = (!empty($instance['number_of_posts']))? $instance['number_of_posts'] : 4 ;
$read_more_text = wp_kses_post($instance['read_more_text']);
$excerpt_length = wp_kses_post($instance['excerpt_length']);
$allpostsbtn = wp_kses_post($instance['allpostsbtn']);
$allpostsurl = sow_esc_url($instance['allpostsurl']);
?>
<?php query_posts( array ( 'post_type' => 'sermon', 'sermon-category' => $the_categories, 'posts_per_page' => $numberPosts ) );
if(have_posts()) : 
if(!empty($instance['title'])){ ?>
<?php if(!empty($instance['allpostsurl'])){ ?><a href="<?php echo $allpostsurl; ?>" class="btn btn-default pull-right"><?php echo $allpostsbtn; ?></a><?php } ?>
<h3 class="panel-title">
<?php echo $post_title; ?>
</h3>
<?php } ?>
<div class="row">
<ul class="isotope-grid">
<?php while(have_posts()) : the_post();
$vimeo_video = get_post_meta(get_the_ID(),'imic_vimeo_video',true);
$youtube_video = get_post_meta(get_the_ID(),'imic_youtube_video',true);
$post_author_id = get_post_meta(get_the_ID(),'imic_sermon_speaker',false);
$download_pdf = get_post_meta(get_the_ID(),'imic_pdf_url',true);
if ( has_post_thumbnail(get_the_ID()) ) {
	$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
	$url = wp_get_attachment_image_src( $post_thumbnail_id, '600x400' );
} ?>
<li class="grid-item col-md-<?php echo $layout_type['column']; ?> col-sm-6 sermon-item format-standard">
	<div class="grid-item-inner">
			<?php if($vimeo_video!=''||$youtube_video!=''||$url!='') {
			if($vimeo_video!='') {
		  		$video_code = imic_video_embed($vimeo_video,"500","281"); }
		  	elseif($youtube_video!='') {
			  	$video_code = imic_video_embed($youtube_video,"500","281"); }
		  	else {
			  	$video_code = '<img src="'.$url[0].'" alt="">'; }
		?>
            <div class="post-media">
            	<div class="latest-sermon-video fw-video post-media">
                <?php echo ''.$video_code.''; ?>
                </div>
            </div>
        <?php } ?>
		<div class="grid-content">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php if($instance['show_post_meta']){ foreach($post_author_id as $speaker) {
                    $sep = ($count<count($post_author_id))?', ':'';
                    echo '<span class="meta-data"><i class="fa fa-user"></i> '.get_the_title($speaker).$sep.'</span>';
            } }
                    if($excerpt_length!=""){
                        echo '<div class="page-content">';
                        echo imic_excerpt($excerpt_length);
                        echo '</div>';
                    }
                ?>
       	</div>
		<div class="grid-footer clearfix">
            <?php if($read_more_text!=""){
                echo '<a href="' . get_permalink() . '" class="btn btn-primary btn-sm pull-right">' . $read_more_text . ' <i class="fa fa-long-arrow-right"></i></a>';
            }
			if($instance['show_post_meta']){ echo'
                <ul class="action-buttons">
                    <li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Watch Video','framework').'"><i class="icon-video-cam"></i></a></li>
                    <li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Listen Audio','framework').'"><i class="icon-headphones"></i></a></li>
                    <li><a href="' . IMIC_THEME_PATH . '/download/download.php?file=' . $download_pdf . '" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Download PDF','framework').'"><i class="icon-download-folder"></i></a></li>
                </ul>
            '; }
             ?>
        </div>
	</div>
</li>
<?php endwhile; wp_reset_query(); ?>
</ul>
</div>
<?php endif; ?>