<?php global $blog_masonry, $grid_column;
if($blog_masonry==0) { ?>
<article <?php post_class('post-list-item format-standard'); ?>>
                                <div class="post-excerpt">
                                	<h3 class="post-title"><?php _e('No Posts to display','framework'); ?></h3>
                                </div>
                            </article>
<?php } else { ?>
<li class="col-md-<?php echo $grid_column; ?> col-sm-6 blog-item grid-item format-standard">
                            <div class="grid-item-inner">
                                <div class="grid-content">
                                <h3 class="post-title"><?php _e('No Posts to display.','framework'); ?></h3>
                                </div>
                         	</div>
</li>
<?php } ?>