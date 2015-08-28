<?php
get_header();
imic_sidebar_position_module();
global $imic_options;
$ids = array();
$term_taxonomy=get_query_var('taxonomy');
$cat_id = get_queried_object()->term_id;
		$cat_image = get_option($term_taxonomy . $cat_id . "_image_term_id");
		$sermon_term_image = ($cat_image!='')?$cat_image:$imic_options['header_image']['url'];
if(have_posts()):while(have_posts()):the_post();
$ids[] = get_the_ID();
endwhile; endif;
$pageSidebar = $imic_options['sermon_term_sidebar'];
if(have_posts()):while(have_posts()):the_post();
							$sermon_date = get_post_meta(get_the_ID(),'imic_sermon_date',true);
							$sermon_dates[] = strtotime($sermon_date.' 23:59');
							endwhile; endif;
							$series = '';
							$start_date = min($sermon_dates);
							$end_date = max($sermon_dates);
$cat = $wp_query->get_queried_object();
$recent_term = get_terms('sermon-category','orderby=id&order=DESC&number=1');
						$recent_term_id='';
                                                if(!empty($recent_term)){
                                                $recent_term_id = $recent_term[0]->term_id;
                                                }
if($recent_term_id==$cat->term_id) { $series = "<span class=\"label label-primary\">Current Series</span>"; }
							else { $series = "<span class=\"label label-primary\">".date_i18n('m/d/y',$start_date)." – ".date_i18n('m/d/y',$end_date)."</span>"; }
?>
<div class="page-header parallax clearfix" style="background-image:url(<?php echo esc_url($sermon_term_image); ?>);">
        <div class="title-subtitle-holder">
        	<div class="title-subtitle-holder-inner">
    			<h2>
                <?php $first = 1; foreach($ids as $id) {
				$vimeo_video = get_post_meta($id,'imic_vimeo_video',true);
				$youtube_video = get_post_meta($id,'imic_youtube_video',true);
				if($vimeo_video!='') {
					$video = $vimeo_video;
				}elseif($youtube_video!='') {
					$video = $youtube_video;
				}else {
					$video = '';
				}
				if($video!='') {
				$icon = ($first==1)?'<i class="icon icon-music-play"></i>':''; ?>
                <a href="<?php echo esc_url($video); ?>" data-rel="prettyPhoto[sermon-video]" data-toggle="tooltip" data-placement="bottom" data-original-title="<?php _e('Watch All Videos','framework'); ?>" class="sermon-series-trailer"><?php echo $icon; ?></a>
                <?php $first++; } } ?>
                </h2>
        	</div>
        </div>
    </div><?php if(function_exists('bcn_display'))
    { ?>
            	<div class="lgray-bg breadcrumb-cont">
    	<div class="container">
        
          	<ol class="breadcrumb">
            	<?php bcn_display(); ?>
          	</ol>
		
        </div>
    </div><?php } ?>
  	<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                	<div class="col-md-9 col-sm-9" id="content-col">
                        <?php echo $series; ?>
                        <div class="sermon-series-description">
                    		<h2 style="text-transform:uppercase;"><?php echo single_term_title("", false); ?></h2>
                        	<p> <?php echo term_description( '', 'sermon-category' ) ?> </p>
                        </div>
                        <ul class="sermons-list">
                        <?php $speakers = array();
							if(have_posts()):while(have_posts()):the_post();
							$speakers[] = get_post_meta(get_the_ID(),'imic_sermon_speaker',false);
							 ?>
                        	<li class="sermon-item format-standard">
                            	<div class="row">
                                	<div class="col-md-5">
                                    	<?php if(has_post_thumbnail()) { ?><a href="<?php the_permalink(); ?>" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php } ?>
                                        <a href="<?php  echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php _e('Watch Sermon','framework'); ?></a>
                                    </div>
                                    <div class="col-md-7">
                                    	<h3><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php the_title(); ?></a></h3>
                                        <span class="meta-data"><i class="fa fa-calendar"></i> <?php echo esc_html(get_the_date(get_option('date_format'),get_the_ID())); ?></span>
                                        <?php echo imic_excerpt(15); ?>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; endif; ?>
                        </ul>
                        <?php imic_pagination(); ?>
                    </div>
                    <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-3 col-sm-3 sidebar" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } else { if(!empty($speakers[1])) { ?>
                    <div class="col-md-3 col-sm-3 sidebar" id="sidebar-col">
                    	<div class="sermon-pastors sidebar-widget widget">
                        	<h3><?php _e('Speakers','framework'); ?></h3>
                            <hr class="sm">
                            <ul class="members-list">
                            <?php $all_speakers = array_unique(call_user_func_array('array_merge',$speakers)); 
							foreach($all_speakers as $speaker) 
							{ 
							$position = get_post_meta($speaker,'imic_staff_position',true);
							echo '<li>';
							if(has_post_thumbnail($speaker)) {
                                	echo get_the_post_thumbnail($speaker,'100x100'); }
                                    echo '<h5>'.get_the_title($speaker).'</h5>';
									if($position!='') {
                                    echo '<span class="meta-data">'.esc_attr($position).'</span>'; }
                                echo '</li>'; 
							} ?> 
                            </ul>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
         	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>