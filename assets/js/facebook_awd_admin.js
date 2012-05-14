/*
*
* JS AWD FCBK
* (C) 2012 AH WEB DEV
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
jQuery(document).ready( function($){
	//accordion brefore tabs
	var icons = {
		header: "ui-icon-circle-arrow-e",
		headerSelected: "ui-icon-circle-arrow-s"
	};
	$("[id^='ogtags_']:not(div#ogtags_taxonomies > div.ui_ogtags_form)").accordion({
		header: "h4",
		autoHeight: false,
		icons:icons,
		collapsible: true,
		active: false
	});
	
	//create the tabs in options pages admin
	$("#div_options_content_tabs").tabs({ 
		fx: { opacity: 'toggle',duration:'fast'},
		cookie: { expires: 30 }
	});
	//hide all on load
	$("h3.tabs_in_tab").next().hide();
	
	//on click toogle next elem
	$("h3.tabs_in_tab a").click(function(e){
		jQuery(this).parent().next().slideToggle();
		e.preventDefault();
	});
	
	//for the shortcode in admin form		
	$(".awd_pre").addClass('ui-corner-all');
	//get the focus element
	var id_focused="";
	$(":input").focus(function () {
		id_focused = this.id;
	});

	//when click on the tag, set it in focus elem
	$(".awd_pre b").click(function(){	
		var b = jQuery(this);
		var value = jQuery("#"+id_focused).val();
		$("#"+id_focused).val(value + b.html());
	});
	
	//hide fadelement
	$(".fadeOnload").delay(4000).fadeOut();
	
	//Reload app content from openGraph api
	$('#reload_app_infos').live('click',function(e){
		e.preventDefault();
		$button = $(this);
		$button.html('<img src="/wp-content/plugins/facebook-awd/assets/css/images/loading.gif" alt="loading..."/>');
		$.post(ajaxurl,{action:'get_app_infos_content'},function(data){	
			if(data)
				jQuery('#awd_fcbk_app_infos_metabox.postbox .inside').html(data);
		});
	});
	
	//effect on promo
	$('.AWD_facebook_promo_plugin img').hover(function(){
		$(this).animate({opacity: 0.8}, 200);
	},function(){
		$(this).animate({opacity: 1}, 200);
	});
});