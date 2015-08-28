jQuery(document).ready(function() {
// COUNTDOWN TIMER
// FrontPage Time Counter
var finished;
function callback(event) {
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
jQuery(".counter").each(function(index, elem) {
	var expiryDate = jQuery('#'+this.id).data('date');
	var target = new Date(expiryDate),
	finished = false;
    jQuery("#"+this.id).countdown(target.valueOf(), callback);
});
});