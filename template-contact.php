<?php
/*
Template Name: Contact
*/
get_header();
imic_sidebar_position_module();
global $imic_options;
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
} ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                	<?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-<?php echo $sidebar_column; ?>" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
                    <div class="col-md-<?php echo $class; ?> col-sm-6" id="content-col">
                    <?php if(have_posts()):while(have_posts()):the_post();
					the_content();
					endwhile; endif; ?>
                       	<form method="post" id="contactform" name="contactform" class="contact-form clearfix" action="<?php echo IMIC_THEME_PATH; ?>/mail/contact.php">
                        	<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="fname" name="First Name"  class="form-control input-lg" placeholder="<?php _e('First name','framework'); ?>*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="lname" name="Last Name"  class="form-control input-lg" placeholder="<?php _e('Last name','framework'); ?>">
                                    </div>
                              	</div>
                           	</div>
                        	<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" id="email" name="email"  class="form-control input-lg" placeholder="<?php _e('Email','framework'); ?>*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="<?php _e('Phone','framework'); ?>">
                                    </div>
                                </div>
                          	</div>
                        	<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea cols="6" rows="7" id="comments" name="comments" class="form-control input-lg" placeholder="<?php _e('Message','framework'); ?>"></textarea>
                                    </div>
                                </div>
                          	</div>
                            <input type ="hidden" name ="image_path" id="image_path" value ="<?php echo IMIC_THEME_PATH; ?>">
                            <input type ="hidden" name ="recipients" id="recipients" value ="<?php echo get_the_ID()+2648; ?>">
                        	<div class="row">
                                <div class="col-md-12">
                                    <input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg btn-block" value="<?php _e('Submit now!','framework'); ?>">
                                </div>
                          	</div>
                		</form>
                        <div class="clearfix"></div>
                        <div id="message"></div>
                    </div>
               	</div>
           	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>