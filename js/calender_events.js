jQuery(document).ready(function() {
	var expiryDate = jQuery('.counter-preview').data('date');
				var target = new Date(expiryDate),
				finished = false,
				availiableExamples = {
					set15daysFromNow: 15 * 24 * 60 * 60 * 1000,
					set5minFromNow  : 5 * 60 * 1000,
					set1minFromNow  : 1 * 60 * 1000
				};
				function callbacks(event) {
					var $this = jQuery(this);
					switch(event.type) {
						case "seconds":
						case "minutes":
						case "hours":
						case "days":
						case "weeks":
						case "daysLeft":
							$this.find('div span#'+event.type).html(event.value);
							if(finished) {
								$this.fadeTo(0, 1);
								finished = false;
							}
							break;
						case "finished":
							$this.fadeTo('slow', .5);
							finished = true;
							break;
					}
				}
				jQuery('.counter-preview').countdown(target.valueOf(), callbacks);
    jQuery('.calendar').prepend('<img id="loading-image" src="' + calenderEvents.homeurl + '/images/loader.gif" alt="Loading..." />');
	var source = {
		googleCalendarId: 'usa__en@holiday.calendar.google.com'
	};
      jQuery('.calendar').fullCalendar({
        monthNames: calenderEvents.monthNames,
        monthNamesShort: calenderEvents.monthNamesShort,
        dayNames: calenderEvents.dayNames,
        dayNamesShort: calenderEvents.dayNamesShort,
        editable: true,
		eventLimit: 3,
			eventSources: [
				{
					url: calenderEvents.homeurl + '/includes/json-feed.php',
					type: 'POST',
					data: {
					   event_cat_id: jQuery('.event_calendar').attr('id'),
					  },
					
				},
				{
					googleCalendarApiKey: calenderEvents.googlekey,
					googleCalendarId:calenderEvents.googlecalid,
				}
				],
		eventClick: function(event, element) {
			if (event.url.indexOf('google') > -1) {
                               // opens events in a popup window
                               window.open(event.url, 'gcalevent', 'width=700,height=600');
                               return false; }
			else {
			var milliseconds = (new Date).getTime();
			var seconds = milliseconds/1000;
			var arr = event.id.split('|');
			jQuery('#events-preview-box').fadeOut('slow');
			jQuery('#load-preview-events').show();
			jQuery.ajax({
            type: 'POST',
			async: false, 
            url: calenderEvents.ajaxurl,
            data: {
                action: 'imic_get_event_details',
                id: event.id,
            },
            success: function(data) {
				jQuery('#load-preview-events').hide();
                jQuery('#events-preview-box').html('');
				jQuery('#events-preview-box').fadeIn('slow');
                jQuery('#events-preview-box').html(data);
				if(arr[1]<seconds) { jQuery(".preview-event-bar").hide(); }
				var expiryDate = jQuery('.counter-preview').data('date');
				var target = new Date(expiryDate),
				finished = false;
				jQuery('.counter-preview').countdown(target.valueOf(), callbacks);
				jQuery('.event-dynamic, .event-item').each(function(){
	var ESURL = jQuery(this).find(".event-title").attr("href");
	var SHARED = ('<ul class="social-icons-colored inverted">');
	if(calenderEvents.google=='1') {
	SHARED += ('<li class="googleplus"><a href="https://plus.google.com/share?url='+ESURL+'" target="_blank"><i class="fa fa-google-plus"></i></a></li>'); } if(calenderEvents.twitter=='1') {
	SHARED += ('<li class="twitter"><a href="https://twitter.com/home?status=Event%20happening%20at%20Adore%20Church%20'+ESURL+'" target="_blank"><i class="fa fa-twitter"></i></a></li>'); } if(calenderEvents.facebook=='1') {
	SHARED += ('<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u='+ESURL+'" target="_blank"><i class="fa fa-facebook"></i></a></li>'); } if(calenderEvents.tumblr=='1') {
	SHARED += ('<li class="tumblr-share"><a href="http://www.tumblr.com/share?v=3&u='+ESURL+' target="_blank" title="Post to Tumblr"><i class="fa fa-tumblr"></i></a></li>'); } if(calenderEvents.pinterest=='1') {
	SHARED += ('<li class="pinterest-share"><a href="http://pinterest.com/pin/create/button/?url='+ESURL+' target="_blank" title="Pin it"><i class="fa fa-pinterest"></i></a></li>'); } if(calenderEvents.reddit=='1') {
	SHARED += ('<li class="reddit-share"><a href="http://www.reddit.com/submit?url='+ESURL+' target="_blank" title="Submit to Reddit"><i class="fa fa-reddit"></i></a></li>'); } if(calenderEvents.linkedin=='1') {
	SHARED += ('<li class="linkedin-share"><a href="http://www.linkedin.com/shareArticle?mini=true&url='+ESURL+' target="_blank" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a></li>'); } if(calenderEvents.email=='1') {
	SHARED += ('<li class="email-share"><a href="mailto:?body='+ESURL+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'); }
	SHARED += ('</ul>');
	jQuery(this).find(".event-share-link").attr('data-content',SHARED)
});
			jQuery('[data-toggle="popover"]').popover('destroy');
		 jQuery('[data-toggle="popover"]').popover({html:true});
            },
			}); }
        },
		eventRender: function (event, element)
        {
			if(calenderEvents.preview==1) { 
            element.attr('href', 'javascript:void(0)'); }
        },
        timeFormat: calenderEvents.time_format,
        firstDay:calenderEvents.start_of_week,
        loading: function(bool) {
            if (bool)
                jQuery('#loading-image').show();
            else
                jQuery('#loading-image').hide();
        },
    });
jQuery("ul.sort-calendar li").click(function(){
	var term = jQuery(this).attr("id");
	reloadCal(term);
});
function reloadCal(event_term) {
	var source = {
		googleCalendarApiKey: calenderEvents.googlekey,
		googleCalendarId: calenderEvents.googlecalid
	};
	if((event_term!="google")&&(event_term!="")) {
	jQuery('.calendar').fullCalendar('removeEventSource',source.googleCalendarId); }
	else {
		jQuery('.calendar').fullCalendar('removeEventSource',source.googleCalendarId);
		jQuery('.calendar').fullCalendar('addEventSource', source);	
	}
	//newSource = jQuery.post(calenderEvents.homeurl + '/includes/json-feed.php',  {json: JSON.stringify("ss")});
    //jQuery('.calendar').fullCalendar('removeEventSource', source);
	//if(event_term!='') {
	jQuery('.calendar').fullCalendar('removeEventSource', calenderEvents.homeurl + '/includes/json-feed.php'); //}
	jQuery('.calendar').fullCalendar('refetchEvents');
    jQuery('.calendar').fullCalendar('addEventSource', { url: calenderEvents.homeurl + '/includes/json-feed.php',
					type: 'POST',
					data: {
					   event_cat_id: event_term,
					  }})
    jQuery('.calendar').fullCalendar('refetchEvents');
}
});