jQuery(document).ready(function() {
	jQuery("ul.font-icon-grid").hide();
	jQuery(document).click(function(){
		jQuery("ul.font-icon-grid").hide();
	});
	jQuery(".icon_field").live('click',function(e){
		e.stopPropagation();
		var selection = jQuery(this);
		var iconName = selection.find('ul');
		jQuery(iconName).show();
	});
	var text_name = jQuery(this).find('input[type=text]').attr('name');
    jQuery('ul.font-icon-grid li').live('click', function() {
    	var selection = jQuery(this);
		var iconName = selection.find('i').attr('class');
    	jQuery('ul.font-icon-grid li').removeClass('selected');
    	selection.addClass('selected');
    	selection.parent().parent().find('input').val(iconName);
		jQuery(selection).parent().hide();
		e.preventDefault();
    });
    
});