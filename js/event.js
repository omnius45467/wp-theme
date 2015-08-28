jQuery(document).ready(function(){
	ticket_id = jQuery(".ticket-id").clone();
	booking_btns = jQuery("#booking-btn").clone();
	info_btns = jQuery("#multi-info-btn").clone();
	ticket_msg = jQuery("#ticket-msg").clone();
	var event_id;
	jQuery(".event-contact-link").live('click',function(){
		jQuery('form#contact-manager-form .message').empty();
		event_id = this.id;
	});
	jQuery(".event-register-button").live('click',function(e){
		jQuery('form#user-event-info .message').empty();
		jQuery(".ticket-id").replaceWith(ticket_id.clone());
		jQuery("#booking-btn").replaceWith(booking_btns.clone());
		jQuery("#multi-info-btn").replaceWith(info_btns.clone());
		jQuery("#ticket-msg").replaceWith(ticket_msg.clone());
		event_id = this.id;
		jQuery(".user-details").show();
		jQuery(".book-ticket").hide();
		jQuery("#edit-details").hide();
		jQuery(".ticket-booking-wrapper").animate({bottom:0},'medium','swing', function() {
			jQuery(".ticket-booking-wrapper").find(".ticket-booking-close").animate({top:'-40px'});
		});
		e.preventDefault();
	});
function ValidateEmail(email) {
	var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	return expr.test(email);
}; 
jQuery('input#contact-manager').on('click',function(e) {
	$formid = jQuery(this).closest("form").attr('id');
	jQuery("label.error").hide();
	jQuery(".error").removeClass("error");
	jQuery('form#'+$formid+' .message').empty();
	var $userfield = jQuery("form#"+$formid+" #username1");
	var $emailfield = jQuery("form#"+$formid+" #email1");
	var $phone = jQuery("form#"+$formid+" #phone1").val();
	var $notes = jQuery("form#"+$formid+" #notes1").val();
	var $lastname = jQuery("form#"+$formid+" #lastname1").val();
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var isValid = true;
	if (jQuery.trim($userfield.val()) == '') {
		isValid = false;
		jQuery('form#'+$formid+' .message').append("<div class=\"alert alert-error\">"+ajax.name+"</div>");
		return false;
	} else if(!ValidateEmail($emailfield.val())) {
		isValid = false;
		jQuery('form#'+$formid+' .message').append("<div class=\"alert alert-error\">"+ajax.emails+"</div>");
		return false;
	} else {
		jQuery('form#'+$formid+' .message').empty();
		jQuery('form#'+$formid+' .message').append("<div class=\"alert alert-success\">"+ajax.forwards+"</div>");
		jQuery.ajax({
			type: 'POST',
			url: ajax.url,
			async: false,
			data: {
				action: 'imic_contact_event_manager',
				itemnumber: event_id,
				name: $userfield.val(),
				lastname: $lastname,
				email: $emailfield.val(),
				phone: $phone,
				notes: $notes,
			},
			success: function(data) {
				jQuery('form#'+$formid+' .message').empty();
				jQuery('form#'+$formid+' .message').append(data);
				
			},
			complete: function() {
			}
	
	 	});
   	}
	if (isValid == false) {	e.preventDefault(); }
});
jQuery('input#user-info').on('click',function(e) {
	$formid = jQuery(this).closest("form").attr('id');
	jQuery("label.error").hide();
	jQuery(".error").removeClass("error");
	jQuery('form#'+$formid+' .message').empty();
	var $userfield = jQuery("form#"+$formid+" #username");
	var $emailfield = jQuery("form#"+$formid+" #email");
	var $event_date = jQuery("#dy-event-date").text();
	var $phone = jQuery("form#"+$formid+" #phone").val();
	var $notes = jQuery("form#"+$formid+" #notes").val();
	var $lastname = jQuery("form#"+$formid+" #lastname").val();
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var isValid = true;
	if (jQuery.trim($userfield.val()) == '') {
		isValid = false;
		jQuery('form#'+$formid+' .message').append("<div class=\"alert alert-error\">"+ajax.name+"</div>");
		return false;
	} else if(!ValidateEmail($emailfield.val())) {
		isValid = false;
		jQuery('form#'+$formid+' .message').append("<div class=\"alert alert-error\">"+ajax.emails+"</div>");
		return false;
	} else {
		jQuery(".user-details").hide();
		jQuery(".book-ticket").show();
		jQuery("#edit-details").show();
		jQuery(".ticket-booking-wrapper").find(".book-ticket").animate({opacity:1},'medium','swing', function() {
			jQuery(".event-ticket-left .ticket-cuts-top").animate({top:'-15px'},'fast','swing', function() {
				jQuery(".event-ticket-left .ticket-cuts-bottom").animate({bottom:'-15px'},'fast','swing', function() {
					
				});
			});
		});
   	}
	if (isValid == false) {	e.preventDefault(); }
	
		
});
jQuery("#booking-ticket").live('click',function(e){
	var $userfield = jQuery("form#user-event-info #username");
	var $emailfield = jQuery("form#user-event-info #email");
	var $event_date = jQuery("#dy-event-date").text();
	var $phone = jQuery("form#user-event-info #phone").val();
	var $notes = jQuery("form#user-event-info #notes").val();
	var $lastname = jQuery("form#user-event-info #lastname").val();
	var $members = jQuery('select[name="members"]').val();
	jQuery("#booking-btn").html("<span class=\"btn btn-info btn btn-block ticket-col\">"+ajax.process+"</span>");
		jQuery.ajax({
			type: 'POST',
			url: ajax.url,
			async: false,
			data: {
				action: 'imic_book_event_ticket',
				date: $event_date,
				itemnumber: event_id,
				name: $userfield.val(),
				lastname: $lastname,
				email: $emailfield.val(),
				phone: $phone,
				members: $members,
			},
			success: function(data) {
				jQuery(".ticket-id").html(data);
				jQuery("#booking-btn").html("<span class=\"btn btn-success btn btn-block ticket-col\">"+ajax.book+"</span>");
				jQuery("#multi-info-btn").html("<a class=\"btn btn-sm btn-default\" onClick=\"window.print()\">"+ajax.prints+"</a>");
				jQuery("#ticket-msg").html("<strong>"+ajax.sending+"</strong>");
				jQuery('head').append('<style type="text/css" media="print">div.body, .ticket-booking-close, #multi-info-btn{display:none;}.ticket-booking h3 strong{letter-spacing:0;}.ticket-booking h3{font-size:18px;}@page{size-auto;margin:5mm 5mm 5mm 5mm}body{margin:0;}.ticket-booking-wrapper{top:0;}</style>');
			},
			complete: function() {
			}
	
	 	});
		e.preventDefault(); 
		});
jQuery(".ticket-booking-close").on('click',function(e){
	jQuery(".event-ticket-left .ticket-cuts-bottom").animate({bottom:'-30px'},'fast','swing', function() {
		jQuery(".event-ticket-left .ticket-cuts-top").animate({top:'-30px'},'fast','swing', function() {
			jQuery(".ticket-booking-wrapper").find(".ticket-booking-close").animate({top:0},'fast','swing', function() {
				jQuery(".ticket-booking-wrapper").find(".book-ticket").animate({opacity:0},'fast','swing', function() {
					if(jQuery(window).width() > 767){jQuery(".ticket-booking-wrapper").animate({bottom:'-300px'});} else {
						jQuery(".ticket-booking-wrapper").animate({bottom:'-400px'});
					}
				});
			});
		});
	});
	e.preventDefault();
});
jQuery("#edit-details").live('click',function() {
	jQuery(".user-details").show();
	jQuery(".book-ticket").hide();
	jQuery("#edit-details").hide();
});
});