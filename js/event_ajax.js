jQuery(document).ready(function() {
	var $monthly_events = jQuery("#monthly-events");
    jQuery("#ajax_events").on("click", "a.upcomingEvents", function(event) {
        var dateEvent = jQuery(this).attr('id');
		var termEvent = jQuery(this).attr('rel');
        jQuery('.listing-cont').fadeOut('slow');
		jQuery('#load-next-events').show();
        jQuery.ajax({
            type: 'POST',
            url: urlajax.ajaxurl,
            data: {
                action: 'imic_event_grid',
                date: dateEvent,
				term: termEvent,
            },
            success: function(data) {
				jQuery('#load-next-events').hide();
				var event_data = data.split("~!");
                jQuery('.listing-cont').fadeIn('slow');
				jQuery(".listing-header").html('');
				jQuery(".listing-header").append(event_data[0]);
                jQuery('.events-listing-content').html('');
                //jQuery('.events-listing-content').append(event_data[1]);
				var lis = event_data[1];
				$monthly_events.isotope('destroy'); //destroying isotope
                jQuery("#monthly-events").append(lis);
				jQuery('.event-dynamic, .event-item').each(function(){
	var ESURL = jQuery(this).find(".event-title").attr("href");
	var SHARED = ('<ul class="social-icons-colored inverted">');
	if(urlajax.google=='1') {
	SHARED += ('<li class="googleplus"><a href="https://plus.google.com/share?url='+ESURL+'" target="_blank"><i class="fa fa-google-plus"></i></a></li>'); } if(urlajax.twitter=='1') {
	SHARED += ('<li class="twitter"><a href="https://twitter.com/home?status=Event%20happening%20at%20Adore%20Church%20'+ESURL+'" target="_blank"><i class="fa fa-twitter"></i></a></li>'); } if(urlajax.facebook=='1') {
	SHARED += ('<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u='+ESURL+'" target="_blank"><i class="fa fa-facebook"></i></a></li>'); } if(urlajax.tumblr=='1') {
	SHARED += ('<li class="tumblr-share"><a href="http://www.tumblr.com/share?v=3&u='+ESURL+' target="_blank" title="Post to Tumblr"><i class="fa fa-tumblr"></i></a></li>'); } if(urlajax.pinterest=='1') {
	SHARED += ('<li class="pinterest-share"><a href="http://pinterest.com/pin/create/button/?url='+ESURL+' target="_blank" title="Pin it"><i class="fa fa-pinterest"></i></a></li>'); } if(urlajax.reddit=='1') {
	SHARED += ('<li class="reddit-share"><a href="http://www.reddit.com/submit?url='+ESURL+' target="_blank" title="Submit to Reddit"><i class="fa fa-reddit"></i></a></li>'); } if(urlajax.linkedin=='1') {
	SHARED += ('<li class="linkedin-share"><a href="http://www.linkedin.com/shareArticle?mini=true&url='+ESURL+' target="_blank" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a></li>'); } if(urlajax.email=='1') {
	SHARED += ('<li class="email-share"><a href="mailto:?body='+ESURL+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'); }
	SHARED += ('</ul>');
	jQuery(this).find(".event-share-link").attr('data-content',SHARED)
});
		 jQuery('[data-toggle="popover"]').popover('destroy');
		 jQuery('[data-toggle="popover"]').popover({html:true});
            },
            error: function(errorThrown) {
            }
        });
    });
 jQuery("#ajax_events").on("click", "a.pastevents", function(event) {
        var status = jQuery(this).attr('id');
		var termEvent = jQuery(this).attr('rel');
        jQuery('.listing-cont').fadeOut('slow');
		jQuery('#load-next-events').show();
        jQuery.ajax({
            type: 'POST',
            url: urlajax.ajaxurl,
            data: {
                action: 'imic_event_status_view',
                status: status,
				term: termEvent,
            },
            success: function(data) {
				jQuery('#load-next-events').hide();
				var event_data = data.split("~!");
                jQuery('.listing-cont').fadeIn('slow');
				jQuery(".listing-header").html('');
				jQuery(".listing-header").append(event_data[0]);
                jQuery('.events-listing-content').html('');
				var lis = event_data[1];
				$monthly_events.isotope('destroy'); //destroying isotope
                jQuery("#monthly-events").append(lis);
				jQuery('.event-dynamic, .event-item').each(function(){
	var ESURL = jQuery(this).find(".event-title").attr("href");
	var SHARED = ('<ul class="social-icons-colored inverted">');
	if(urlajax.google=='1') {
	SHARED += ('<li class="googleplus"><a href="https://plus.google.com/share?url='+ESURL+'" target="_blank"><i class="fa fa-google-plus"></i></a></li>'); } if(urlajax.twitter=='1') {
	SHARED += ('<li class="twitter"><a href="https://twitter.com/home?status=Event%20happening%20at%20Adore%20Church%20'+ESURL+'" target="_blank"><i class="fa fa-twitter"></i></a></li>'); } if(urlajax.facebook=='1') {
	SHARED += ('<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u='+ESURL+'" target="_blank"><i class="fa fa-facebook"></i></a></li>'); } if(urlajax.tumblr=='1') {
	SHARED += ('<li class="tumblr-share"><a href="http://www.tumblr.com/share?v=3&u='+ESURL+' target="_blank" title="Post to Tumblr"><i class="fa fa-tumblr"></i></a></li>'); } if(urlajax.pinterest=='1') {
	SHARED += ('<li class="pinterest-share"><a href="http://pinterest.com/pin/create/button/?url='+ESURL+' target="_blank" title="Pin it"><i class="fa fa-pinterest"></i></a></li>'); } if(urlajax.reddit=='1') {
	SHARED += ('<li class="reddit-share"><a href="http://www.reddit.com/submit?url='+ESURL+' target="_blank" title="Submit to Reddit"><i class="fa fa-reddit"></i></a></li>'); } if(urlajax.linkedin=='1') {
	SHARED += ('<li class="linkedin-share"><a href="http://www.linkedin.com/shareArticle?mini=true&url='+ESURL+' target="_blank" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a></li>'); } if(urlajax.email=='1') {
	SHARED += ('<li class="email-share"><a href="mailto:?body='+ESURL+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'); }
	SHARED += ('</ul>');
	jQuery(this).find(".event-share-link").attr('data-content',SHARED)
});
			jQuery('[data-toggle="popover"]').popover('destroy');
		 jQuery('[data-toggle="popover"]').popover({html:true});
                //jQuery('.events-listing-content').append(event_data[1]);
                //jQuery('#ajax_events').fadeOut();
            },
            error: function(errorThrown) {
            }
        });
    });
 });