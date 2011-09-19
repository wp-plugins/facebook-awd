/*
*
* JS AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/

//Hide or show state
function hide_state(elem,elem_to_hide){
	if(jQuery(elem).attr('checked') != "checked"){
		jQuery(elem_to_hide).fadeOut();
	}else{
		jQuery(elem_to_hide).show();
	}
}
//Jquery Init
jQuery(document).ready( function(){
	//accordion brefore tabs
	var icons = {
		header: "ui-icon-circle-arrow-e",
		headerSelected: "ui-icon-circle-arrow-s"
	};
	jQuery("[id^='ogtags_']:not(div#ogtags_taxonomies > div.ui_ogtags_form)").accordion({
		header: "h4",
		autoHeight: false,
		icons:icons,
		collapsible: true,
		active: false
		//TODOnavigation: true
	});
	
	//create the tabs in options pages admin
	jQuery("#div_options_content_tabs").tabs({ 
		fx: { opacity: 'toggle',duration:'fast'},
		cookie: { expires: 30 }
	});
	//hide all on load
	jQuery("h3.tabs_in_tab").next().hide();
	
	//on click toogle next elem
	jQuery("h3.tabs_in_tab a").click(function(e){
		jQuery(this).parent().next().slideToggle();
		e.preventDefault();
	});
	
	//for the shortcode in admin form		
	jQuery(".awd_pre").addClass('ui-corner-all');
	//get the focus element
	var id_focused;
	jQuery(":input").focus(function () {
		id_focused = this.id;
	});

	//when click on the tag, set it in focus elem
	jQuery(".awd_pre b").click(function(){	
		var b = jQuery(this);
		var value = jQuery("#"+id_focused).val();
		jQuery("#"+id_focused).val(value + b.html());
	});
	
	//hide fadelement
	jQuery(".fadeOnload").delay(4000).fadeOut();
});