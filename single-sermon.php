<?php get_header();
imic_sidebar_position_module();
if(is_home()) { $id = get_option('page_for_posts'); }
else { $id = get_the_ID(); }
$page_header = get_post_meta($id,'imic_pages_Choose_slider_display',true);
if($page_header==3) {
	get_template_part( 'pages', 'flex' );
}
elseif($page_header==4) {
	get_template_part( 'pages', 'nivo' );
}
elseif($page_header==5) {
	get_template_part( 'pages', 'revolution' );
}
elseif($page_header==6) {
	get_template_part( 'pages', 'layer' );
}
else {
	get_template_part( 'pages', 'banner' );
}
$term_slug = $term_url = '';
$speakers = get_post_meta(get_the_ID(),'imic_sermon_speaker',false);
//print_r($speaker);
$term = wp_get_object_terms( get_the_ID(), 'sermon-category', array( 'count' => '1' ) );
$sermon_tags = wp_get_object_terms(get_the_ID(), 'sermon-tag');
if(!empty($term)) { $term_slug = $term[0];
$term_url = get_term_link( $term_slug, 'sermon-category' ); }
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if((!empty($pageSidebar)&&is_active_sidebar($pageSidebar))||(!empty($term)||!empty($sermon_tags)||!empty($speakers))) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$mp4_video = get_post_meta(get_the_ID(),'imic_mp4_video',false);
$webm_video = get_post_meta(get_the_ID(),'imic_webm_video',false);
$ogg_video = get_post_meta(get_the_ID(),'imic_ogg_video',false);
$self_video = array($mp4_video,$webm_video,$ogg_video);
$vimeo_video = get_post_meta(get_the_ID(),'imic_vimeo_video',true);
$youtube_video = get_post_meta(get_the_ID(),'imic_youtube_video',true);
$self_audio = get_post_meta(get_the_ID(),'imic_self_audio',true);
$soundcloud_audio = get_post_meta(get_the_ID(),'imic_soundcloud_audio',true);
$download_pdf = get_post_meta(get_the_ID(),'imic_pdf_url',true);
$audio_desc = get_post_meta(get_the_ID(),'imic_audio_desc',true);
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                	<div class="col-md-<?php echo $class; ?>" id="content-col"><?php if($term_url!='') { ?>
                    	
                    	<a href="<?php echo $term_url; ?> " class="basic-link backward"><?php _e('Back to series','framework'); ?></a><?php } ?>
                    	<div class="sermon-media clearfix">
                        <?php if(!empty($mp4_video)||!empty($webm_video)||!empty($ogg_video)||$vimeo_video!=''||$youtube_video!=''||$self_audio!=''||$soundcloud_audio!=''||$download_pdf!='') { ?>
                        	<div class="sermon-media-left sermon-links">
                                <ul class="action-buttons">
                                <?php if(!empty($mp4_video)||!empty($webm_video)||!empty($ogg_video)) { 
                                    echo '<li class="link"><a rel="self_video" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Self Hosted Video','framework').'"><i class="icon-video-cam"></i></a></li>'; }
                                    if($vimeo_video!='') { 
                                    echo '<li class="link"><a rel="vimeo_video" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Vimeo Video','framework').'"><i class="fa fa-vimeo-square"></i></a></li>'; }
                                    if($youtube_video!='') { 
									echo '<li class="link"><a rel="youtube_video" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Youtube Video','framework').'"><i class="fa fa-youtube-play"></i></a></li>'; }
									if($self_audio!='') { 
                                    echo '<li class="link"><a rel="self_audio" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Self Hosted Audio','framework').'"><i class="icon-headphones"></i></a></li>'; }
									if($soundcloud_audio!='') { 
                                    echo '<li class="link"><a rel="soundcloud_audio" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" data-original-title="'.__('SoundCloud Audio','framework').'"><i class="fa fa-soundcloud"></i></a></li>'; }
									if($download_pdf!='') { 
                                    echo '<li><a href="' . IMIC_THEME_PATH . '/download/download.php?file=' . $download_pdf . '" data-toggle="tooltip" data-placement="right" data-original-title="'.__('Download PDF','framework').'"><i class="icon-cloud-download"></i></a></li>'; } ?>
                                </ul>
                          	</div>
                            <?php } ?>
                            <div class="sermon-media-right">
                            <?php if($self_video!=''||$vimeo_video!=''||$youtube_video!=''||$self_audio!=''||$soundcloud_audio!=''||$download_pdf!='') { ?>
                            	<div class="sermon-media-content">
                                <?php //Start Self Hosted Video 
									if(!empty($mp4_video)||!empty($webm_video)||!empty($ogg_video)) {
									if ( has_post_thumbnail(get_the_ID()) ) {
									$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
									$url = wp_get_attachment_image_src( $post_thumbnail_id, '600x400' ); } ?>
                                    <!-- MP4 source must come first for iOS -->
                                    <!-- WebM for Firefox 4 and Opera -->
                                    <!-- OGG for Firefox 3 -->
                                    <div class="sermon-tabs" id="self_video">
                                    <?php if ( has_post_thumbnail(get_the_ID()) ) { ?>
                                        <video width="640" height="360" id="player2" poster="<?php echo esc_url($url[0]); ?>" class="self-video-player" controls preload="none"><?php } 
										$video_type = array('mp4','webm','ogg');
										$i=0;
										foreach($self_video as $video_url) {
											foreach($video_url as $url) {
                                            echo '<source type="video/'.$video_type[$i].'" src="'.esc_url($url).'" />';
											}
											$i++;
										} ?>
                                            <!-- Fallback flash player for no-HTML5 browsers with JavaScript turned off -->
                                            <object width="640" height="360" type="application/x-shockwave-flash" data="<?php echo get_template_directory_uri(); ?>/vendor/mediaelement/flashmediaelement.swf"> 		
                                                <param name="movie" value="<?php echo get_template_directory_uri(); ?>/vendor/mediaelement/flashmediaelement.swf" /> 
                                                <param name="flashvars" value="controls=true&amp;file=<?php echo $mp4_video[0]; ?>" /> 		
                                                <!-- Image fall back for non-HTML5 browser with JavaScript turned off and no Flash player installed -->
                                                <?php the_post_thumbnail('600x400'); ?>
                                            </object> 	
                                        </video>
                                    </div>
                                    <?php } //End Self Hosted Video 
									if($vimeo_video!='') { 
									$vimeo_video_code = imic_video_embed($vimeo_video,"500","281"); ?>
                                    <div class="video-container fw-video sermon-tabs" id="vimeo_video">
                                        <?php echo $vimeo_video_code; ?>
                                    </div>
                                    <?php } 
									if($youtube_video!='') { 
									$youtube_video_code = imic_video_embed($youtube_video,"560","315"); ?>
                                    <div class="video-container fw-video sermon-tabs" id="youtube_video">
                                        <?php echo $youtube_video_code; ?>
                                    </div>
                                    <?php }
									if($self_audio!='') { ?>
                                    <div class="audio-container sermon-tabs" id="self_audio">
                                        <audio class="self-audio-player" src="<?php echo $self_audio; ?>" type="audio/mp3" controls></audio>
                                        <blockquote>
                                            <?php echo do_shortcode($audio_desc); ?>
                                        </blockquote>
                                    </div>
                                    <?php }
									if($soundcloud_audio!='') {
										$soundcloud_audio_code = imic_audio_soundcloud($soundcloud_audio,"100%",450); ?>
                                    <div class="audio-container sermon-tabs" id="soundcloud_audio">
                                        <?php echo $soundcloud_audio_code; ?>
                                    </div>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                                <?php if(have_posts()):while(have_posts()):the_post(); the_content(); endwhile; endif; ?>
                                <?php if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['4'] == '1') { ?>
								<?php imic_share_buttons(); ?>
                            <?php } ?>
                          	</div>
                       	</div>
                    </div>
                    <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo $sidebar_column; ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } else { if(!empty($term)||!empty($sermon_tags)||!empty($speakers)) { ?>
                    <div class="col-md-<?php echo $sidebar_column; ?>" id="sidebar-col">
                    <?php if(!empty($term)) { ?>
                    <div class="widget sidebar-widget widget_categories">
                        	<h3 class="widgettitle"><?php _e('Categories','framework'); ?></h3>
                            <ul>
                            <?php foreach($term as $tm) {
								echo '<li><a href="'.get_term_link($tm->slug,'sermon-category').'">'.$tm->name.'</a></li>';
							} ?>
              				</ul>
                        </div><?php } if(!empty($sermon_tags)) { ?>
                        <div class="widget sidebar-widget widget_tag_cloud">
                            <h3 class="widgettitle"><?php _e('Tags','framework'); ?></h3>
                          	<div class="tag-cloud">
                            <?php foreach($sermon_tags as $tag) {
								echo '<a href="'.get_term_link($tag->slug,'sermon-tag').'">'.$tag->name.'</a>';
							} ?>
                          	</div>
                        </div><?php } if(!empty($speakers)) { ?>
                    	<div class="widget sidebar-widget widget_sermon_speakers">
                        	<h3 class="widgettitle"><?php _e('Speakers','framework'); ?></h3>
              				<ul>
                            	<?php foreach($speakers as $speaker) { $position = get_post_meta($speaker,'imic_staff_position',true);
		echo '<li>';
		if ( '' != get_the_post_thumbnail($speaker) ) { echo get_the_post_thumbnail($speaker,'100x100'); }
                                    echo '<div class="people-info">
                                    	<h5 class="people-name"><a data-toggle="modal" data-target="#team-modal-'.($speaker+2648).'" href="#" class="">'.get_the_title($speaker).'</a></h5>
                                    	<span class="meta-data">'.$position.'</span>
                                   	</div>
                               	';
		echo '</li><div class="modal fade team-modal" id="team-modal-'.($speaker+2648).'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                    	'.get_the_post_thumbnail($speaker,'600x400',array('class'=>'img-thumbnail')).'
                                    </div>
                                    <div class="col-md-7 col-sm-6">
                                    	<h3>'.get_the_title($speaker).'</h3>
                                    	<span class="meta-data">'.get_post_meta($speaker,'imic_staff_position',true).'</span>';
                                        $post_id = get_post($speaker);
											$content = $post_id->post_content;
											$content = apply_filters('the_content', $content);
											$content = str_replace(']]>', ']]>', $content);
											echo $content;
										if(get_post_meta($speaker,'imic_display_sermon_url',true)==1) {
											$url = imic_get_template_url('template-speakers-sermon.php');
											if($url!='') {
										echo '<a class="btn btn-primary" href="'.esc_url(add_query_arg('speakers',$speaker,$url)).'">'.__('View all Sermons','framework').'</a>'; } }
                                    echo '</div>
                                </div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>'; } ?>
              				</ul>
                    </div><?php } ?>
                    </div>
                    <?php } } ?>
                </div>
         	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>