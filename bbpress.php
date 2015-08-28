<?php
get_header();
imic_sidebar_position_module();
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
else {
	get_template_part( 'pages', 'banner' );
}
if ($imic_options['bbpress_sidebar']) {
	$content_col = 9;
} else {
	$content_col = 12;
}?>

<!-- Start Body Content -->
<div class="main" role="main">
    <div id="content" class="content full">
        <div class="container">
            <div class="row">
                <div class="col-md-<?php echo $content_col; ?>" id="content-col">
                <?php if(have_posts()):
                        while(have_posts()):the_post();
                        if($post->post_content!="") :
                                      the_content();
                              endif;
                        endwhile;
                    endif; ?>
                </div>
                <?php if ($imic_options['bbpress_sidebar']){ ?>
                <!-- Start Sidebar -->
                <div class="col-md-3 sidebar" id="sidebar-col">
                    <?php dynamic_sidebar($imic_options['bbpress_sidebar']); ?>
                </div>
                <!-- End Sidebar -->
                <?php } ?>
            </div>
        </div>
 	</div>
</div>
<?php get_footer(); ?>