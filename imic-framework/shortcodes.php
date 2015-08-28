<?php
       load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH. '/language/');
	// Create TinyMCE's editor button & plugin for IMIC Framework Shortcodes
	add_action('init', 'imic_sc_button'); 
	
	function imic_sc_button() {  
	   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )  
	   {  
	     add_filter('mce_external_plugins', 'imic_add_tinymce_plugin');  
	     add_filter('mce_buttons', 'imic_register_shortcode_button');  
	   }  
	} 
	
	function imic_register_shortcode_button($button) {  
	    array_push($button, 'separator', 'imicframework_shortcodes' );  
	    return $button;  
	}
	
	function imic_add_tinymce_plugin($plugins) {  
	    $plugins['imicframework_shortcodes'] = get_template_directory_uri() . '/imic-framework/imic-shortcodes/imic-tinymce.editor.plugin.js';  
	    return $plugins;  
	} 
	
	
	
	/* ==================================================
	
	SHORTCODES OUTPUT
	
	================================================== */
	
	/* STAFF SHORTCODE
	================================================== */
	
	function imic_staff($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => "",
			"type" => 1,
			"order" => "",
			"number" => "",
			"column" => 4,
			"cat" => "",
		), $atts));
		
		$output = '';
	   if ($order == "no") {
			$orderby = "ID";
			$sort_order = "DESC";
		} else {
			$orderby = "menu_order";
			$sort_order = "ASC";
		}
		$url = imic_get_template_url('template-speakers-sermon.php');
			query_posts(array('post_type'=>'speaker','speaker-category'=>$cat,'posts_per_page'=>$number,'orderby' => $orderby,'order' => $sort_order));
			$output .= '<h3>'.$title.'</h3>
              	<hr class="sm">';
			if($type==1) { 
           	$output .= '<div class="row">';
        	if(have_posts()):while(have_posts()):the_post();
			$staff_position = get_post_meta(get_the_ID(),'imic_staff_position',true);
			$social = imic_social_staff_icon();
				$output .= '<div class="col-md-'.$column.' col-sm-6">
                      	<div class="grid-item staff-item format-standard">
                        	<div class="grid-item-inner">
                                '.get_the_post_thumbnail(get_the_ID(),'600x400').'
                          		<div class="grid-content">
                                	<div class="staff-item-name">
                            			<h5><a data-toggle="modal" data-target="#team-modal-'.(get_the_ID()+2648).'" href="#" class="">'.get_the_title().'</a></h5>
                                        <span class="meta-data">'.$staff_position.'</span>
                                    </div>
                                    '.$social.imic_excerpt(10).'
                          		</div></div>
                        	</div>
                      	</div>';
				$output .= '<div class="modal fade team-modal" id="team-modal-'.(get_the_ID()+2648).'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">'.__('Team Members','framework').'</h4>
                          </div>
                            <div class="modal-body">
                                <div class="staff-item">
                                <div class="row">
                                    <div class="col-md-5 col-sm-6">
                                    	'.get_the_post_thumbnail(get_the_ID(),'600x400',array('class'=>'img-thumbnail')).'
                                    </div>
                                    <div class="col-md-7 col-sm-6">
                                    	<h3>'.get_the_title().'</h3>
                                    	<span class="meta-data">'.get_post_meta(get_the_ID(),'imic_staff_position',true).'</span>';
                                        $post_id = get_post(get_the_ID());
											$content = $post_id->post_content;
											$content = apply_filters('the_content', $content);
											$content = str_replace(']]>', ']]>', $content);
											$output .= $content;
											if(get_post_meta(get_the_ID(),'imic_display_sermon_url',true)==1) {
											
											if($url!='') {
										$output .= '<a class="btn btn-primary" href="'.add_query_arg('speakers',get_the_ID(),$url).'">'.__('View all Sermons','framework').'</a>'; } }
                                    $output .= '</div>
                                </div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>';
			endwhile; endif; 
                    $output .= '</div>';
		}
		else {
			$output .= '<ul class="members-list row">';
			if(have_posts()):while(have_posts()):the_post();
			$staff_position = get_post_meta(get_the_ID(),'imic_staff_position',true);
			$social = imic_social_staff_icon();
                    $output .= '<li class="col-md-'.$column.' col-sm-4 col-xs-6">
                        '.get_the_post_thumbnail(get_the_ID(),'100x100').'
                        <h5>'.get_the_title().'</h5>
                        <span class="meta-data">'.$staff_position.'</span>
                        '.$social.'
                    </li>'; 
			endwhile; endif;
			$output .= '</ul>';
		}
		wp_reset_query();
		return $output;
	}
	add_shortcode('staff', 'imic_staff');
	/* 
	/* PRICING TABLE SHORTCODE
	================================================== */
	function imic_pricing_table($atts, $content = null) {
		extract(shortcode_atts(array(
		'column' => '',
		),$atts));
		$output = '';
		$column = ($column==4)?'four':'three';
		$output = '<div class="pricing-table '.$column.'-cols margin-40">'. do_shortcode($content).'</div>';
		return $output;
	}
	add_shortcode('pricingtable', 'imic_pricing_table');
	
	function imic_pricing_table_heading( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'active' => '',
		),$atts));
		$output = '';
		$active_class = '';
		if($active!='') { $active_class = ' highlight accent-color'; }
		$output = '<div class="pricing-column '.$active_class.'"><h3>'. do_shortcode($content);		
		return $output;
	}
	add_shortcode('headingss', 'imic_pricing_table_heading');
	function imic_pricing_table_reason( $atts, $content = null ) {
		$output = '<span class="highlight-reason">'. do_shortcode($content).'</span>';		
		return $output;
	}
	add_shortcode('reason', 'imic_pricing_table_reason');
	function imic_pricing_table_price( $atts, $content = null ) {
		extract(shortcode_atts(array(
		'currency' => '',
		),$atts));
		$output = '</h3><div class="pricing-column-content"><h4> <span class="dollar-sign">'.$currency.' </span> '. do_shortcode($content);		
		return $output;
	}
	add_shortcode('price', 'imic_pricing_table_price');
	
	function imic_pricing_table_interval( $atts, $content = null ) {
		$output = '</h4><span class="interval">';
		$output .= do_shortcode($content) .'</span><ul class="features" style="height: 157px;">';
		
		return $output;
	}
	add_shortcode('interval', 'imic_pricing_table_interval');
	function imic_pricing_table_row( $atts, $content = null ) {
		$output = '<li>';
		$output .= do_shortcode($content) .'</li>';
		
		return $output;
	}
	add_shortcode('row', 'imic_pricing_table_row');
	function imic_pricing_table_url( $atts, $content = null ) {
		$output = '</ul><a class="btn btn-primary" href="'.do_shortcode($content) .'">'.__('Sign up now!','framework').'</a></div></div>';
		
		return $output;
	}
	add_shortcode('url', 'imic_pricing_table_url');
	
	/* BUTTON SHORTCODE
	================================================== */
	
	function imic_button($atts, $content = null) {
		extract(shortcode_atts(array(
			"colour"		=> "",
			"type"			=> "",
			"link" 			=> "#",
			"target"		=> '_self',
			"size"		=> '',
			"extraclass"   => ''
		), $atts));
		
		$button_output = "";
		$button_class = 'btn '. $colour .' '. $extraclass .' '. $size;
		$buttonType = ($type == 'disabled')? 'disabled="disabled"' : '';
						
		$button_output .= '<a class="'.$button_class.'" href="'.$link.'" target="'.$target.'" '.$buttonType.'>' . do_shortcode($content) . '</a>';		
		return $button_output;
	}
	add_shortcode('imic_button', 'imic_button');
	
	
	/* ICON SHORTCODE
	================================================== */
		
	function imic_icon($atts, $content = null) {
		extract(shortcode_atts(array(
			"image"			=> ""
		), $atts));
		
		return '<i class="fa ' .$image. '"></i>';
	}
	add_shortcode('icon', 'imic_icon');
	
	/* VIDEO SHORTCODE
	================================================== */
		
	function imic_video($atts, $content = null) {
		extract(shortcode_atts(array(
			"url"			=> "",
			"width" => "",
			"height" => "",
			"full" => ""
		), $atts));
		$video_code = imic_video_embed($url,$width,$height);
		if($full==0) {
		return $video_code; }
		else {
		return '<div class="fw-video">'.$video_code.'</div>'; }
	}
	add_shortcode('video', 'imic_video');
	
	/* GOOGLE MAP SHORTCODE
	================================================== */
	
	function imic_gmap($atts, $content = null) {
		extract(shortcode_atts(array(
			"address"			=> '',
		), $atts));
		
		$output = '';
		wp_enqueue_script('imic_google_map');
		wp_enqueue_script('imic_gmap');
		wp_localize_script('imic_gmap','gmap',array('address'=>$address));
		$output .= '<div id="googleMap"></div><div class="spacer-20"></div>';
		return $output;
	}
	add_shortcode('gmap', 'imic_gmap');
	
	/* ICON BOX SHORTCODE
	================================================== */
		
	function imic_icon_box($atts, $content = null) {
		extract(shortcode_atts(array(
			"icon_image"	=> "",
			"line_icon" => "",
			"title"			=> "",
			"description"	=> "",
			"link" => ""
			//"type" => "",
                    //"icon_box" => ""
		), $atts));
                    $output = '<div class="icon-box icon-box-style1">';
					if($link!='') {
					$output .= '<a href="'.$link.'"><div class="icon-box-head">
					<span class="ico">';
					if($icon_image!='') {
					$output .= '<i class="fa '.$icon_image.'"></i>'; }
					else {
					$output .= '<i class="'.$line_icon.'"></i>'; }	
					$output .= '</span>
					<h4>'.$title.'</h4>
					</div></a>'; }
					else {
					$output .= '<div class="icon-box-head">
					<span class="ico">';
					if($icon_image!='') {
					$output .= '<i class="fa '.$icon_image.'"></i>'; }
					else {
					$output .= '<i class="'.$line_icon.'"></i>'; }	
					$output .= '</span>
					<h4>'.$title.'</h4>
					</div>'; }
					$output .= '<p>'.$description.'</p>
					</div>';
                return $output;
	}
	add_shortcode('icon_box', 'imic_icon_box');
	/* COLUMN SHORTCODES
	================================================== */
	function imic_one_full( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra" => '',
			"anim" => '',
		), $atts));
		$animation = (!empty($anim)) ? 'data-appear-animation="'.$anim.'"' : '';
	    return '<div class="col-md-12 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_full', 'imic_one_full');
	
	function imic_one_half( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra" => '',
			"anim" => '',
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-6 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_half', 'imic_one_half');
	
	function imic_one_third( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-4 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_third', 'imic_one_third');
	function imic_one_fourth( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-3 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fourth', 'imic_one_fourth');
	function imic_one_sixth( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-2 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_sixth', 'imic_one_sixth');
	
	function imic_two_third( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class="col-md-8 ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_third', 'imic_two_third');
	
	function imic_custom( $atts, $content = null ) {
	   extract(shortcode_atts(array(
			"extra" => '',
			"anim" => ''
		), $atts));
		$animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
	    return '<div class=" ' . $extra . '" '. $animation .'>' . do_shortcode($content) . '</div>';
	}
	add_shortcode('custom', 'imic_custom');
	/* TABLE SHORTCODES
	================================================= */
	function imic_table_wrap( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type" => ''
		), $atts));
		$output = '<table class="table '.$type.'">';
		$output .= do_shortcode($content) .'</table>';
		
		return $output;
		
	}
	add_shortcode('htable', 'imic_table_wrap');
	function imic_table_headtag( $atts, $content = null ) {
		$output = '<thead>'. do_shortcode($content) .'</thead>';		
		return $output;
	}
	add_shortcode('thead', 'imic_table_headtag');
	function imic_table_body( $atts, $content = null ) {
		$output = '<tbody>'. do_shortcode($content) .'</tbody>';		
		return $output;
	}
	add_shortcode('tbody', 'imic_table_body');
	
	function imic_table_row( $atts, $content = null ) {
		$output = '<tr>';
		$output .= do_shortcode($content) .'</tr>';
		
		return $output;
	}
	add_shortcode('trow', 'imic_table_row');
	
	function imic_table_column( $atts, $content = null ) {
	
		$output = '<td>';
		$output .= do_shortcode($content) .'</td>';
		
		return $output;
	}
	add_shortcode('tcol', 'imic_table_column');
	function imic_table_head( $atts, $content = null ) {
		$output = '<th>';
		$output .= do_shortcode($content) .'</th>';
		
		return $output;
	}
	add_shortcode('thcol', 'imic_table_head');
	
	/* TYPOGRAPHY SHORTCODES
	================================================= */
	// Anchor tag
	function imic_anchor( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"href"			=> '',
			"extra"			=> ''
		), $atts));
	   return '<a href="'.$href.'" class="'.$extra.'" >' . do_shortcode($content) . ' </a>';
	}
	add_shortcode('anchor', 'imic_anchor');
	// Div tag
	function imic_div( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra"			=> ''
		), $atts));
	   return '<div class="'.$extra.'">' . do_shortcode($content) . ' </div>';
	}
	add_shortcode('div', 'imic_div');
	// Section tag
	function imic_section( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra"			=> ''
		), $atts));
	   return '<section class="'.$extra.'">' . do_shortcode($content) . ' </section>';
	}
	add_shortcode('section', 'imic_section');
	// Spacer tag
	function imic_spacer( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"extra"			=> '',
			"size" => '',
		), $atts));
	   return '<div class="'.$size.' '.$extra.'">' . do_shortcode($content) . ' </div>';
	}
	add_shortcode('spacer', 'imic_spacer');
	// Alert tag
	function imic_alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type"			=> '',
			"close"			=> ''
		), $atts));
		$closeButton = ($close == 'true') ? '<a class="close" data-dismiss="alert" href="#">&times;</a>' : '';
	   return '<div class="alert '. $type .' fade in">  ' .$closeButton . do_shortcode($content) . ' </div>';
	}
	add_shortcode('alert', 'imic_alert');
	
	// Heading Tag
	function imic_heading_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "size" => '',
		   "extra" => '',
		   "icon" => '',
		   "type" => ''
		), $atts));
		if($icon!='') {
		$output = '<'.$size.' class="'.$extra.'"><i class="fa '.$icon.'"></i> '.do_shortcode($content).'</'.$size.'>';
		}
		else {
		$output = '<'.$size.' class="'.$extra.'">' . do_shortcode($content) .'</'.$size.'>';
		}
		return $output;
	}
	add_shortcode("heading", "imic_heading_tag");
	
	// Divider Tag
	function imic_divider_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<hr class="'. $extra .'">';
	}
	add_shortcode("divider", "imic_divider_tag");
	
	// Paragraph type 
	function imic_paragraph($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<p class="' . $extra . '">'. do_shortcode($content) .'</p>';
	}
	add_shortcode("paragraph", "imic_paragraph");
	
	// Span type 
	function imic_span($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<span class="' . $extra . '">'. do_shortcode($content) .'</span>';
	}
	add_shortcode("span", "imic_span");	
	
	// Container type 
	function imic_container($atts, $content = null) {
		extract(shortcode_atts(array(
		   "extra" => '',
		), $atts));
		
		return '<div class="' . $extra . '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode("container", "imic_container");
	
	// Dropcap type 
	function imic_dropcap($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		
		return '<p class="drop-caps ' . $type . '">'. do_shortcode($content) .'</p>';
	}
	add_shortcode("dropcap", "imic_dropcap");
		
	// Blockquote type
	function imic_blockquote($atts, $content = null) {
		extract(shortcode_atts(array(
		   "name" => '',
		), $atts));
		if(!empty($name)){ $authorName= '<cite>- '.$name.'</cite>'; }else{ $authorName= ''; } 
		return '<blockquote><p>'. do_shortcode($content) .'</p>' . $authorName . '</blockquote>';
	}
	add_shortcode("blockquote", "imic_blockquote");
	
	// Code type
	function imic_code($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		
		if($type=='inline'){ 
			return '<code>'. do_shortcode($content) .'</code>'; 
		}else{ 
			return '<pre>'. do_shortcode($content) .'</pre>'; 
		} 
		
	}
	add_shortcode("code", "imic_code");
		
	// Label Tag
	function imic_label_tag($atts, $content = null) {
		extract(shortcode_atts(array(
		   "type" => '',
		), $atts));
		$output = '<span class="label '.$type.'">' . do_shortcode($content) .'</span>';
		
		return $output;
	}
	add_shortcode("label", "imic_label_tag");	
	
	
	/* LISTS SHORTCODES
	================================================= */
	function imic_list( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"type" => '',
			"extra" => '',
			"icon" => ''
		), $atts));
				
		if($type == 'ordered'){
			$output = '<ol>' . do_shortcode($content) .'</ol>';
		}else if($type == 'desc'){
			$output = '<dl>' . do_shortcode($content) .'</dl>';
		} else{
			$output = '<ul class="'.$type .' '. $extra .'">' . do_shortcode($content) .'</ul>';		
		}
		
		return $output;		
	}
	add_shortcode('list', 'imic_list');
	
	function imic_list_item( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"icon" => '',
			"type" => ''
		), $atts));
		
		if(($type == 'icon')||($type == 'inline')){
			$output = '<li><i class="fa '.$icon.'"></i> ' . do_shortcode($content) .'</li>';
		}else{
			$output = '<li>' . do_shortcode($content) .'</li>';
		}
		return $output;		
	}
	add_shortcode('list_item', 'imic_list_item');
	
	function imic_list_item_dt( $atts, $content = null ) {		
		$output = '<dt>' . do_shortcode($content) .'</dt>';
		
		return $output;		
	}
	add_shortcode('list_item_dt', 'imic_list_item_dt');
	
	function imic_list_item_dd( $atts, $content = null ) {		
		$output = '<dd>' . do_shortcode($content) .'</dd>';
		
		return $output;		
	}
	add_shortcode('list_item_dd', 'imic_list_item_dd');
	function imic_page_first( $atts, $content = null ) {
		return '<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>';		
	}
	add_shortcode('page_first', 'imic_page_first');
	
	function imic_page_last( $atts, $content = null ) {
		return '<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>';		
	}
	add_shortcode('page_last', 'imic_page_last');	
	
	function imic_page( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"class" => ''
		), $atts));
		
		return '<li class="'.$class.'"><a href="#">'. do_shortcode($content) .' </a></li>';		
	}
	add_shortcode('page', 'imic_page');	
	
	/* TABS SHORTCODES
	================================================= */
	function imic_tabs( $atts, $content = null ) {
		return '<div class="tabs">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('tabs', 'imic_tabs');
	
	function imic_tabh( $atts, $content = null ) {
		return '<ul class="nav nav-tabs">'. do_shortcode($content) .'</ul>';		
	}
	add_shortcode('tabh', 'imic_tabh');
	
	function imic_tab( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => ''
		), $atts));
		
		return '<li class="'.$class.'"> <a data-toggle="tab" href="#'.$id.'"> '. do_shortcode($content) .' </a> </li>';		
	}
	add_shortcode('tab', 'imic_tab');	
	
	function imic_tabc( $atts, $content = null ) {		
		return '<div class="tab-content">'. do_shortcode($content) .'</div>';	
	}
	add_shortcode('tabc', 'imic_tabc');
	
	function imic_tabrow( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => ''
		), $atts));
				
		$output = '<div id="'.$id.'" class="tab-pane '.$class.'">' . do_shortcode($content) .'</div>';
		
		return $output;		
	}
	add_shortcode('tabrow', 'imic_tabrow');
	/* ACCORDION SHORTCODES
	================================================= */
	function imic_accordions( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => ''
		), $atts));
		
		return '<div class="accordion" id="accordion' .$id. '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('accordions', 'imic_accordions');
	
	function imic_accgroup( $atts, $content = null ) {
		return '<div class="accordion-group panel">'. do_shortcode($content) .'</div>';		
	}
	add_shortcode('accgroup', 'imic_accgroup');
	
	function imic_acchead( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"class" => '',
			"tab_id" =>''
		), $atts));
		
		$output = '<div class="accordion-heading accordionize"> <a class="accordion-toggle '. $class .'" data-toggle="collapse" data-parent="#accordion' .$id. '" href="#' .$tab_id. '"> '. do_shortcode($content) .' <i class="fa fa-angle-down"></i> </a> </div>';
		
		return $output;
	}
	add_shortcode('acchead', 'imic_acchead');	
	
	function imic_accbody( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"tab_id" => '',
			"in" => ''
		), $atts));
		
		$output = '<div id="' . $tab_id . '" class="accordion-body ' . $in . ' collapse">
					  <div class="accordion-inner"> '. do_shortcode($content) .' </div>
					</div>';
		
		return $output;		
	}
	add_shortcode('accbody', 'imic_accbody');
	/* TOGGLE SHORTCODES
	================================================= */
	function imic_toggles( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => ''
		), $atts));
		
		return '<div class="accordion" id="toggle' .$id. '">'. do_shortcode($content) .'</div>';
	}
	add_shortcode('toggles', 'imic_toggles');
	
	function imic_togglegroup( $atts, $content = null ) {
		return '<div class="accordion-group panel">'. do_shortcode($content) .'</div>';		
	}
	add_shortcode('togglegroup', 'imic_togglegroup');
	
	function imic_togglehead( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"id" => '',
			"tab_id" =>''
		), $atts));
		
		$output = '<div class="accordion-heading togglize"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#' .$tab_id. '"> '. do_shortcode($content) .' <i class="fa fa-plus-circle"></i> <i class="fa fa-minus-circle"></i> </a> </div>';
	
		return $output;
	}
	add_shortcode('togglehead', 'imic_togglehead');	
	
	function imic_togglebody( $atts, $content = null ) {
		extract(shortcode_atts(array(
			"tab_id" => ''
		), $atts));
		
		$output = '<div id="' . $tab_id . '" class="accordion-body collapse">
              <div class="accordion-inner"> '. do_shortcode($content) .'  </div>
            </div>';
		
		return $output;		
	}
	add_shortcode('togglebody', 'imic_togglebody');
	/* PROGRESS BAR SHORTCODE
	================================================= */
	function imic_progress_bar($atts) {
		extract(shortcode_atts(array(
			"percentage" => '',
			"name" => '',
			"type" => '',
			"value" => '',
			"colour" => ''
		), $atts));
		
		if ($type == 'progress-striped') { $typeClass = $type; } else { $typeClass = ""; }
		if ($colour == 'progress-bar-warning' ) { $warningText = '(warning)'; } else { $warningText = ""; }
		
		$service_bar_output = '';
		$progress_text = '';
		if($name!='') {
				$service_bar_output = '<div class="progress-label"> <span>' . $name . '</span> </div>';
		}
		$service_bar_output .= '<div class="progress '. $typeClass .'">';
		
		if($type == 'progress-striped'){
        	$service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%">';
			$service_bar_output .= '<span class="sr-only">' . $value . '% Complete (success)</span>';
			$service_bar_output .= '</div>';        
		}else if($type == 'colored'){
			if(!empty($warningText)){ $spanClass=''; $progress_text = $value.'% Complete '.$warningText; }else{ $spanClass='sr-only'; $progress_text = ''; }
          	$service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%"> <span class="'.$spanClass.'">' . $progress_text.'</span> </div>';
		}else{
			$service_bar_output .= '<div class="progress-bar progress-bar-primary" data-appear-progress-animation="'.$value.'%"> <span class="progress-bar-tooltip">' . $value . '%</span> </div>';
		}
        $service_bar_output .= '</div>';
		
		return $service_bar_output;
	}
	
	add_shortcode('progress_bar', 'imic_progress_bar');
	
	
	/* TOOLTIP SHORTCODE
	================================================= */
	function imic_tooltip($atts, $content = null) {
		extract(shortcode_atts(array(
			"title" => '',
			"link" => '#',
			"direction" => 'top'
		), $atts));
				
		$tooltip_output = '<a href="'.$link.'" rel="tooltip" data-toggle="tooltip" data-original-title="'.$title.'" data-placement="'.$direction.'">'.do_shortcode($content).'</a>';
		return $tooltip_output;
	}
	
	add_shortcode('imic_tooltip', 'imic_tooltip');
	/* WORDPRESS LINK SHORTCODE
	================================================= */
	function imic_wordpress_link() {
		return '<a href="http://wordpress.org/" target="_blank">WordPress</a>';
	}
	add_shortcode('wp-link', 'imic_wordpress_link');
	
	/* COUNT SHORTCODE
	================================================= */
	function imic_count($atts) {
		extract(shortcode_atts(array(
			"speed" => '2000',
			"to" => '',
			"icon" => '',
			"subject" => '',
			"textstyle" => ''
		), $atts));
		
		$count_output = '';
		if ($speed == "") {$speed = '2000'; }
		$count_output .= '<div class="col-lg-3 col-md-3 col-sm-3 cust-counter">';
		$count_output .= '<div class="fact-ico"> <i class="fa ' . $icon . ' fa-4x"></i> </div>';
		$count_output .= '<div class="clearfix"></div>';
		$count_output .= '<div class="timer" data-perc="'.$speed.'"> <span class="count">' .$to. '</span></div>';
		$count_output .= '<div class="clearfix"></div>';
		if ($textstyle == "h3") {
			$count_output .= '<h3>'.$subject.'</h3></div>';		
		} else if ($textstyle == "h6") {
			$count_output .= '<h6>'.$subject.'</h6></div>';		
		} else {
			$count_output .= '<span class="fact">'.$subject.'</span></div>';
		}
		
		return $count_output;
	}
	
	add_shortcode('imic_count', 'imic_count');
	
	/* MODAL BOX SHORTCODE
	================================================== */
	function imic_modal_box($atts, $content = null) {
		extract(shortcode_atts(array(
			"id"			=> "",
			"title" 	=> "",
			"text"	=> "",
			"button" => ""
		), $atts));
		
		$modalBox = '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#'.$id.'">'.$button.'</button>
            <div class="modal fade" id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="'.$id.'Label">'.$title.'</h4>
                  </div>
                  <div class="modal-body"> '. $text .' </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default inverted" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>';
				
		return $modalBox;
		
	}
	add_shortcode('modal_box', 'imic_modal_box');
	
	/* FORM SHORTCODE
	================================================== */
	function imic_form_code($atts, $content = null) {
   extract(shortcode_atts(array(
        "form_email" => '',
        "form_title" => '',
                    ), $atts));
     if(!empty($form_email)){
        $admin_email = $form_email; 
      }else{
      $admin_email = get_option('admin_email');
       }
       $contact_title='';
       if(!empty($form_title)){
        $contact_title = '<h2>'.$form_title.'</h2>'; 
       }
$formCode = '<form action="'.IMIC_THEME_PATH.'/mail/contact.php" type="post" class="contact-form clearfix" id="contactform">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<input type="text" id="fname" name="fname"  class="form-control input-lg" placeholder="'.__('Name','framework').' *">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" id="lname" name="Last Name"  class="form-control input-lg" placeholder="'.__('Last name','framework').'">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="email" id="email" name="email"  class="form-control input-lg" placeholder="'.__('Email','framework').' *">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="'.__('Phone','framework').'">
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<textarea cols="6" rows="7" id="comments" name="comments" class="form-control input-lg" placeholder="'.__('Message','framework').'"></textarea>
<input type ="hidden" name ="image_path" id="image_path" value ="'.IMIC_THEME_PATH.'">
<input type ="hidden" name ="recipients" id="recipients" value ="">
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg btn-block" value="'.__('Submit','framework').'">
</div>
</div>
<div class="clearfix"></div>
</form><div id="message"></div>';
    return $formCode;
}
	add_shortcode('imic_form', 'imic_form_code');
         /* Event Calendar SHORTCODE
  ================================================= */
function event_calendar($atts) {
    extract(shortcode_atts(array(
        "category_id" => '',
		"filter" => '',
		"preview" => '',
                    ), $atts));
		wp_enqueue_style('imic_fullcalendar_css');
		wp_enqueue_style('imic_fullcalendar_print');
	global $imic_options;
	$facebook = $imic_options['share_icon'][1];
	$twitter = $imic_options['share_icon'][2];
	$google = $imic_options['share_icon'][3];
	$tumblr = $imic_options['share_icon'][4];
	$pinterest = $imic_options['share_icon'][5];
	$reddit = $imic_options['share_icon'][6];
	$linkedin = $imic_options['share_icon'][7];
	$email_share = $imic_options['share_icon'][8];
       	$event_preview = $preview;
		$term_output = '';
		if($filter==1) { 
		$e_terms = get_terms('event-category');
		$term_output .= '<div class="events-listing-header"><ul class="sort-calendar sort-source"><li class="e1Div active" id=""><a href="javascript:void(0)">'.__('All','framework').'</a></li>';
		if($imic_options['google_feed_id']!='') { 
		$term_output .= '<li class="e1Div" id="google"><a href="javascript:void(0)">'.__('Google','framework').'</a></li>'; }
		foreach($e_terms as $term) {
		$term_output .= '<li class="e1Div" id="'.$term->term_id.'"><a href="javascript:void(0)">'.$term->name.'</a></li>'; }
		$term_output .= '</ul></div>'; }
		//$google_feeds = $imic_options['google_feed'];
		$google_api_key = $imic_options['google_feed_key'];
		$google_calendar_id = $imic_options['google_feed_id'];
        $monthNamesValue = $imic_options['calendar_month_name'];
        $monthNames = (empty($monthNamesValue)) ? array() : explode(',', trim($monthNamesValue));
        $monthNamesShortValue = $imic_options['calendar_month_name_short'];
        $monthNamesShort = (empty($monthNamesShortValue)) ? array() : explode(',', trim($monthNamesShortValue));
        $dayNamesValue = $imic_options['calendar_day_name'];
        $dayNames = (empty($dayNamesValue)) ? array() : explode(',', trim($dayNamesValue));
        $dayNamesShortValue = $imic_options['calendar_day_name_short'];
        $dayNamesShort = (empty($dayNamesShortValue)) ? array() : explode(',', trim($dayNamesShortValue));
		wp_enqueue_script('imic_fullcalendar');
		wp_enqueue_script('imic_gcal');
		wp_enqueue_script('imic_calender_events');
		wp_enqueue_script('imic_jquery_countdown');
		wp_localize_script('imic_jquery_countdown', 'upcoming_data', array('c_time' =>time()));
		wp_enqueue_script('imic_counter_init');
		$format=ImicConvertDate(get_option('time_format'));
        wp_localize_script('imic_calender_events', 'calenderEvents', array('homeurl' => get_template_directory_uri(), 'monthNames' => $monthNames, 'monthNamesShort' => $monthNamesShort, 'dayNames' => $dayNames, 'dayNamesShort' => $dayNamesShort,'time_format'=>$format,'start_of_week'=>get_option('start_of_week'),'googlekey'=>$google_api_key,'googlecalid'=>$google_calendar_id,'ajaxurl' => admin_url('admin-ajax.php'),'preview'=>$event_preview,'facebook'=>$facebook,'twitter'=>$twitter,'google'=>$google,'tumblr'=>$tumblr,'pinterest'=>$pinterest,'reddit'=>$reddit,'linkedin'=>$linkedin,'email'=>$email_share));
		if($event_preview==1) {
			$output = '';
			$events = imic_recur_events('future','',''); ksort($events); foreach($events as $key=>$value) { $id = $value; break; }
			$date_converted=date('Y-m-d',$key );
    $custom_event_url= imic_query_arg($date_converted,$id);
	$start_time = '23:59';
	$start_time_meta = get_post_meta($id,'imic_event_start_dt',true);
	if($start_time_meta!='') {
	$start_time_meta = strtotime($start_time_meta);
	$start_time = date('G:i',$start_time_meta); }
	$st_time = '';
	$st_time = date('Y-m-d',$key);
	$st_time = strtotime($st_time.' '.$start_time);
	$output .= '<ul class=" sort-destination events-ajax-caller">';
	$output .= '<li class="event-item event-dynamic">';
	$output .= '<div class="grid-item-inner">';
	$output .= '<div class="preview-event-bar">
                            <div id="counter" class="counter-preview top-header" data-date="'.$key.'">
                         		<div class="timer-col"> <span id="days"></span> <span class="timer-type">'.__('d','framework').'</span> </div>
                        		<div class="timer-col"> <span id="hours"></span> <span class="timer-type">'.__('h','framework').'</span> </div>
                      			<div class="timer-col"> <span id="minutes"></span> <span class="timer-type">'.__('m','framework').'</span> </div>
                         		<div class="timer-col"> <span id="seconds"></span> <span class="timer-type">'.__('s','framework').'</span> </div>
                            </div>
                        </div>';
	$event_address = get_post_meta($id,'imic_event_address2',true);
	
	if ( '' != get_the_post_thumbnail($id) ) { 
	$output .= '<a href="'.esc_url($custom_event_url).'" class="media-box">'.get_the_post_thumbnail($id,'full').'</a>'; }
	$output .= '<div id="load-preview-events" class="load-events" style="display:none;"><img src="'.IMIC_THEME_PATH.'/images/loader.gif"></div>';
	$output .= '<div class="grid-content">';
	$output .= '<h3><a class="event-title" href="'.esc_url($custom_event_url).'">'.get_the_title($id).'</a></h3>';
	$address1 = get_post_meta($id,'imic_event_address1',true);
	$address2 = get_post_meta($id,'imic_event_address2',true);
  	$output .= '<span class="meta-data"><i class="fa fa-calendar"></i> <span class="event-date">'.esc_attr(date_i18n(get_option('date_format'),$key)).'</span>'.__(' at ','framework').'<span class="event-time">'.esc_attr(date_i18n(get_option('time_format'), $st_time)).'</span></span>
                                    <span class="meta-data event-location-address"><i class="fa fa-map-marker"></i> '.esc_attr($event_address).'</span>';
	$output .= '</div>';
	$output .= '<div class="grid-footer clearfix">';
	$event_registration = get_post_meta($value,'imic_event_registration',true); if($event_registration==1) {
   	$output .= '<a id="register-'.($value+2648).'|'.$key.'" href="#" class="pull-right btn btn-sm btn-primary btn-sm event-tickets event-register-button">'.__('Register','framework').'</a>'; }
 	$output .= '<ul class="action-buttons">';
	if ($imic_options['switch_sharing'] == 1 && $imic_options['share_post_types']['3'] == '1') {
  	$output .= '<li title="Share event"><a href="#" data-trigger="focus" data-placement="right" data-content="" data-toggle="popover" data-original-title="Share Event" class="event-share-link"><i class="icon-share"></i></a></li>'; } 
	$event_map = get_post_meta($value,'imic_event_address2',true); if($event_map!='') {
 	$output .= '<li title="Get directions" class="hidden-xs"><a href="#" class="cover-overlay-trigger event-direction-link"><i class="icon-compass"></i></a></li>'; } 
	$event_contact_info = get_post_meta($value,'imic_event_manager',true); if($event_contact_info!='') {
   	$output .= '<li title="Contact event manager"><a id="contact-'.($value+2648).'|'.$key.'" href="#" data-toggle="modal" data-target="#Econtact" class="event-contact-link"><i class="icon-mail"></i></a></li>'; } 
  	$output .= '</ul></div>';
	
    $output .= '</div></div></li></ul>';
			return '<div class="row"><div class="col-md-9">'.$term_output.'<div id="calendar"><div id ="'.$category_id.'" class ="event_calendar calendar"></div></div></div><div class="col-md-3"><h2 class="title ">'.__('Event Preview','framework').'</h2><div id="events-preview-box">'.$output.'</div></div>';
		}else {
			return $term_output.'<div id="calendar"><div id ="'.$category_id.'" class ="event_calendar calendar"></div></div>'; }
}
add_shortcode('event_calendar', 'event_calendar');
?>