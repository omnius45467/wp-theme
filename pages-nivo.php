<?php 
wp_enqueue_script( 'imic_nivo_slider' );
wp_enqueue_style('imic_nivo_default');
wp_enqueue_style('imic_nivo_slider');
global $imic_options,$id;
$animation = get_post_meta($id,'imic_pages_banner_animation',true);
$overlay = get_post_meta($id,'imic_pages_banner_overlay',true);
$overlay_class = ($overlay==1)?'page-header-overlay':'';
$pagination = get_post_meta($id,'imic_pages_slider_pagination',true);
$autoplay = get_post_meta($id,'imic_pages_slider_auto_slide',true);
$arrows = get_post_meta($id,'imic_pages_slider_direction_arrows',true);
$height = get_post_meta($id,'imic_pages_slider_height',true);
$effects = get_post_meta($id,'imic_pages_nivo_effects',true);
$interval = get_post_meta($id,'imic_pages_slider_interval',true);
if($interval == ''){
	$interval = 7000;
}
$slider_height = ($height!='')?$height:'';
$images = get_post_meta($id,'imic_pages_slider_image',false);
?>
<div class="page-header parallax clearfix" style="height:auto">
<div class="<?php echo $overlay_class; ?>"></div>
<div class="hero-slider clearfix">
        <div class="slider-wrapper theme-default">
        <?php if(!empty($images)) { ?>
  		<div class="nivoslider clearfix" data-autoplay="<?php echo esc_attr($autoplay); ?>" data-pagination="<?php echo esc_attr($pagination); ?>" data-arrows="<?php echo esc_attr($arrows); ?>" data-effect="<?php echo esc_attr($effects); ?>" data-thumbs="no" data-slices="15" data-animSpeed="500" data-pauseTime="<?php echo esc_attr($interval) ?>" data-pauseonhover="yes">
        <?php foreach($images as $image):
		$attachment_meta = imic_wp_get_attachment($image);
		?>
    	<img src=" <?php echo esc_url($attachment_meta['src']); ?> " alt="" title="<?php echo esc_attr($attachment_meta['caption']); ?>">
        <?php endforeach; } ?>
  		</div>
  	</div><?php if($animation==1) { wp_enqueue_script('imic_jquery_home'); echo '<canvas id="canvas-animation"></canvas>'; } ?>
    </div></div><!-- End Page Header --><?php if(function_exists('bcn_display'))
    { ?>
    <div class="lgray-bg breadcrumb-cont">
    	<div class="container">
        
          	<ol class="breadcrumb">
            	<?php bcn_display(); ?>
          	</ol>
        </div>
    </div><?php } ?>