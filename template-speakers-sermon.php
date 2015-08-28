<?php
/*
Template Name: Sermons by Speaker
*/
get_header();
imic_sidebar_position_module();
global $imic_options;
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
	get_template_part('pages', 'layer');
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
query_posts(array('post_type'=>'sermon','meta_query'=>array(array('key'=>'imic_sermon_speaker','value'=>get_query_var('speakers'),'compare'=>'LIKE'))));
if(have_posts()):while(have_posts()):the_post();
$ids[] = get_the_ID();
endwhile; endif; wp_reset_query();

?>
  	<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                	<div class="col-md-<?php echo $class; ?> col-sm-<?php echo $class; ?>" id="content-col">
                        <ul class="sermons-list">
                        <?php $speakers = array();
							query_posts(array('post_type'=>'sermon','meta_query'=>array(array('key'=>'imic_sermon_speaker','value'=>get_query_var('speakers'),'compare'=>'LIKE'))));
							if(have_posts()):while(have_posts()):the_post();
							$speakers[] = get_post_meta(get_the_ID(),'imic_sermon_speaker',false);
							 ?>
                        	<li class="sermon-item format-standard">
                            	<div class="row">
                                	<div class="col-md-5">
                                    	<?php if(has_post_thumbnail()) { ?><a href="<?php the_permalink(); ?>" class="media-box"><?php the_post_thumbnail('600x400'); ?></a><?php } ?>
                                        <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php _e('Watch Sermon','framework'); ?></a>
                                    </div>
                                    <div class="col-md-7">
                                    	<h3><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php the_title(); ?></a></h3>
                                        <span class="meta-data"><i class="fa fa-calendar"></i> <?php echo esc_html(get_the_date(get_option('date_format'),get_the_ID())); ?></span>
                                        <?php echo imic_excerpt(15); ?>
                                    </div>
                                </div>
                            </li>
                        <?php endwhile; else: ?>
						<li class="sermon-item format-standard">
                            	<div class="row">
                                    <div class="col-md-12">
                                    	<h3><?php _e('Sorry, but ','framework'); echo get_the_title(get_query_var('speakers')); _e('doesn\'t have any sermons.','framework'); ?></h3>
                                    </div>
                                </div>
                            </li>
						<?php endif; wp_reset_query(); ?>
                        </ul>
                        <?php imic_pagination(); ?>
                    </div>
                    <?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo $sidebar_column; ?> col-sm-<?php echo $sidebar_column; ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
                </div>
         	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>