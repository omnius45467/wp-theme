<?php
/*
Template Name: Sermons Series
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
$sermon_column = get_post_meta(get_the_ID(),'imic_sermon_series_column',true);
$sermon_count = get_post_meta(get_the_ID(),'imic_sermon_series_count',true);
$sermon_count = ($sermon_count=='')?10:$sermon_count;
$sermon_desc = get_post_meta(get_the_ID(),'imic_sermon_series_desc',true);
$sermon_desc = ($sermon_desc=='')?25:$sermon_desc;
$sermon_label = get_post_meta(get_the_ID(),'imic_sermon_series_label',true);
$sermon_button = get_post_meta(get_the_ID(),'imic_sermon_series_button',true);
$sermon_button = ($sermon_button=='')?'View series':$sermon_button;
?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                <div class="col-md-<?php echo $class; ?> col-sm-<?php echo $class; ?>" id="content-col">
                    <ul class="isotope-grid">
                    <div class="row">
                    <?php $taxonomies = array('sermon-category');
						$selected_terms = get_post_meta(get_the_ID(),'imic_sermon_series_cat',true);
						if($selected_terms!='') {
						$selected_terms = explode(",",$selected_terms); }
						$recent_term = get_terms('sermon-category','orderby=id&order=DESC&number=1');
						$recent_term_id='';
                                                if(!empty($recent_term)){
                                                $recent_term_id = $recent_term[0]->term_id;
                                                }
						if(!empty($selected_terms)) { 
						$args = array('orderby' => 'include', 'hide_empty' => true,'include' => $selected_terms); }
						else {
						$args = array('orderby' => 'id', 'order' => 'DESC', 'hide_empty' => true); }
						$sermonterms = get_terms($taxonomies, $args);
						$sermon_dates = array();
						$total = 1;
						foreach ($sermonterms as $sermonterms_data) {
							$term_link = get_term_link($sermonterms_data->slug, 'sermon-category');
							$t_id = $sermonterms_data->term_id; // Get the ID of the term we're editing
							$term_meta = get_option($sermonterms_data->taxonomy . $t_id . "_image_term_id"); // Do the check
							query_posts(array(
							'post_type' => 'sermon',
							'sermons-category' => $sermonterms_data->slug,
							'posts_per_page' => -1,
								));
							if(have_posts()):while(have_posts()):the_post();
							$sermon_date = get_post_meta(get_the_ID(),'imic_sermon_date',true);
							$sermon_dates[] = strtotime($sermon_date.' 23:59');
							endwhile; endif;
							$series = '';
							if($sermon_label==1) { 
							$start_date = min($sermon_dates);
							$end_date = max($sermon_dates);
							if($recent_term_id==$sermonterms_data->term_id) { $series = "<span class=\"sermon-series-date\">Current Series</span>"; }
							else { $series = "<span class=\"sermon-series-date\">".date_i18n('m/d/y',$start_date)." – ".date_i18n('m/d/y',$end_date)."</span>"; } } ?>
                        <li class="col-md-<?php echo $sermon_column; ?> col-sm-6 sermon-item grid-item format-standard">
                            <div class="grid-item-inner">
                             	<a href="<?php echo $term_link; ?>" class="media-box">
                                	<img src="<?php echo $term_meta; ?>" alt="">
                                </a>
                                <div class="grid-content">
                                	<?php echo $series; ?>
                                	<h3><a href="<?php echo esc_url($term_link); ?>"><?php echo esc_attr($sermonterms_data->name); ?></a></h3>
                                    <p><?php echo wp_trim_words(term_description( $sermonterms_data->term_id, 'sermon-category' ),$sermon_desc); ?></p>
                                    <a href="<?php echo esc_url($term_link); ?>" class="btn btn-primary"><?php echo $sermon_button; ?> <i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </li>
                        <?php if($total++>=$sermon_count) { break; } } ?>
                        </div>
                    </ul>
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