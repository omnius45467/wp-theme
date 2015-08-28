jQuery(function($){
	"use strict";
var ADORE = window.ADORE || {};
ADORE.megaMenu = function() {
        jQuery('.megamenu-sub-title').closest('ul.sub-menu').wrapInner('<div class="row" />').wrapInner('<div class ="megamenu-container container" />').wrapInner('<li />');
        jQuery('.megamenu-container').closest('li.menu-item-has-children').addClass('megamenu');
        var $class = '';
		jQuery(".megamenu-container").each(function(index, elem) {
    var numImages = $(this).find('.row').children().length;
	switch (numImages)
        {
            case 1:
                $class = 12;
                break;
            case 2:
                $class = 6;
                break;
            case 3:
                $class = 4;
                break;
            case 4:
                $class = 3;
                break;
            default:
                $class = 2;
        }
		$(this).find('.row').find('.col-md-3').each(function() {
            jQuery(this).removeClass('col-md-3').addClass('col-md-' + $class);
        })
		//$('.megamenu-container .row .div:has(.col-md-3)').addClass('col-md-' + $class).removeClass('col-md-3');
		//jQuery(this).find('.row').children().addClass('col-md-' + $class).removeClass('col-md-3');
    // do whatever processing you wanted to with numImages here
});
}
/* ==================================================
	Contact Form Validations
================================================== */
	ADORE.ContactForm = function(){
		$('.contact-form').each(function(){
			var formInstance = $(this);
			formInstance.submit(function(){
		
			var action = $(this).attr('action');
		
			$("#message").slideUp(750,function() {
			$('#message').hide();
		
			$('#submit')
				.after('<img src="' + $('#image_path').val() + '/images/assets/ajax-loader.gif" class="loader" />')
				.attr('disabled','disabled');
		
			$.post(action, {
				fname: $('#fname').val(),
				lname: $('#lname').val(),
				email: $('#email').val(),
				phone: $('#phone').val(),
				comments: $('#comments').val(),
				recipients: $('#recipients').val()
			},
				function(data){
					document.getElementById('message').innerHTML = data;
					$('#message').slideDown('slow');
					$('.contact-form img.loader').fadeOut('slow',function(){$(this).remove()});
					$('#submit').removeAttr('disabled');
					if(data.match('success') != null) $('.contact-form').slideUp('slow');
		
				}
			);
			});
			return false;
		});
		});
	}
/* ==================================================
	Scroll to Top
================================================== */
	ADORE.scrollToTop = function(){
		var windowWidth = $(window).width(),
			didScroll = false;
	
		var $arrow = $('#back-to-top');
	
		$arrow.click(function(e) {
			$('body,html').animate({ scrollTop: "0" }, 750, 'easeOutExpo' );
			e.preventDefault();
		})
	
		$(window).scroll(function() {
			didScroll = true;
		});
	
		setInterval(function() {
			if( didScroll ) {
				didScroll = false;
	
				if( $(window).scrollTop() > 200 ) {
					$arrow.fadeIn();
				} else {
					$arrow.fadeOut();
				}
			}
		}, 250);
	}
/* ==================================================
   Accordion
================================================== */
	ADORE.accordion = function(){
		var accordion_trigger = $('.accordion-heading.accordionize');
		
		accordion_trigger.delegate('.accordion-toggle','click', function(event){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).addClass('inactive');
			}
			else{
				accordion_trigger.find('.active').addClass('inactive');          
				accordion_trigger.find('.active').removeClass('active');   
				$(this).removeClass('inactive');
				$(this).addClass('active');
			}
			event.preventDefault();
		});
	}
/* ==================================================
   Toggle
================================================== */
	ADORE.toggle = function(){
		var accordion_trigger_toggle = $('.accordion-heading.togglize');
		
		accordion_trigger_toggle.delegate('.accordion-toggle','click', function(event){
			if($(this).hasClass('active')){
				$(this).removeClass('active');
				$(this).addClass('inactive');
			}
			else{
				$(this).removeClass('inactive');
				$(this).addClass('active');
			}
			event.preventDefault();
		});
	}
/* ==================================================
   Tooltip
================================================== */
	ADORE.toolTip = function(){ 
		$('a[data-toggle=tooltip]').tooltip();
		$('a[data-toggle=popover]').popover({html:true}).click(function(e) { 
       e.preventDefault(); 
       $(this).focus(); 
   });
	}
/* ==================================================
   Twitter Widget
================================================== */
	ADORE.TwitterWidget = function() {
		$('.twitter-widget').each(function(){
			var twitterInstance = $(this); 
			var twitterTweets = twitterInstance.attr("data-tweets-count") ? twitterInstance.attr("data-tweets-count") : "1"
			twitterInstance.twittie({
            	dateFormat: '%b. %d, %Y',
            	template: '<li><i class="fa fa-twitter"></i> {{tweet}} <span class="date">{{date}}</span></li>',
            	count: twitterTweets,
            	hideReplies: true
        	});
		});
	}
/* ==================================================
   Hero Flex Slider
================================================== */
	ADORE.heroflex = function() {
		$('.heroflex').each(function(){
				var carouselInstance = $(this); 
				var carouselAutoplay = carouselInstance.attr("data-autoplay") == 'yes' ? true : false
				var carouselPagination = carouselInstance.attr("data-pagination") == 'yes' ? true : false
				var carouselArrows = carouselInstance.attr("data-arrows") == 'yes' ? true : false
				var carouselDirection = carouselInstance.attr("data-direction") ? carouselInstance.attr("data-direction") : "horizontal"
				var carouselStyle = carouselInstance.attr("data-style") ? carouselInstance.attr("data-style") : "fade"
				var carouselSpeed = carouselInstance.attr("data-speed") ? carouselInstance.attr("data-speed") : "5000"
				var carouselPause = carouselInstance.attr("data-pause") == 'yes' ? true : false
				
				carouselInstance.flexslider({
					animation: carouselStyle,
					easing: "swing",               
					direction: carouselDirection,       
					slideshow: carouselAutoplay,              
					slideshowSpeed: carouselSpeed,         
					animationSpeed: 600,         
					initDelay: 0,              
					randomize: false,            
					pauseOnHover: carouselPause,       
					controlNav: carouselPagination,           
					directionNav: carouselArrows,            
					prevText: "",          
					nextText: "",
					start: function () {
					  $('.flex-caption').show();
					},
					after: function () {
					  $('.flex-caption').show();
					}
				});
		});
	}
/* ==================================================
   Flex Slider
================================================== */
	ADORE.galleryflex = function() {
		$('.galleryflex').each(function(){
				var carouselInstance = $(this); 
				var carouselAutoplay = carouselInstance.attr("data-autoplay") == 'yes' ? true : false
				var carouselPagination = carouselInstance.attr("data-pagination") == 'yes' ? true : false
				var carouselArrows = carouselInstance.attr("data-arrows") == 'yes' ? true : false
				var carouselDirection = carouselInstance.attr("data-direction") ? carouselInstance.attr("data-direction") : "horizontal"
				var carouselStyle = carouselInstance.attr("data-style") ? carouselInstance.attr("data-style") : "fade"
				var carouselSpeed = carouselInstance.attr("data-speed") ? carouselInstance.attr("data-speed") : "5000"
				var carouselPause = carouselInstance.attr("data-pause") == 'yes' ? true : false
				
				carouselInstance.flexslider({
					animation: carouselStyle,
					easing: "swing",               
					direction: carouselDirection,  
					animationLoop: true,     
					slideshow: carouselAutoplay,              
					slideshowSpeed: carouselSpeed,         
					animationSpeed: 600,         
					initDelay: 0,              
					randomize: false,            
					pauseOnHover: carouselPause,       
					controlNav: carouselPagination,           
					directionNav: carouselArrows,            
					prevText: "",          
					nextText: ""
				});
		});
	}
/* ==================================================
   Nivo Slider
================================================== */
	ADORE.NivoSlider = function() {
		$('.nivoslider').each(function(){
				var nivoInstance = $(this); 
				var nivoAutoplay = nivoInstance.attr("data-autoplay") == 'no' ? true : false
				var nivoPagination = nivoInstance.attr("data-pagination") == 'yes' ? true : false
				var nivoArrows = nivoInstance.attr("data-arrows") == 'yes' ? true : false
				var nivoThumbs = nivoInstance.attr("data-thumbs") == 'yes' ? true : false
				var nivoEffect = nivoInstance.attr("data-effect") ? nivoInstance.attr("data-effect") : "random"
				var nivoSlices = nivoInstance.attr("data-slices") ? nivoInstance.attr("data-slices") : "15"
				var nivoanimSpeed = nivoInstance.attr("data-animSpeed") ? nivoInstance.attr("data-animSpeed") : "500"
				var nivopauseTime = nivoInstance.attr("data-pauseTime") ? nivoInstance.attr("data-pauseTime") : "3000"
				var nivoPause = nivoInstance.attr("data-pauseonhover") == 'yes' ? true : false
				
				nivoInstance.show().nivoSlider({
					effect: nivoEffect,
					slices: nivoSlices,
					animSpeed: nivoanimSpeed,
					pauseTime: nivopauseTime,
					directionNav: nivoArrows,
					controlNav: nivoPagination,
					controlNavThumbs: nivoThumbs,
					pauseOnHover: nivoPause,
					manualAdvance: nivoAutoplay
				});
		});
	}
/* ==================================================
   PrettyPhoto
================================================== */
	ADORE.PrettyPhoto = function() {
		$("a[data-rel^='prettyPhoto']").prettyPhoto({
			  opacity: 0.5,
			  social_tools: "",
			  deeplinking: false,
			  allow_resize:false
		});
	}
/* ==================================================
   Animated Counters
================================================== */
	ADORE.Counters = function() {
		$('.counters').each(function () {
			$(".timer .count").appear(function() {
			var counter = $(this).html();
			$(this).countTo({
				from: 0,
				to: counter,
				speed: 2000,
				refreshInterval: 60,
				});
			});
		});
	}
/* ==================================================
   SuperFish menu
================================================== */
	ADORE.SuperFish = function() {
		$('.sf-menu').superfish({
			  delay: 200,
			  animation: {opacity:'show', height:'show'},
			  speed: 'fast',
			  cssArrows: false,
			  disableHI: true
		});
		$(".main-navigation > ul > li > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-angle-right'></i>");
		$(".main-navigation > ul > li > ul > li > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-angle-right'></i>");
		$(".main-navigation > ul > li > ul > li > ul > li > ul > li:has(ul)").find("a:first").append(" <i class='fa fa-angle-right'></i>");
	}
/* ==================================================
   Header Functions
================================================== */
	ADORE.StickyHeader = function() {
		window.addEventListener('scroll', function(e){
        var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 200,
            header = document.querySelector("header");
        if (distanceY > shrinkOn) {
            classie.add(header,"sticky-header");
        } else {
            if (classie.has(header,"sticky-header")) {
                classie.remove(header,"sticky-header");
            }
        }
    });
	}
/* ==================================================
	Responsive Nav Menu
================================================== */
	ADORE.MobileMenu = function() {
		// Responsive Menu Events
		$('#menu-toggle').click(function(){
			$(this).toggleClass("opened");
			$(".main-navigation").slideToggle();
			return false;
		});
		$(window).resize(function(){
            if($("#menu-toggle").hasClass("opened")){
                $(".main-navigation").css("display","block");
            } else {
                $("#menu-toggle").css("display","none");
            }
        });
	}
/* ==================================================
   IsoTope Portfolio
================================================== */
		ADORE.IsoTope = function() {	
		$("ul.sort-source").each(function() {
			var source = $(this);
			var destination = $("ul.sort-destination[data-sort-id=" + $(this).attr("data-sort-id") + "]");
			if(destination.get(0)) {
				$(window).load(function() {
					destination.isotope({
						itemSelector: ".grid-item",
						layoutMode: 'sloppyMasonry'
					});
					source.find("a").click(function(e) {
						e.preventDefault();
						var $this = $(this),
							filter = $this.parent().attr("data-option-value");
						source.find("li.active").removeClass("active");
						$this.parent().addClass("active");
						destination.isotope({
							filter: filter
						});
						if(window.location.hash != "" || filter.replace(".","") != "*") {
							self.location = "#" + filter.replace(".","");
						}
						return false;
					});
					$(window).bind("hashchange", function(e) {
						var hashFilter = "." + location.hash.replace("#",""),
							hash = (hashFilter == "." || hashFilter == ".*" ? "*" : hashFilter);
						source.find("li.active").removeClass("active");
						source.find("li[data-option-value='" + hash + "']").addClass("active");
						destination.isotope({
							filter: hash
						});
					});
					var hashFilter = "." + (location.hash.replace("#","") || "*");
					var initFilterEl = source.find("li[data-option-value='" + hashFilter + "'] a");
					if(initFilterEl.get(0)) {
						source.find("li[data-option-value='" + hashFilter + "'] a").click();
					} else {
						source.find("li:first-child a").click();
					}
				});
			}
		});
		$(window).load(function() {
			var IsoTopeCont = $(".isotope-grid");
			IsoTopeCont.isotope({
				itemSelector: ".grid-item",
				layoutMode: 'sloppyMasonry'
			});
			var IsoTopeEvents = $(".isotope-events");
			IsoTopeEvents.isotope({
				itemSelector: ".event-list-item"
			});
			if ($(".grid-holder").length > 0){	
				var $container_blog = $('.grid-holder');
				$container_blog.isotope({
				itemSelector : '.grid-item'
				});
		
				$(window).resize(function() {
				var $container_blog = $('.grid-holder');
				$container_blog.isotope({
					itemSelector : '.grid-item'
				});
				});
			}
		});
	}
/* ==================================================
   Init Functions
================================================== */
$(document).ready(function(){
	ADORE.megaMenu();
	ADORE.ContactForm();
	ADORE.scrollToTop();
	ADORE.accordion();
	ADORE.toggle();
	ADORE.toolTip();
	ADORE.TwitterWidget();
	ADORE.galleryflex();
	ADORE.NivoSlider();
	ADORE.PrettyPhoto();
	ADORE.SuperFish();
	ADORE.Counters();
	ADORE.IsoTope();
	ADORE.MobileMenu();
	ADORE.heroflex();
	
	
});
// Pages Design Functions
// Staff Items Equal Height
jQuery(function() {
	// apply matchHeight to each item container's items
	$('.content').each(function() {
		$(this).find('.staff-item').find('.grid-item-inner').matchHeight({
			//property: 'min-height'
		});
	});
	$('.content').each(function() {
		$(this).find('.featured-block').matchHeight({
			//property: 'min-height'
		});
	});
});
// Staff Items List Equal Height
jQuery(function() {
	// apply matchHeight to each item container's items
	$('.content').each(function() {
		$(this).find('.members-list > li').matchHeight({
			//property: 'min-height'
		});
	});
});
$(document).ready(function(){
	var LCWH = $(".lead-content-wrapper").height();
	var LCWHD = LCWH;
	$(".lead-content").css("height",LCWHD);
	// Gallery Flex list height
	var liMaxHeight = -1;
	var length=$(".format-gallery .slides").length;
	if(length>0)
	{
	   $(".format-gallery .slides").each(function(index) {
		  var $ul = $(this);
		  $($ul).find("li").each(function(index) {
		  if ($(this).outerHeight() > liMaxHeight) {
			liMaxHeight = $(this).outerHeight();
		}
		  });
		   $($ul).css('height',liMaxHeight)
		   $($ul).find('a').css('height',liMaxHeight)
		  });
	}
});
$('.gallery-updates').hover(function(){
	$(this).find('.gallery-updates-overlay').fadeOut(500);
},function(){
	$(this).find('.gallery-updates-overlay').fadeIn(500);
});
// Any Button Scroll to section
$('.scrollto').click(function(){
	$.scrollTo( this.hash, 800, { easing:'easeOutQuint' });
	return false;
});
$(".search-module-trigger").click(function(e){
	e.stopPropagation();
	$(".search-module-opened").toggle();
 	$('.cart-module-opened').hide();
	e.preventDefault();
});
$(".search-module-opened").click(function(e){
	e.stopPropagation();
});
$("#cart-module-trigger").click(function(e){
	e.stopPropagation();
	$(".cart-module-opened").toggle();
 	$('.search-module-opened').hide();
	e.preventDefault();
});
$(".cart-module-opened").click(function(e){
	e.stopPropagation();
});
$(document).click(function(e){
 	$('.search-module-opened, .cart-module-opened').hide();
	//e.preventDefault();
});
// FITVIDS
$(".fw-video, .format-video .post-media, .megamenu-container").fitVids();
// Centering the dropdown menus
$(".main-navigation ul li").mouseover(function() {
	 var the_width = $(this).find("a").width();
	 var child_width = $(this).find("ul").width();
	 var width = parseInt((child_width - the_width)/2);
	 $(this).find("ul").css('left', -width);
});
var LCWH = $(".lead-content-wrapper").height();
var LCWHD = LCWH;
$(".lead-content").css("height",LCWHD);
// Image Hover icons for gallery items
var MBC = function(){
	$(".media-box .zoom").each(function(){
		mpwidth = $(this).parent().width();
		mpheight = $(this).parent().find("img").height();
	
		$(this).css("width", mpwidth);
		$(this).css("height", mpheight);
		$(this).css("line-height", mpheight+"px");
	});
}
$(window).load(function(){
	$(".format-image").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-image'></i></span></span>");
	});
	$(".format-standard").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-eye'></i></span></span>");
	});
	$(".format-video").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='icon-music-play'></i></span></span>");
	});
	$(".format-link").each(function(){
		$(this).find(".media-box").append("<span class='zoom'><span class='icon'><i class='fa fa-link'></i></span></span>");
	});
});
$(".cust-counter" ).wrapAll( "<section class=\"counters padding-tb45 accent-color text-align-center\"><div class=\"container\"><div class=\"row\">");
// Icon Append
/*$('.basic-link').append(' <i class="fa fa-angle-right"></i>');
$('.basic-link.backward').prepend(' <i class="fa fa-angle-left"></i> ');
$('ul.checks li').prepend('<i class="fa fa-check"></i> ');
$('ul.angles li, .nav-list-primary li a > a:first-child').prepend('<i class="fa fa-angle-right"></i> ');
$('ul.inline li').prepend('<i class="fa fa-check-circle-o"></i> ');
$('ul.chevrons li').prepend('<i class="fa fa-chevron-right"></i> ');
$('ul.carets li').prepend('<i class="fa fa-caret-right"></i> ');*/
$('a.external').prepend('<i class="fa fa-external-link"></i> ');
//Sermons Controls
$('.video-player, .audio-player').mediaelementplayer();
//When page loads...
$(".sermon-tabs").hide(); //Hide all content
$(".sermon-media-right .sermon-tabs:first").show(); //Show first tab content
//On Click Event
var self_video = $('#self_video').clone();
var self_audio = $('#self_audio').clone();
var youtube_video = $('#youtube_video').clone();
var vimeo_video = $('#vimeo_video').clone();
var soundcloud_audio = $('#soundcloud_audio').clone();
var ActiveTabId = $(".sermon-tabs:first").attr("id");
if(ActiveTabId=='self_audio') {
	new MediaElementPlayer('.self-audio-player');
}
else if(ActiveTabId=='self_video') {
	new MediaElementPlayer('.self-video-player');
}
$('div.sermon-tabs').not('#'+ActiveTabId).empty();
$(".sermon-links ul.action-buttons li.link").click(function() {
	$(".sermon-tabs:first").show();
	var $this_id = $(this).find('a').attr('rel');
	if($this_id=='self_video') {
		$('#'+$this_id).replaceWith(self_video.clone());
		var video_player = new MediaElementPlayer('.self-video-player');
		$('#self_audio').empty();
		$('#youtube_video').empty();
		$('#vimeo_video').empty();
		$('#soundcloud_audio').empty();
	}
	else if($this_id=='self_audio') {
		$('#'+$this_id).replaceWith(self_audio.clone());
		var audio_player = new MediaElementPlayer('.self-audio-player');
		$('#self_video').empty();
		$('#youtube_video').empty();
		$('#vimeo_video').empty();
		$('#soundcloud_audio').empty();
	}
	else if($this_id=='youtube_video') {
		$('#'+$this_id).replaceWith(youtube_video.clone());
		$('#self_video').empty();
		$('#self_audio').empty();
		$('#vimeo_video').empty();
		$('#soundcloud_audio').empty();
	}
	else if($this_id=='vimeo_video') {
		$('#'+$this_id).replaceWith(vimeo_video.clone());
		$('#self_video').empty();
		$('#self_audio').empty();
		$('#youtube_video').empty();
		$('#soundcloud_audio').empty();
	}
	else if($this_id=='soundcloud_audio') {
		$('#'+$this_id).replaceWith(soundcloud_audio.clone());
		$('#self_video').empty();
		$('#self_audio').empty();
		$('#youtube_video').empty();
		$('#vimeo_video').empty();
	}
	$("ul.action-buttons li").removeClass("active"); //Remove any "active" class
	$(this).addClass("active"); //Add "active" class to selected tab
	$(".sermon-tabs").hide(); //Hide all tab content
	var activeTab = $(this).find("a").attr("rel"); //Find the href attribute value to identify the active tab + content
	$('#'+activeTab).show(); //Fade in the active ID content
	return false;
});
// Quick Events links functions
var OLL = $(".quick-info-overlay-left");
var OLR = $(".quick-info-overlay-right");
var ORBA = function(){
	OLR.animate({right:0});
}
var OLBA = function(){
	OLL.animate({opacity:.95,width:'30%'},'medium','swing', function() {
		OLL.find(".event-info").animate({opacity:1});
	});
}
var ORBAR = function(){
	OLR.animate({right:'-70%'});
}
var OLBAR = function(){
	OLL.find(".event-info").animate({opacity:0},'fast','swing', function() {
		OLL.animate({opacity:0,width:0});
	});
}
$(".cover-overlay-trigger").live('click',function(e){
	var MAPADD = $(this).parents(".event-dynamic").find(".event-location-address").text();
	var map;
    var geocoder;
    function InitializeMap() {
        var latlng = new google.maps.LatLng(-34.397, 150.644);
        var myOptions =
        {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true
        };
        map = new google.maps.Map(document.getElementById("event-directions"), myOptions);
    }
    
        geocoder = new google.maps.Geocoder();
        InitializeMap();
        var address = MAPADD;
        geocoder.geocode({ 'address': address }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            }
            else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    window.onload = InitializeMap;
	if($(this).hasClass("event-direction-link")){
		var OLGET = $(this).parents(".event-dynamic").find(".event-title").text();
		var OLURL = $(this).parents(".event-dynamic").find(".event-title").attr("href");
		OLL.find("h3.event-title").text(OLGET);
		OLL.find(".btn-permalink").show();
		OLL.find(".btn-permalink").attr("href",OLURL);
	}
	OLL.find(".btn-close").animate({bottom:'-5px'});
	$("body").css("overflow","hidden");
	$(".quick-info-overlay").addClass("active");
	var OLOC = $(this).parents(".event-dynamic").find(".event-location-address").text();
	OLL.find(".event-address").text(OLOC);
	OLL.find(".event-directions-link").attr('href','https://www.google.com/maps/dir//'+OLOC);
	OLBA();
	ORBA();
	e.preventDefault();
});
$(".quick-info-overlay-left, .btn-close").on('click', function(e) {
	$("body").css("overflow","auto");
	if($(this).parents(".quick-info-overlay").hasClass("active")){
		if( e.target !== this ) 
       	return;
		ORBAR();
		OLBAR();
		OLL.find(".btn-close").animate({bottom:'-40px'});
	}
	e.preventDefault();
});
$(".btn-close").on('click', function(e) {
	$("body").css("overflow","auto");
	if($(this).parents(".quick-info-overlay").hasClass("active")){
		ORBAR();
		OLBAR();
		OLL.find(".btn-close").animate({bottom:'-40px'});
	}
	e.preventDefault();
});
$('.event-dynamic, .event-item').each(function(){
	var ESURL = $(this).find(".event-title").attr("href");
	var SHARED = ('<ul class="social-icons-colored inverted">');
	if(urlajax_gaea.google=='1') {
	SHARED += ('<li class="googleplus"><a href="https://plus.google.com/share?url='+ESURL+'" target="_blank"><i class="fa fa-google-plus"></i></a></li>'); } if(urlajax_gaea.twitter=='1') {
	SHARED += ('<li class="twitter"><a href="https://twitter.com/home?status=Event%20happening%20at%20Adore%20Church%20'+ESURL+'" target="_blank"><i class="fa fa-twitter"></i></a></li>'); } if(urlajax_gaea.facebook=='1') {
	SHARED += ('<li class="facebook"><a href="https://www.facebook.com/sharer/sharer.php?u='+ESURL+'" target="_blank"><i class="fa fa-facebook"></i></a></li>'); } if(urlajax_gaea.tumblr=='1') {
	SHARED += ('<li class="tumblr-share"><a href="http://www.tumblr.com/share?v=3&u='+ESURL+' target="_blank" title="Post to Tumblr"><i class="fa fa-tumblr"></i></a></li>'); } if(urlajax_gaea.pinterest=='1') {
	SHARED += ('<li class="pinterest-share"><a href="http://pinterest.com/pin/create/button/?url='+ESURL+' target="_blank" title="Pin it"><i class="fa fa-pinterest"></i></a></li>'); } if(urlajax_gaea.reddit=='1') {
	SHARED += ('<li class="reddit-share"><a href="http://www.reddit.com/submit?url='+ESURL+' target="_blank" title="Submit to Reddit"><i class="fa fa-reddit"></i></a></li>'); } if(urlajax_gaea.linkedin=='1') {
	SHARED += ('<li class="linkedin-share"><a href="http://www.linkedin.com/shareArticle?mini=true&url='+ESURL+' target="_blank" title="Share on LinkedIn"><i class="fa fa-linkedin"></i></a></li>'); } if(urlajax_gaea.email=='1') {
	SHARED += ('<li class="email-share"><a href="mailto:?body='+ESURL+'" target="_blank" title="Email"><i class="fa fa-envelope"></i></a></li>'); }
	SHARED += ('</ul>');
	$(this).find(".event-share-link").attr('data-content',SHARED)
});
$('.event-share-link').live('click',function(e){
	//alert("saideva");
	$(this).parents(".event-list-item-actions").find(".toggle-sicons").animate({opacity:1});
	return false;
    },function(){
	$(this).parents(".event-list-item-actions").find(".toggle-sicons").animate({opacity:0});
	return false;
});
var ESCHH = $('.event-schedule').height();
$('.event-schedule .timeline').css("height",ESCHH);
var TBW = $('.ticket-booking-wrapper');
$(".event-register-button").live('click',function(e){
	var EVLOCAT = $(this).parents(".event-dynamic").find(".event-location-address").text();
	var EVTITLE = $(this).parents(".event-dynamic").find(".event-title").text();
	var EVDATE = $(this).parents(".event-dynamic").find(".event-date").text();
	var EVTIME = $(this).parents(".event-dynamic").find(".event-time").text();
	
	TBW.find('#dy-event-title').text(EVTITLE);
	TBW.find('#dy-event-location').text(EVLOCAT);
	TBW.find('#dy-event-time').text(EVTIME);
	TBW.find('#dy-event-date, #form-event-date').text(EVDATE);
});
// Animation Appear
$("[data-appear-animation]").each(function() {
	var $this = $(this);
	$this.addClass("appear-animation");
	if(!$("html").hasClass("no-csstransitions") && $(window).width() > 767) {
		$this.appear(function() {
			var delay = ($this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1);
			if(delay > 1) $this.css("animation-delay", delay + "ms");
			$this.addClass($this.attr("data-appear-animation"));
			setTimeout(function() {
				$this.addClass("appear-animation-visible");
			}, delay);
		}, {accX: 0, accY: -150});
	} else {
		$this.addClass("appear-animation-visible");
	}
});
// Animation Progress Bars
$("[data-appear-progress-animation]").each(function() {
	var $this = $(this);
	$this.appear(function() {
		var delay = ($this.attr("data-appear-animation-delay") ? $this.attr("data-appear-animation-delay") : 1);
		if(delay > 1) $this.css("animation-delay", delay + "ms");
		$this.addClass($this.attr("data-appear-animation"));
		setTimeout(function() {
			$this.animate({
				width: $this.attr("data-appear-progress-animation")
			}, 1500, "easeOutQuad", function() {
				$this.find(".progress-bar-tooltip").animate({
					opacity: 1
				}, 500, "easeOutQuad");
			});
		}, delay);
	}, {accX: 0, accY: -50});
});
// Parallax Jquery Callings
if(!Modernizr.touch) {
	$(window).bind('load', function () {
		parallaxInit();						  
	});
}
function parallaxInit() {
	$('.parallax1').parallax("50%", 0.1);
	$('.parallax2').parallax("50%", 0.1);
	$('.parallax3').parallax("50%", 0.1);
	$('.parallax4').parallax("50%", 0.1);
	$('.parallax5').parallax("50%", 0.1);
	$('.parallax6').parallax("50%", 0.1);
	$('.parallax7').parallax("50%", 0.1);
	$('.parallax8').parallax("50%", 0.1);
	/*add as necessary*/
}
// Window height/Width Getter Classes
var wheighter = $(window).height();
var wwidth = $(window).width();
$(".wheighter").css("height",wheighter);
$(".wwidth").css("width",wwidth);
$(window).resize(function(){
	var wheighter = $(window).height();
	var wwidth = $(window).width();
	$(".wheighter").css("height",wheighter);
	$(".wwidth").css("width",wwidth);
});
});