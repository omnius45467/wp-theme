<?php
/*
Template Name: Gallery
*/
get_header();
imic_sidebar_position_module();
wp_enqueue_script( 'imic_jquery_flexslider' );
wp_enqueue_script('imic_magnific_gallery');
wp_enqueue_script('imic_sg');
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
$pageSidebar = get_post_meta(get_the_ID(),'imic_select_sidebar_from_list', true);
$sidebar_column = get_post_meta(get_the_ID(),'imic_sidebar_columns_layout',true);
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$left_col = 12-$sidebar_column;
$class = $left_col;  
}else{
$class = 12;  
}
$gallery_filter = get_post_meta(get_the_ID(),'imic_gallery_secondary_bar_type_status',true);
$column_class = get_post_meta(get_the_ID(),'imic_projects_columns_layout',true);
$gallery_pagination = get_post_meta(get_the_ID(),'imic_gallery_page_pagination',true);
$gallery_numbers = get_post_meta(get_the_ID(),'imic_gallery_number_show',true);
$gallery_numbers = ($gallery_numbers=='')?-1:$gallery_numbers;
$gallery_category = get_post_meta(get_the_ID(),'imic_advanced_gallery_taxonomy',true);
				if($gallery_category!=''){
				$gallery_categories= get_term_by('id',$gallery_category,'gallery-category');
				if(!empty($gallery_categories)){
				$gallery_category= $gallery_categories->slug; }}
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
      		<div class="container">
            <?php //Gallery Filters
				if($gallery_filter=='1') { ?>
            <ul class="nav nav-pills sort-source" data-sort-id="gallery" data-option-key="filter">
              	<?php $gallery_cats = get_terms("gallery-category");?>
                                            <li data-option-value="*" class="active"><a href="#"> <?php _e('Show All','framework'); ?></a></li>
                                     	<?php foreach($gallery_cats as $gallery_cat) { ?>
                                            <li data-option-value=".<?php echo esc_attr($gallery_cat->slug); ?>"><a href="#"><?php echo esc_attr($gallery_cat->name); ?></a></li>
                                    	<?php } ?>
            </ul>
            <?php } ?>
                <div class="row">
                <div class="col-md-<?php echo $class; ?> col-sm-<?php echo $class; ?>" id="content-col">
                <div class="row">
                  	<ul class="sort-destination isotope-grid" data-sort-id="gallery">
                    <?php //Query for Gallery Post Type
					$paged = (get_query_var('paged'))?get_query_var('paged'):1;
				query_posts(array('post_type'=>'gallery','gallery-category'=>$gallery_category,'paged'=>$paged,'posts_per_page'=>$gallery_numbers));
				if(have_posts()):while(have_posts()):the_post(); 
				$post_format = get_post_format();
				$post_format = ($post_format=="")?"image":$post_format;
				get_template_part('gallery',$post_format); ?>
                        <?php endwhile; endif; ?>
                  	</ul>
                    
                    </div>
                    <?php imic_pagination(); wp_reset_query();  ?>
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