<?php
$src = wp_get_attachment_image_src($instance['featured_image'], $instance['size']);
if( !empty($src) ) {
	$attr = array(
		'src' => $src[0],
		'width' => $src[1],
		'height' => $src[2],
	);
}
else if( !empty( $instance['featured_image_fallback'] ) ) {
	$attr = array(
		'src' => esc_url($instance['featured_image_fallback']),
	);
}


$styles = array();
$classes = array('featured-block-widget');

if(!empty($instance['featured_title'])) $attr['featured_title'] = $instance['featured_title'];
if(!empty($instance['featured_alt'])) $attr['featured_alt'] = $instance['featured_alt'];
if(!empty($instance['featured_bound'])) {
	$styles[] = 'max-width:100%';
	$styles[] = 'height:auto';
}
if(!empty($instance['featured_full_width'])) {
	$styles[] = 'width:100%';
}
$styles[] = 'display:block';
$post_title = wp_kses_post($instance['featured_title']);
$featured_text = wp_kses_post($instance['featured_text']);
?>


<div class="featured-block <?php if(empty($instance['hover_effect'])) echo 'no-fade' ?>">
	<h3><?php if(!empty($instance['featured_url'])) { ?><a href="<?php echo sow_esc_url($instance['featured_url']) ?>" <?php if($instance['featured_new_window']) echo 'target="_blank"' ?>><?php } ?><?php echo $post_title; ?><?php if(empty($instance['featured_url'])) { ?></a><?php } ?></h3>
	<?php if(!empty($instance['featured_image']) || ($instance['featured_image_fallback'])) { ?><figure><?php if(!empty($instance['featured_url'])) { ?><a href="<?php echo sow_esc_url($instance['featured_url']) ?>" <?php if($instance['featured_new_window']) echo 'target="_blank"' ?>><?php } ?><img <?php foreach($attr as $n => $v) echo $n.'="' . esc_attr($v) . '" ' ?> class="<?php echo esc_attr( implode(' ', $classes) ) ?>" <?php if( !empty($styles) ) echo 'style="'.implode('; ', $styles).'"'; ?>><?php if(!empty($instance['featured_url'])) { ?></a><?php } ?></figure><?php } ?><?php if(!empty($instance['featured_text'])) { ?><p><?php echo $featured_text; ?></p><?php } ?></div>