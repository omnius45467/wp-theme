<?php
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
$pageSidebar = get_post_meta($id,'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta($id,'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
} 
$blog_masonry = 0;
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                	<div class="col-md-<?php echo $class; ?>" id="content-col">
                        <div class="posts-listing">
                        <?php if(have_posts()):while(have_posts()):the_post();
						$post_format = get_post_format();
						$post_format = ($post_format=="")?"image":$post_format;
						get_template_part('content',$post_format);
                        endwhile;
						else:
						get_template_part('content','none');
						endif; ?>
                        <?php wp_link_pages( array(
														'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'framework' ) . '</span>',
														'after'       => '</div>',
														'link_before' => '<span>',
														'link_after'  => '</span>',
													) ); ?>
                        </div>
                        <!-- Pagination -->
                        <?php if(function_exists('imic_pagination')) { imic_pagination(); } else { next_posts_link( 'Older Entries');
previous_posts_link( 'Newer Entries' ); } ?>
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