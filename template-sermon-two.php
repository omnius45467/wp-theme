<?php
/*
Template Name: Sermons List/Grid
*/
get_header();
imic_sidebar_position_module();
//Template Banner Functionality
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
//Get Current Sidebar for this page
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$sermons_layout = get_post_meta(get_the_ID(),'imic_sermons_layout_type',true);
$sermons_column = get_post_meta(get_the_ID(),'imic_sermons_columns_layout',true);
$sermons_column = ($sermons_column=='')?3:$sermons_column;
$sermons_desc = get_post_meta(get_the_ID(),'imic_sermons_desc',true);
$sermons_desc = ($sermons_desc=='')?25:$sermons_desc;
$sermons_button = get_post_meta(get_the_ID(),'imic_sermons_button',true);
$sermons_button = ($sermons_button=='')?'Watch Sermon':$sermons_button;
$sermons_category = get_post_meta(get_the_ID(),'imic_advanced_sermons_list_taxonomy',true);
if($sermons_category!=''){
$sermons_categories= get_term_by('id',$sermons_category,'sermon-category');
if(!empty($sermons_categories)){
$sermons_category= $sermons_categories->slug; }} 
$sermons_count = get_post_meta(get_the_ID(),'imic_sermons_count',true);
$sermons_count = ($sermons_count!='')?$sermons_count:10;
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            <div class="row">
            <div class="col-md-<?php echo $class; ?>" id="content-col">
            <?php if(have_posts()):while(have_posts()):the_post();
				the_content();
				echo '<div class="clearfix"></div>';
				endwhile; endif; wp_reset_query(); ?>
			<?php query_posts( array ( 'post_type' => 'sermon', 'sermon-category' => $sermons_category,'posts_per_page' => $sermons_count ) );
if(have_posts()) : ?>
<?php if($sermons_layout == 1){ ?>
            	
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
                        <li class="grid-item col-md-<?php echo $sermons_column; ?> col-sm-6 sermon-item format-standard">
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
                                    <?php foreach($post_author_id as $speaker) {
                                            $sep = ($count<count($post_author_id))?', ':'';
                                            echo '<span class="meta-data"><i class="fa fa-user"></i> '.get_the_title($speaker).$sep.'</span>';
                                    } 
                                            
                                                echo '<div class="page-content">';
                                                echo imic_excerpt($sermons_desc);
                                                echo '</div>';
                                           
                                        ?>
                                </div>
                                <div class="grid-footer clearfix">
                                    <?php
                                        echo '<a href="' . get_permalink() . '" class="btn btn-primary btn-sm pull-right">' . $sermons_button . ' <i class="fa fa-long-arrow-right"></i></a>';
                                    
                                     echo'
                                        <ul class="action-buttons">
                                            <li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Watch Video','framework').'"><i class="icon-video-cam"></i></a></li>
                                            <li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Listen Audio','framework').'"><i class="icon-headphones"></i></a></li>
                                            <li><a href="' . IMIC_THEME_PATH . '/download/download.php?file=' . $download_pdf . '" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Download PDF','framework').'"><i class="icon-download-folder"></i></a></li>
                                        </ul>
                                    ';
                                     ?>
                                </div>
                            </div>
                        </li>
                        <?php endwhile; wp_reset_query(); ?>
                    </ul>
                </div>
<?php } else { ?>
                <ul class="blog-classic-listing">
                	<?php while(have_posts()) : the_post();
						$vimeo_video = get_post_meta(get_the_ID(),'imic_vimeo_video',true);
						$youtube_video = get_post_meta(get_the_ID(),'imic_youtube_video',true);
						$post_author_id = get_post_meta(get_the_ID(),'imic_sermon_speaker',false);
						$download_pdf = get_post_meta(get_the_ID(),'imic_pdf_url',true);
						if ( has_post_thumbnail(get_the_ID()) ) {
							$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );
							$url = wp_get_attachment_image_src( $post_thumbnail_id, '600x400' );
						} ?>
                	<li <?php post_class('post-list-item sermon-item'); ?>>
                        <div class="row">
                            <?php if($vimeo_video!=''||$youtube_video!=''||$url!='') {
                                if($vimeo_video!='') {
                                    $video_code = imic_video_embed($vimeo_video,"500","281"); }
                                elseif($youtube_video!='') {
                                    $video_code = imic_video_embed($youtube_video,"500","281"); }
                                else {
                                    $video_code = '<img src="'.$url[0].'" alt="">'; }
                            ?>
                            <div class="col-md-4 col-sm-4">
                                <div class="latest-sermon-video fw-video post-media">
                                    <?php echo ''.$video_code.''; ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($vimeo_video!=''||$youtube_video!=''||$url!='') { ?><div class="col-md-8 col-sm-8"><?php } else { ?><div class="col-md-12"><?php } ?>
                                <div class="post-excerpt">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <?php foreach($post_author_id as $speaker) {
                                            $sep = ($count<count($post_author_id))?', ':'';
                                            echo '<span class="meta-data"><i class="fa fa-user"></i> '.get_the_title($speaker).$sep.'</span>';
                                    } 
                                            
                                                echo '<div class="page-content">';
                                                echo imic_excerpt($sermons_desc);
                                                echo '</div>';
                                            
                                        ?>
                                        <?php echo'
                                            <ul class="action-buttons">
                                                <li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Watch Video','framework').'"><i class="icon-video-cam"></i></a></li>
                                                <li><a href="'.get_permalink().'" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Listen Audio','framework').'"><i class="icon-headphones"></i></a></li>
                                                <li><a href="' . IMIC_THEME_PATH . '/download/download.php?file=' . $download_pdf . '" data-toggle="tooltip" data-placement="top" data-original-title="'.__('Download PDF','framework').'"><i class="icon-download-folder"></i></a></li>
                                            </ul>
                                        <br>'; 
                                        
                                            echo '<a href="' . get_permalink() . '" class="btn btn-primary btn-sm">' . $sermons_button . ' <i class="fa fa-long-arrow-right"></i></a>';
                                        
                                         ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endwhile; wp_reset_query(); ?>
                </ul>
<?php } ?>
                <?php endif; ?>
                </div>
                <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo $sidebar_column; ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
            </div>
           	</div>
     	</div>
 	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>