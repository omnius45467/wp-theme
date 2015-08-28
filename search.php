<?php get_header();
imic_sidebar_position_module();
global $imic_options;
$event_image = $imic_options['header_image']['url'];
$pageSidebar = $imic_options['search_sidebar'];
if(!empty($pageSidebar)&&is_active_sidebar($pageSidebar)) {
$class = 9;  
}else{
$class = 12;  
}
?>
<div class="page-header parallax clearfix" style="background-image:url(<?php echo esc_url($event_image); ?>);">
<div class="title-subtitle-holder">
        	<div class="title-subtitle-holder-inner">
            <h2><?php printf( __( 'Search Results for: %s', 'framework' ), get_search_query() ); ?></h2>
        </div>
        </div>
    </div>
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
<?php } ?>
<!-- Start Body Content -->
  	<div class="main" role="main">
    	<div id="content" class="content full">
        	<div class="container">
                <div class="row">
                	<div class="col-md-<?php echo $class; ?>" id="content-col">
                        <div class="posts-listing">
                        <?php if(have_posts()):while(have_posts()):the_post();
						$post_format = get_post_format();
						$post_format = ($post_format=="")?"image":$post_format;
						get_template_part('content',$post_format);
                        endwhile;
						else:
						get_template_part('content','none');
						endif; ?>
                        <?php wp_link_pages( array(
														'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'framework' ) . '</span>',
														'after'       => '</div>',
														'link_before' => '<span>',
														'link_after'  => '</span>',
													) ); ?>
                        </div>
                        <!-- Pagination -->
                        <?php if(function_exists('imic_pagination')) { imic_pagination(); } else { next_posts_link( 'Older Entries');
previous_posts_link( 'Newer Entries' ); } ?>
                    </div>
                        	<?php if(is_active_sidebar($pageSidebar)) { ?>
                    <!-- Sidebar -->
                    <div class="col-md-3 sidebar" id="sidebar-col">
                    	<?php dynamic_sidebar($pageSidebar); ?>
                    </div>
                    <?php } ?>
                        </div>
                    </div>
                </div>
         	</div>
        </div>
   	</div>
    <!-- End Body Content -->
<?php get_footer(); ?>