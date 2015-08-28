<?php global $imic_options,$id;
$rev_slider = get_post_meta($id,'imic_pages_select_layer_from_list',true); ?>
<div class="page-header parallax clearfix" style="height:auto">
<div class="hero-slider">
      <div class="slider-rev-cont">
            <div class="tp-limited">
            <?php echo do_shortcode($rev_slider); ?>
            </div>
		</div>
	</div>
</div>