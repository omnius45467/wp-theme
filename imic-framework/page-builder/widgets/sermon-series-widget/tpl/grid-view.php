<?php
$the_categories = wp_kses_post($instance['categories']);
$post_title = wp_kses_post($instance['title']);
$numberPosts = (!empty($instance['number_of_posts']))? $instance['number_of_posts'] : 4 ;
$column = (!empty($instance['grid_column']))? $instance['grid_column'] : 4 ;
$read_more_text = wp_kses_post($instance['read_more_text']);
$sermon_desc = wp_kses_post($instance['excerpt_length']);
$sermon_desc = ($sermon_desc=='')?25:$sermon_desc;
$sermon_count = (!empty($instance['number_of_posts']))? $instance['number_of_posts'] : 4 ;
?>
<div class="row">
    <ul class="isotope-grid">
    <?php $taxonomies = array('sermon-category');
        $selected_terms = wp_kses_post($instance['series_order']);
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
            endwhile; endif; wp_reset_query();
            $series = '';
            if($sermon_label==1) { 
            $start_date = min($sermon_dates);
            $end_date = max($sermon_dates);
            if($recent_term_id==$sermonterms_data->term_id) { $series = "<span class=\"sermon-series-date\">Current Series</span>"; }
            else { $series = "<span class=\"sermon-series-date\">".date_i18n('m/d/y',$start_date)." – ".date_i18n('m/d/y',$end_date)."</span>"; } } ?>
        <li class="col-md-<?php echo $column; ?> col-sm-6 sermon-item grid-item format-standard">
            <div class="grid-item-inner">
            	<?php if(!empty($term_meta)) { ?>
                <a href="<?php echo $term_link; ?>" class="media-box">
                    <img src="<?php echo $term_meta; ?>" alt="">
                </a>
                <?php } ?>
                <div class="grid-content">
                    <?php if(!empty($instance['show_post_meta'])){ ?><?php echo $series; ?><?php } ?>
                    <h3><a href="<?php echo esc_url($term_link); ?>"><?php echo esc_attr($sermonterms_data->name); ?></a></h3>
                    <?php if(!empty($instance['excerpt_length'])){ ?><p><?php echo wp_trim_words(term_description( $sermonterms_data->term_id, 'sermon-category' ),$sermon_desc); ?></p><?php } ?>
                    <?php if($read_more_text!=""){ ?><a href="<?php echo esc_url($term_link); ?>" class="btn btn-primary"><?php echo $read_more_text; ?> <i class="fa fa-chevron-right"></i></a><?php } ?>
                </div>
            </div>
        </li>
        <?php if($total++>=$sermon_count) { break; } } ?>
    </ul>
</div>