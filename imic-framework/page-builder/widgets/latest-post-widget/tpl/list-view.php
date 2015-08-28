<?php
$the_category = wp_kses_post($instance['categories']);
$post_title = wp_kses_post($instance['title']);
$read_more_text = wp_kses_post($instance['read_more_text']);
?>
<?php query_posts( array ( 'post_type' => 'post', 'category_name' => ''. $the_category .'', 'posts_per_page' => 1 ) );
if(have_posts()) : ?>
<?php while(have_posts()) : the_post(); ?>
<div class="very-latest-post format-standard">
	<?php if(!empty($instance['title'])){ ?>
    <div class="title-row">
    	<?php  comments_popup_link('<i class="icon-dialogue-text"></i>','<i class="icon-dialogue-text"></i>','<i class="icon-dialogue-text"></i>','comments-go','<i class="icon-dialogue-text"></i>'); ?>
        <h4><?php echo $post_title; ?></h4>
    </div>
    <?php } ?>
    <?php if ( has_post_thumbnail() ) { ?>
    <a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="media-box">
        <?php the_post_thumbnail('800x500'); ?>
    </a><?php } ?>
    
    <h3 class="post-title"><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>"><?php the_title(); ?></a></h3>
    <?php if(!empty($instance['show_post_meta'])){ ?><div class="meta-data"><?php _e('by ','framework'); ?><a href="<?php $post_author_id = get_post_field( 'post_author', get_the_ID() ); echo esc_url(get_author_posts_url($post_author_id)); ?>"><?php echo esc_attr(get_the_author_meta( 'display_name', $post_author_id )); ?></a><?php _e(' on ','framework'); echo esc_attr(get_the_date(get_option('date_format')));_e(' in ','framework'); the_category(', '); ?></div><?php } ?>
    <?php if(!empty($instance['excerpt_length'])){ ?><?php echo imic_excerpt(50); ?><?php } ?>
    <?php if($read_more_text!=""){ ?><p><a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="basic-link"><?php echo $read_more_text; ?></a></p><?php } ?>
</div>
<?php endwhile; wp_reset_query(); ?>
<?php endif; ?>