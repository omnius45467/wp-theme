/*
 *
 *	Admin jQuery Functions
 *	------------------------------------------------
 *	Imic Framework
 * 	Copyright Imic 2014 - http://imicreation.com
 *
 */
jQuery(window).load(function() {
    jQuery('#imic_number_of_post_cat').parent().parent().find('.rwmb-clone').each(function() {
        jQuery(this).find('.rwmb-button').hide();
    })
    jQuery('#imic_number_of_post_cat').parent().parent().find('.add-clone').hide();
jQuery('#wpseo_meta.postbox').show();
});
jQuery(function(jQuery) {
//SELECTED TEMPLATE BASED META BOX DISPLAY
    function show_hide_metabox() {
        if ((jQuery('body').hasClass('post-php')||(jQuery('body').hasClass('post-new-php')))&&jQuery('body').hasClass('post-type-page')) {
			if (jQuery('#page_template').length) {
            var metaID = jQuery('#page_template').val().slice(0, -4);
            metaboxName = metaID.substring(metaID.indexOf('-') + 1);
            jQuery('#normal-sortables > div').each(function(i, k)
            {
                if (jQuery(this).attr('id').indexOf(metaboxName) != -1)
                {
                jQuery(this).show();
                }
                else
                {
                    jQuery(this).hide();
                }
				if(metaboxName=='sermon') {
					jQuery("#template-sermon-two1").hide();
				}
				if(metaboxName=='sermon-two') {
					jQuery("#template-sermon-two1").show();
				}
                if(metaboxName=='home-pb'){
					jQuery('#template-home28').show();
				}
                if(metaboxName=='home-second'){
					jQuery('#template-home14').show();
					jQuery('#template-home12').show();
					jQuery('#template-home28').show();
					jQuery('#template-home27').show();
                     jQuery('#template-home26').show();
					 jQuery('#template-home25').show();
					 jQuery('#template-sidebar1').hide();
                }
				else if(metaboxName=='home') {
					jQuery('#template-sidebar1').hide();
				}
                else{
				 jQuery('#template-sidebar1').show();  
                }
                 jQuery('#post_page_meta_box').show();
		})
        } else {
				jQuery("#template-gallery1").hide();
				jQuery("#template-sermon1").hide();
				jQuery("#template-sermon-two1").hide();
				jQuery("#template-event1").hide();
				jQuery("#template-blog-masonry1").hide();
				jQuery("#template-contact1").hide();
				jQuery("#template-contact2").hide();
				jQuery("#template-home14").hide();
				jQuery("#template-home28").hide();
				jQuery("#template-home26").hide();
				jQuery("#template-home25").hide();
				jQuery("#template-home27").hide();
				jQuery("#template-home12").hide();
			} }
		
    }
    show_hide_metabox();
    // META FIELD DISPLAY ON TEMPLATE SELECT
    jQuery('#page_template').on('change', function() {
        show_hide_metabox();
    });
    // META FIELD DISPLAY ON TEMPLATE SELECT
     // Hide Revslider Metabox
    jQuery('#mymetabox_revslider_0').hide();
    // Map Display
    var $imic_contact_banner_type = jQuery('#imic_contact_banner_type');
    function map_display() {
		if($imic_contact_banner_type.val()=='1') {
			jQuery("#post_page_meta_box").hide();
			jQuery("#imic_contact_map_address").parent().parent().show();
		}
		else {
			jQuery("#post_page_meta_box").show();
			jQuery("#imic_contact_map_address").parent().parent().hide();
		}
    }
    map_display();
    $imic_contact_banner_type.change(function() {
        map_display();
    });
    
	// Post Section for home
    var $imic_Choose_post_type = jQuery('#imic_selected_post_type');
    function select_post_type_home() {
        var $imic_post_category = jQuery('#imic_post_category').parent().parent();
        var $imic_event_category = jQuery('#imic_event_category').parent().parent();
        var $imic_gallery_category = jQuery('#imic_gallery_category').parent().parent();
        var $imic_project_category = jQuery('#imic_project_category').parent().parent();
        var $imic_product_category = jQuery('#imic_product_category').parent().parent();
        var $imic_post_options = jQuery('label[for="imic_select_post_options"]').parent().parent();
		var $imic_post_content = jQuery('label[for="imic_select_post_content"]').parent().parent();
		var $imic_image_hyperlink = jQuery('label[for="imic_select_thumb_hyperlink"]').parent().parent();
		var $imic_title_hyperlink = jQuery('label[for="imic_select_title_hyperlink"]').parent().parent();
        if ($imic_Choose_post_type.val() == 'post') {
            $imic_post_category.show();
            $imic_event_category.hide();
            $imic_gallery_category.hide();
            $imic_project_category.hide();
            $imic_product_category.hide();
			$imic_post_options.show();
			$imic_post_content.show();
			$imic_image_hyperlink.show();
			$imic_title_hyperlink.show();
        }
		else if($imic_Choose_post_type.val() == 'gallery'){
             $imic_post_category.hide();
            $imic_event_category.hide();
            $imic_gallery_category.show();
            $imic_project_category.hide();
            $imic_product_category.hide();
			$imic_post_options.show();
			$imic_post_content.show();
			$imic_image_hyperlink.show();
			$imic_title_hyperlink.show();
        }
		else if($imic_Choose_post_type.val() == 'sermon'){
             $imic_post_category.hide();
            $imic_event_category.hide();
            $imic_gallery_category.hide();
            $imic_project_category.show();
            $imic_product_category.hide();
			$imic_post_options.show();
			$imic_post_content.show();
			$imic_image_hyperlink.show();
			$imic_title_hyperlink.show();
        }
		else if($imic_Choose_post_type.val() == 'product'){
             $imic_post_category.hide();
            $imic_event_category.hide();
            $imic_gallery_category.hide();
            $imic_project_category.hide();
            $imic_product_category.show();
			$imic_post_options.show();
			$imic_post_content.show();
			$imic_image_hyperlink.show();
			$imic_title_hyperlink.show();
        }
		else {
			$imic_post_category.hide();
            $imic_event_category.hide();
            $imic_gallery_category.hide();
            $imic_project_category.hide();
            $imic_product_category.hide();
			$imic_post_options.show();
			$imic_post_content.show();
			$imic_image_hyperlink.show();
			$imic_title_hyperlink.show();
		}
    }
    select_post_type_home();
    $imic_Choose_post_type.change(function() {
        select_post_type_home();
    });
	// Enable Disable Post Section 1 for Homepage
	var $imic_section1_status = jQuery('#imic_status_section1');
    function section1_home_status() {
		var $imic_section1_sidebar = jQuery('#imic_section1_homepage_sidebar').parent().parent();
		var $imic_section1_link_title = jQuery('#imic_section1_link_title').parent().parent();
		var $imic_section1_link_url = jQuery('#imic_section1_page_link').parent().parent();
		var $imic_section1_heading = jQuery('#imic_section1_heading').parent().parent();
		var $imic_section1_event_type = jQuery('#imic_section1_event_type').parent().parent();
		var $imic_section1_event_category = jQuery('#imic_section1_event_category').parent().parent();
        var $imic_section1_event_count = jQuery('#imic_section1_event_count').parent().parent();
		if($imic_section1_status.val()==1) {
			$imic_section1_sidebar.show();
			$imic_section1_link_title.show();
			$imic_section1_link_url.show();
			$imic_section1_heading.show();
			$imic_section1_event_type.show();
			$imic_section1_event_category.show();
			$imic_section1_event_count.show(); }
		else {
			 $imic_section1_sidebar.hide();
			$imic_section1_link_title.hide();
			$imic_section1_link_url.hide();
			$imic_section1_heading.hide();
			$imic_section1_event_type.hide();
			$imic_section1_event_category.hide();
			$imic_section1_event_count.hide();
		}
    }
    section1_home_status();
    $imic_section1_status.change(function() {
        section1_home_status();
    });
	// Enable Disable Post Section 2 for Homepage
	var $imic_section2_status = jQuery('#imic_status_section2');
    function section2_home_status() {
		
		var $imic_section2_sidebar = jQuery('#imic_section2_homepage_sidebar').parent().parent();
		var $imic_section2_heading = jQuery('#imic_section2_heading').parent().parent();
		var $imic_section2_recent_post_status = jQuery('#imic_status_latest_post').parent().parent();
		var $imic_section2_recent_post_title = jQuery('#imic_section2_recent_title').parent().parent();
		var $imic_section2_post_type = jQuery('#imic_selected_post_type').parent().parent();
		var $imic_section2_post_count = jQuery('#imic_posts_to_show_on').parent().parent();
        var $imic_post_category = jQuery('#imic_post_category').parent().parent();
        var $imic_event_category = jQuery('#imic_event_category').parent().parent();
        var $imic_gallery_category = jQuery('#imic_gallery_category').parent().parent();
        var $imic_project_category = jQuery('#imic_sermon_category').parent().parent();
        var $imic_product_category = jQuery('#imic_product_category').parent().parent();
        var $imic_post_options = jQuery('label[for="imic_select_post_options"]').parent().parent();
		var $imic_post_content = jQuery('label[for="imic_select_post_content"]').parent().parent();
		var $imic_image_hyperlink = jQuery('label[for="imic_select_thumb_hyperlink"]').parent().parent();
		var $imic_title_hyperlink = jQuery('label[for="imic_select_title_hyperlink"]').parent().parent();
		var $imic_section2_excerpt_length = jQuery('#imic_section2_excerpt_length').parent().parent();
		var $imic_section2_post_excerpt_length = jQuery('#imic_section2_post_excerpt_length').parent().parent();
		if($imic_section2_status.val()==1) {
			$imic_post_category.show();
            $imic_event_category.hide();
            $imic_gallery_category.hide();
            $imic_project_category.hide();
            $imic_product_category.hide();
			$imic_post_options.show();
			$imic_post_content.show();
			$imic_image_hyperlink.show();
			$imic_title_hyperlink.show();
			$imic_section2_sidebar.show();
			$imic_section2_heading.show();
			$imic_section2_recent_post_status.show();
			$imic_section2_recent_post_title.show();
			$imic_section2_post_type.show();
			$imic_section2_excerpt_length.show();
			$imic_section2_post_excerpt_length.show();
			$imic_section2_post_count.show(); }
		else {
			 $imic_post_category.hide();
            $imic_event_category.hide();
            $imic_gallery_category.hide();
            $imic_project_category.hide();
            $imic_product_category.hide();
			$imic_post_options.hide();
			$imic_post_content.hide();
			$imic_image_hyperlink.hide();
			$imic_title_hyperlink.hide();
			$imic_section2_sidebar.hide();
			$imic_section2_heading.hide();
			$imic_section2_recent_post_status.hide();
			$imic_section2_recent_post_title.hide();
			$imic_section2_post_type.hide();
			$imic_section2_post_count.hide();
			$imic_section2_excerpt_length.hide();
			$imic_section2_post_excerpt_length.hide();
		}
    }
    section2_home_status();
    $imic_section2_status.change(function() {
        section2_home_status();
    });
	//header options for page/post
	var $imic_pages_choose_slider_display = jQuery('#imic_pages_Choose_slider_display');
    function pages_slider_display() {
        var $imic_pages_slider_image = jQuery('#imic_pages_slider_image_description').parent().parent();
        var $imic_pages_slider_pagination = jQuery('#imic_pages_slider_pagination').parent().parent();
        var $imic_pages_slider_auto_slide = jQuery('#imic_pages_slider_auto_slide').parent().parent();
        var $imic_pages_slider_direction_arrows = jQuery('#imic_pages_slider_direction_arrows').parent().parent();
        var $imic_pages_slider_interval = jQuery('#imic_pages_slider_interval').parent().parent();
        var $imic_pages_slider_effects = jQuery('#imic_pages_slider_effects').parent().parent();
		var $imic_pages_nivo_effects = jQuery('#imic_pages_nivo_effects').parent().parent();
        var $imic_pages_select_revolution_from_list = jQuery('#imic_pages_select_revolution_from_list').parent().parent();
		var $imic_pages_select_layer_from_list = jQuery('#imic_pages_select_layer_from_list').parent().parent();
		var $imic_banner_image = jQuery('#imic_header_image_description').parent().parent();
		var $imic_pages_slider_height = jQuery('#imic_pages_slider_height').parent().parent();
		var $imic_pages_banner_description = jQuery('#imic_pages_banner_description').parent().parent();
		var $imic_banner_overlay = jQuery('label[for="imic_pages_banner_overlay"]').parent().parent();
		var $imic_banner_animation = jQuery('label[for="imic_pages_banner_animation"]').parent().parent();
            var $imic_pages_banner_color = jQuery('#imic_pages_banner_color').closest('.rwmb-field');
           if ($imic_pages_choose_slider_display.val() == 3) {
            $imic_pages_slider_image.show();
            $imic_pages_slider_pagination.show();
            $imic_pages_slider_auto_slide.show();
            $imic_pages_slider_direction_arrows.show();
            $imic_pages_slider_interval.show();
            $imic_pages_slider_effects.show();
			 $imic_pages_slider_height.show();
			 $imic_banner_overlay.show();
			 $imic_banner_animation.show();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_select_layer_from_list.hide();
			 $imic_banner_image.hide();
			 $imic_pages_banner_color.hide();
			 $imic_pages_nivo_effects.hide();
			 $imic_pages_banner_description.hide();
        }
		else if ($imic_pages_choose_slider_display.val() == 4) {
            $imic_pages_slider_image.show();
            $imic_pages_slider_pagination.show();
            $imic_pages_slider_auto_slide.show();
            $imic_pages_slider_direction_arrows.show();
            $imic_pages_slider_interval.show();
			$imic_pages_nivo_effects.show();
			$imic_banner_overlay.show();
			 $imic_banner_animation.hide();
            $imic_pages_slider_effects.hide();
			 $imic_pages_slider_height.hide();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_select_layer_from_list.hide();
			 $imic_banner_image.hide();
			 $imic_pages_banner_color.hide();
			 $imic_pages_banner_description.hide();
        }
		else if($imic_pages_choose_slider_display.val() == 2) {
			  $imic_banner_image.show();
			  $imic_banner_overlay.show();
			 $imic_banner_animation.show();
			  $imic_pages_banner_description.show();
			  $imic_pages_slider_image.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_interval.hide();
            $imic_pages_slider_effects.hide();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_select_layer_from_list.hide();
			$imic_pages_slider_height.show();
			$imic_pages_banner_color.hide();
			$imic_pages_nivo_effects.hide();
		}
        else if($imic_pages_choose_slider_display.val() == 5) {
             $imic_pages_slider_image.hide();
			 $imic_pages_banner_description.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_interval.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_effects.hide();
			$imic_banner_image.hide();
			$imic_pages_slider_height.hide();
			$imic_pages_banner_color.hide();
			$imic_pages_nivo_effects.hide();
			$imic_banner_overlay.hide();
			 $imic_banner_animation.hide();
            $imic_pages_select_revolution_from_list.show();
			$imic_pages_select_layer_from_list.hide();
        }
		else if($imic_pages_choose_slider_display.val() == 1) {
			$imic_pages_banner_color.show();
			$imic_banner_overlay.show();
			 $imic_banner_animation.show();
			$imic_pages_banner_description.show();
			$imic_pages_slider_image.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_interval.hide();
            $imic_pages_slider_effects.hide();
			$imic_banner_image.hide();
			$imic_pages_slider_height.show();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_nivo_effects.hide();
			$imic_pages_select_layer_from_list.hide();
		}
		else {
			$imic_pages_select_layer_from_list.show();
			$imic_pages_slider_image.hide();
            $imic_pages_slider_pagination.hide();
            $imic_pages_slider_auto_slide.hide();
            $imic_pages_slider_direction_arrows.hide();
            $imic_pages_slider_interval.hide();
            $imic_pages_slider_effects.hide();
			$imic_banner_image.hide();
			$imic_pages_slider_height.hide();
            $imic_pages_select_revolution_from_list.hide();
			$imic_pages_banner_color.hide();
			$imic_pages_nivo_effects.hide();
			$imic_pages_banner_description.hide();
			$imic_banner_overlay.hide();
			 $imic_banner_animation.hide();
		}
    }
    pages_slider_display();
    $imic_pages_choose_slider_display.change(function() {
        pages_slider_display();
    });
    jQuery('.repeatable-add').click(function() {
        field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
        fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
        jQuery('input', field).val('').attr('name', function(index, name) {
            return name.replace(/(\d+)/, function(fullMatch, n) {
                return Number(n) + 1;
            });
        })
        field.insertAfter(fieldLocation, jQuery(this).closest('td'))
        return false;
    });
    jQuery('.repeatable-remove').click(function() {
        jQuery(this).parent().remove();
        return false;
    });
   //Megamenu
     var megamenu = jQuery('.megamenu');
    megamenu.each(function() {
        checkCheckbox(jQuery(this));
    });
    megamenu.click(function() {
        checkCheckbox(jQuery(this));
    })
    function checkCheckbox(mega_check) {
        if (mega_check.is(':checked')) {
            mega_check.parents('.custom_menu_data').find('.enabled_mega_data').show();
        }
        else {
            mega_check.parents('.custom_menu_data').find('.enabled_mega_data').hide();
        }
    }
    var menu_post_type = jQuery('.enabled_mega_data .menu-post-type');
    function show_hide_post() {
        menu_post_type.each(function() {
            if (jQuery(this).val() == '') {
                jQuery(this).parents('.enabled_mega_data').find('.menu-post-id-comma').parent().parent().show();
                jQuery(this).parents('.enabled_mega_data').find('.menu-post').parent().parent().hide();
            }
            else {
                jQuery(this).parents('.enabled_mega_data').find('.menu-post-id-comma').parent().parent().hide();
                jQuery(this).parents('.enabled_mega_data').find('.menu-post').parent().parent().show();
            }
        })
    }
    show_hide_post();
    menu_post_type.on('change', function() {
        show_hide_post();
    });
  // Event Recurrence Box
    var $imic_event_frequency_type = jQuery('#imic_event_frequency_type');
   function eventRecurrenceDisplay() {
        var $imic_event_day_month = jQuery('#imic_event_day_month').closest('.rwmb-field');
        var $imic_event_week_day = jQuery('#imic_event_week_day').closest('.rwmb-field');
        var $imic_event_frequency = jQuery('#imic_event_frequency').closest('.rwmb-field');
        var $imic_event_frequency_count = jQuery('#imic_event_frequency_count').closest('.rwmb-field');
     if ($imic_event_frequency_type.val() == 0) {
            $imic_event_day_month.hide();
            $imic_event_week_day.hide();
            $imic_event_frequency.hide();
            $imic_event_frequency_count.hide();
       }
       else if ($imic_event_frequency_type.val() == 1) {
            $imic_event_day_month.hide();
            $imic_event_week_day.hide();
            $imic_event_frequency.show();
            $imic_event_frequency_count.show();
       }
        else {
            $imic_event_day_month.show();
            $imic_event_week_day.show();
            $imic_event_frequency.hide();
            $imic_event_frequency_count.show();
        }
    }
    eventRecurrenceDisplay();
    $imic_event_frequency_type.change(function() {
        eventRecurrenceDisplay();
    });
    // Youtube/vimeo url
    var $imic_post_video_option_id = jQuery('#imic_post_video_option');
    function video_option() {
        var $gallery_video_url_wrapper = jQuery('#imic_gallery_video_url').closest('.rwmb-field');
        var $imic_post_mp4_video = jQuery('#imic_post_mp4_video').closest('.rwmb-field');
        var $imic_post_webm_video = jQuery('#imic_post_webm_video').closest('.rwmb-field');
        var $imic_post_ogg_video = jQuery('#imic_post_ogg_video').closest('.rwmb-field');
        if ($imic_post_video_option_id.val() === '1') {
        $gallery_video_url_wrapper.show();
        $imic_post_mp4_video.hide();
        $imic_post_webm_video.hide();
        $imic_post_ogg_video.hide();
    }
        else {
           $gallery_video_url_wrapper.hide();
        $imic_post_mp4_video.show();
        $imic_post_webm_video.show();
        $imic_post_ogg_video.show();
        }
    }
   
    $imic_post_video_option_id.change(function() {
        video_option();
    });
    
	var imic_gallery_meta_box = jQuery('#gallery_meta_box');
     var $imic_post_video_option = jQuery('#imic_post_video_option').closest('.rwmb-field');
     var $gallery_video_url_wrapper = jQuery('#imic_gallery_video_url').closest('.rwmb-field');
        var $imic_post_mp4_video = jQuery('#imic_post_mp4_video').closest('.rwmb-field');
        var $imic_post_webm_video = jQuery('#imic_post_webm_video').closest('.rwmb-field');
        var $imic_post_ogg_video = jQuery('#imic_post_ogg_video').closest('.rwmb-field');
    var imic_gallery_link_url = jQuery('#imic_gallery_link_url').parent().parent();
    var imic_gallery_slider_images = jQuery('#imic_gallery_images_description').parent().parent();
    var imic_gallery_audio = jQuery('#imic_gallery_audio').parent().parent();
     var imic_gallery_audio_display = jQuery('#imic_gallery_audio_display').closest('.rwmb-field');
    var imic_gallery_audio_uploaded = jQuery('#imic_gallery_uploaded_audio_description').closest('.rwmb-field');;
   var imic_gallery_slider_all =jQuery('#imic_gallery_slider_pagination,#imic_gallery_slider_speed,#imic_gallery_slider_auto_slide,#imic_gallery_slider_direction_arrows,#imic_gallery_slider_effects').parent().parent();
   function checkPostFormat(radio_val) {
        if (jQuery.trim(radio_val) == 'video') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.hide();
            imic_gallery_slider_images.hide();
            imic_gallery_audio_display.hide();
            imic_gallery_audio_uploaded.hide();
            imic_gallery_slider_all.hide();
            imic_gallery_audio.hide();
            $imic_post_video_option.show();
          video_option();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').show();
        }
        else if (jQuery.trim(radio_val) == 'link') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.show();
            imic_gallery_slider_images.hide();
            imic_gallery_audio.hide();
            imic_gallery_audio_display.hide();
            imic_gallery_slider_all.hide();
            imic_gallery_audio_uploaded.hide();
           $gallery_video_url_wrapper.hide();
           $imic_post_video_option.hide();
        $imic_post_mp4_video.hide();
        $imic_post_webm_video.hide();
        $imic_post_ogg_video.hide();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').show();
        }
        else if (jQuery.trim(radio_val) == 'gallery') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.hide();
            imic_gallery_slider_images.show();
            imic_gallery_audio.hide();
            imic_gallery_audio_display.hide();
            imic_gallery_audio_uploaded.hide();
            imic_gallery_slider_all.show();
         $gallery_video_url_wrapper.hide();
         $imic_post_video_option.hide();
        $imic_post_mp4_video.hide();
        $imic_post_webm_video.hide();
        $imic_post_ogg_video.hide();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').hide();
        }
         else if (jQuery.trim(radio_val) == 'audio') {
            imic_gallery_meta_box.show();
            imic_gallery_link_url.hide();
            imic_gallery_slider_images.hide();
            imic_gallery_slider_all.hide();
            $imic_post_video_option.hide();
            $gallery_video_url_wrapper.hide();
        $imic_post_mp4_video.hide();
        $imic_post_webm_video.hide();
        $imic_post_ogg_video.hide();
            imic_gallery_audio.show();
            imic_gallery_audio_display.show();
            imic_gallery_audio_uploaded.show();
            imic_gallery_meta_box.find('#imic_gallery_slider_image_description').closest('.rwmb-field').show();
            
        }
        else {
            imic_gallery_meta_box.hide();
            
        }
    }
    jQuery('.post-type-gallery .post-format,.post-type-post .post-format').click(function() {
        if (jQuery(this).is(':checked'))
        {
            var radio_val = jQuery(this).val();
            checkPostFormat(radio_val)
        }
    })
    jQuery('.post-type-gallery,.post-type-post').find('.post-format').each(function() {
        if (jQuery(this).is(':checked'))
        {
            var radio_val = jQuery(this).val();
            checkPostFormat(radio_val);
            
        }
    });
 });
  //Load Social Sites list for Staff Members
jQuery("#staff_meta_box").on('click','#Social',function(){
	var text_name = jQuery(this).find('input[type=text]').attr('name');
        jQuery( "body" ).data("text_name", text_name );
        jQuery("label#Social input").removeClass("fb");
	jQuery("label#Social").addClass("sfb");
	name = jQuery("label.sfb input").addClass("fb");
	var label = jQuery('label[for="'+jQuery(this).attr('id')+'"]');
	if(jQuery("#socialicons").length == 0) {
	jQuery("#staff_meta_box").append("<div id=\"socialicons\"><div class=\"inside\"><div class=\"rwmb-meta-box\"><div class=\"rwmb-field rwmb-select-wrapper\"><div class=\"rwmb-label\"><label for=\"select_social_icons\">Select Social Icons</label></div><div class=\"rwmb-input\"><select class=\"rwmb-select\" id=\"social\"><option value\"select\">Select</option><option value=\"facebook\">facebook</option><option value=\"bitbucket\">bitbucket</option><option value=\"dribbble\">dribbble</option><option value=\"dropbox\">dropbox</option><option value=\"flickr\">flickr</option><option value=\"foursquare\">foursquare</option><option value=\"github\">github</option><option value=\"gittip\">gittip</option><option value=\"google-plus\">google-plus</option><option value=\"instagram\">instagram</option><option value=\"linkedin\">linkedin</option><option value=\"pagelines\">pagelines</option><option value=\"pinterest\">pinterest</option><option value=\"skype\">skype</option><option value=\"tumblr\">tumblr</option><option value=\"twitter\">twitter</option><option value=\"vimeo-square\">vimeo-square</option><option value=\"youtube\">youtube</option></select></div></div></div></div></div></div>");
	}
});
jQuery("#staff_meta_box").on('change','div#socialicons select#social',function(text_id){
		text_name=jQuery( "body" ).data( "text_name" );
                jQuery("#socialicons").remove();
                jQuery("label[id='Social']").find('input[name$="'+text_name+'"]').val(this.value);
//		jQuery( 'input[name$="'+text_name+'"]').val(this.value);
		jQuery("input").removeClass("fb");
	});
        jQuery("label[for='imic_social_icon_list']").click(function(e){
            e.preventDefault();
        });