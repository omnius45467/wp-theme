<?php
/*
Template Name: Blog Masonry
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
$pageSidebar = get_post_meta($id,'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta($id,'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
//Meta Boxes Details
$post_count = get_post_meta($id,'imic_post_count',true);
$post_count = ($post_count!='')?$post_count:get_option('posts_per_page');
$blog_masonry = 1;
$grid_column = get_post_meta($id,'imic_temp_event_columns_layout',true);
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                <div class="col-md-<?php echo $class; ?>" id="content-col">
                <div class="row">
                    <ul class="isotope-grid">
                        <?php $post_category = get_post_meta($id,'imic_advanced_post_list_taxonomy',true);
							if(!empty($post_category)){
							$post_categories= get_category($post_category);
							$post_category= $post_categories->slug; }
							$paged = (get_query_var('paged'))?get_query_var('paged'):1;
							query_posts(array('post_type'=>'post','category_name' => $post_category,'paged'=>$paged,'posts_per_page'=>$post_count));
						if(have_posts()):while(have_posts()):the_post();
						$post_format = get_post_format();
						$post_format = ($post_format=="")?"image":$post_format;
						get_template_part('content',$post_format);
                        endwhile; 
						else:
						get_template_part('content','none');
						endif; ?>
                    </ul>
                    </div>
                    <?php imic_pagination(); wp_reset_query(); ?>
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