<?php 
global $imic_options,$id;
$image = $banner_type = '';
$animation = get_post_meta($id,'imic_pages_banner_animation',true);
$overlay = get_post_meta($id,'imic_pages_banner_overlay',true);
$overlay_class = ($overlay==1)?'page-header-overlay':'';
$type = get_post_meta($id,'imic_pages_Choose_slider_display',true);
if($type==1 || $type==2 || $type==3) {
$height = get_post_meta($id,'imic_pages_slider_height',true);
} else {
	$height = '';
}
$color = get_post_meta($id,'imic_pages_banner_color',true);
$banner_desc = get_post_meta($id,'imic_pages_banner_description',true);
$color = ($color!='' && $color!='#')?$color:'';
if($type==2) {
$image = get_post_meta($id,'imic_header_image',true);
$image_src = wp_get_attachment_image_src( $image, 'full', '', array() );
if(is_array($image_src)) { $image = $image_src[0]; } else { $image = $imic_options['header_image']['url']; } }
$post_type = get_post_type($id);
$title = '';
$title = get_the_title($id);
if($post_type=='event') {
$date = get_query_var('event_date');
if(empty($date)){
   $date= get_post_meta($id,'imic_event_start_dt',true);
}
$event_time=get_post_meta($id,'imic_event_start_dt',true);
$event_time = strtotime($event_time);
$event_end_time=get_post_meta($id,'imic_event_end_dt',true);
$event_end_time = strtotime($event_end_time);
$date = strtotime($date); }
//$title = ($id>0)?get_the_title($id):'Blog';
if(is_page_template('template-contact.php')) {
	$banner_type = get_post_meta($id,'imic_contact_banner_type',true);
	$map_address = get_post_meta($id,'imic_contact_map_address',true);
}
if($banner_type==1) {
	wp_enqueue_script('imic_contact_map');
	wp_localize_script('imic_contact_map','contact',array('address'=>$map_address));
	echo '<div class="page-header parallax clearfix">
    	<div id="contact-map"></div>
    </div>';
}else {
if($overlay==1) {
?>
<div class="page-header parallax clearfix" style="background-color:<?php echo $color ?>; height:<?php echo esc_attr($height).'px' ?>">
    	<div class="<?php echo $overlay_class; ?>" style="background-image:url(<?php echo esc_url($image); ?>);"></div>
<?php } else { ?>
<div class="page-header parallax clearfix" style="background-image:url(<?php echo esc_url($image); ?>); background-color:<?php echo $color ?>; height:<?php echo esc_attr($height).'px' ?>;">
<?php }
 ?>
        <div class="title-subtitle-holder">
        	<div class="title-subtitle-holder-inner">
            <?php if(get_post_type($id)=='event') {
				if($date!='') { ?>
    			<h2><?php echo esc_attr(date_i18n(get_option('date_format'),$date)); ?></h2>
      			<div class="header-event-time"><?php _e('From ','framework'); echo esc_attr(date_i18n(get_option('time_format'),$event_time)); ?></span><?php _e('to','framework'); echo esc_attr(date_i18n(get_option('time_format'),$event_end_time)); ?></div>
          	<?php } } else {
				if((is_category())||is_tag()) { echo '<h2>'.single_term_title("", false).'</h2>'; } else { ?>
            <h2><?php echo esc_attr($title); ?></h2>
            <?php } if($banner_desc!='') { ?>
            <hr class="sm">
<span class="subtitle"><?php echo esc_attr($banner_desc); ?></span>
            <?php } } ?>
        </div>
        </div><?php if($animation==1) { wp_enqueue_script('imic_jquery_home'); echo '<canvas id="canvas-animation"></canvas>'; } ?>
    </div><?php } ?>
    <!-- End Page Header --><?php if(function_exists('bcn_display'))
    { ?>
    <!-- Breadcrumbs -->
    <div class="lgray-bg breadcrumb-cont">
    	<div class="container">
        
          	<ol class="breadcrumb">
            	<?php bcn_display(); ?>
          	</ol>
		
        </div>
    </div>
<?php }