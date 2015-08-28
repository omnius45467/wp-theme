<?php 
get_header();
imic_sidebar_position_module();
global $imic_options;
if(is_product_category()) {
$pageSidebar = $imic_options['shop_sidebar'];
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$class = 9;  
}else{
$class = 12;  
}
$sidebar_column = 3;
global $wp_query;
$cat = $wp_query->get_queried_object();
$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
$image = wp_get_attachment_url( $thumbnail_id ); 
$banner_image = esc_url($imic_options['header_image']['url']);
$image = ($image)?$image:$banner_image; ?>
	<div class="page-header parallax clearfix" style="background-image:url(<?php echo esc_url($image); ?>)">
    	<div class="title-subtitle-holder">
        	<div class="title-subtitle-holder-inner">
    				<h2><?php echo esc_attr(single_term_title("", false)); ?></h2>
                </div>
        </div>
    </div>
    <!-- End Page Header --><?php if(function_exists('bcn_display')) { ?>
    <!-- Breadcrumbs -->
    <div class="lgray-bg breadcrumb-cont">
    	<div class="container">
        
          	<ol class="breadcrumb">
            	<?php bcn_display(); ?>
          	</ol>
        </div>
    </div>
<?php } } else {
if(is_home()) { $id = get_option('page_for_posts'); }
elseif(is_shop()){
    $id = woocommerce_get_page_id('shop');
  }
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
} }
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
            <div class="row">
            <div class="col-md-<?php echo $class; ?>" id="content-col">
            <?php woocommerce_content(); imic_pagination(); ?>
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
<?php get_footer(); ?>