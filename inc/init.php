<?php
/*
*
* init AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
$this->plugin_option = array();
$this->wpdb = $wpdb;
$this->plugin_url = plugins_url("",dirname(__FILE__));
$this->plugin_url_images = $this->plugin_url."/css/images/";

//load text domain file
load_plugin_textdomain($this->plugin_text_domain,false,dirname( plugin_basename( __FILE__ ) ) . '/langs/');
//check post and save
add_action("AWD_facebook_save_settings",array(&$this,'hook_post_from_plugin_options'));
add_action('admin_notices',array(&$this,'missing_config'));
//load sdk js in footer
add_action('admin_print_footer_scripts',array(&$this,'load_sdj_js'));
add_action('wp_footer',array(&$this,'load_sdj_js'));
//init admin
add_action('admin_menu', array(&$this,'admin_menu'));
add_action('admin_init', array(&$this,'admin_initialisation'));
//filter for button post
add_filter('the_content', array(&$this,'the_content'));
add_action('comments_template', array(&$this,'the_comments_form'));
//call the open tags in header
add_action('wp_head',array(&$this,'define_open_graph_tags_header'));
//add shortcode 
add_shortcode('AWD_likebutton', array(&$this,'shortcode_like_button'));
add_shortcode('AWD_likebox', array(&$this,'shortcode_like_box'));
add_shortcode('AWD_activitybox', array(&$this,'shortcode_activity_box'));
add_shortcode('AWD_loginbutton', array(&$this,'shortcode_login_button'));
add_shortcode('AWD_comments', array(&$this,'shortcode_comments_box'));
//Debug
if($this->debug_active)
	add_action('wp_footer',array(&$this,'debug_content'));




//****************************************************************************************
//  Settings
//****************************************************************************************
$AWD_options = $this->wpdb->get_results("SELECT option_name,option_value FROM ".$this->wpdb->options." WHERE option_name LIKE '%".$this->plugin_option_pref."%'",'OBJECT');
foreach($AWD_options as $options=>$object){
	$this->plugin_option[str_ireplace($this->plugin_option_pref,"",$object->option_name)] = $object->option_value;
}
//end settings vars


//Define Default Vars if not set
if($this->plugin_option['connect_enable'] == '')
	$this->plugin_option['connect_enable'] = 0;
if($this->plugin_option['open_graph_enable'] == '')
	$this->plugin_option['open_graph_enable'] = 1;
if($this->plugin_option['connect_fbavatar'] == '')
	$this->plugin_option['connect_fbavatar'] == 0;
//****************************************************************************************
//  like button
//****************************************************************************************
if($this->plugin_option['like_button_on_pages'] == '')
	$this->plugin_option['like_button_on_pages'] = 0;
if($this->plugin_option['like_button_place_on_pages'] == '')
	$this->plugin_option['like_button_place_on_pages'] = 'top'; 
if($this->plugin_option['like_button_on_posts'] == '')
	$this->plugin_option['like_button_on_posts'] = 0;
if($this->plugin_option['like_button_place_on_posts'] == '')
	$this->plugin_option['like_button_place_on_posts'] = 'top';
if($this->plugin_option['like_button_place_on_custom_post_types'] == '')
	$this->plugin_option['like_button_place_on_custom_post_types'] = 'top';
if($this->plugin_option['like_button_on_custom_post_types'] == '')
	$this->plugin_option['like_button_on_custom_post_types'] = 0;
if($this->plugin_option['like_button_colorscheme'] == '')
	$this->plugin_option['like_button_colorscheme'] = 'light';
if($this->plugin_option['like_button_send'] == '' || $this->plugin_option['like_button_xfbml'] == 0)
	$this->plugin_option['like_button_send'] = 0;
if($this->plugin_option['like_button_height'] == '')
	$this->plugin_option['like_button_height'] = 40;
if($this->plugin_option['like_button_height'] == '')
	$this->plugin_option['like_button_height'] = 35;
if($this->plugin_option['like_button_faces'] == '')
	$this->plugin_option['like_button_faces'] = 0;
if($this->plugin_option['like_button_xfbml'] == '')
	$this->plugin_option['like_button_xfbml'] = 0;
if($this->plugin_option['like_button_action'] == '')
	$this->plugin_option['like_button_action'] = 'like';
if($this->plugin_option['like_button_layout'] == '')
	$this->plugin_option['like_button_layout'] = 'standard';
if($this->plugin_option['like_button_url'] == '')
	$this->plugin_option['like_button_url'] = get_bloginfo('url');

//****************************************************************************************
//  like box
//****************************************************************************************
if($this->plugin_option['like_box_url'] == '')
	$this->plugin_option['like_box_url'] = '';
if($this->plugin_option['like_box_colorscheme'] == '')
	$this->plugin_option['like_box_colorscheme'] = 'light';
if($this->plugin_option['like_box_width'] == '')
	$this->plugin_option['like_box_width'] = 292;
if($this->plugin_option['like_box_height'] == '')
	$this->plugin_option['like_box_height'] = 427;
if($this->plugin_option['like_box_faces'] == '')
	$this->plugin_option['like_box_faces'] = '1';
if($this->plugin_option['like_box_stream'] == '')
	$this->plugin_option['like_box_stream'] = '1';
if($this->plugin_option['like_box_xfbml'] == '')
	$this->plugin_option['like_box_xfbml'] = '0';
if($this->plugin_option['like_box_header'] == '')
	$this->plugin_option['like_box_header'] = '1';

//****************************************************************************************
//  activity
//****************************************************************************************

if($this->plugin_option['activity_colorscheme'] == '')
	$this->plugin_option['activity_colorscheme'] = 'light';
if($this->plugin_option['activity_width'] == '')
	$this->plugin_option['activity_width'] = 292;
if($this->plugin_option['activity_height'] == '')
	$this->plugin_option['activity_height'] = 427;
if($this->plugin_option['activity_recommendations'] == '')
	$this->plugin_option['activity_recommendations'] = '0';
if($this->plugin_option['activity_xfbml'] == '')
	$this->plugin_option['activity_xfbml'] = '0';
if($this->plugin_option['activity_header'] == '')
	$this->plugin_option['activity_header'] = '1';


//****************************************************************************************
//  Login button
//****************************************************************************************
if($this->plugin_option['login_button_display_on_login_page'] == '')
	$this->plugin_option['login_button_display_on_login_page'] = 0;
if($this->plugin_option['login_button_width'] == '')
	$this->plugin_option['login_button_width'] = 200;
if($this->plugin_option['login_button_maxrow'] == '')
	$this->plugin_option['login_button_maxrow'] = 1;
if($this->plugin_option['login_button_faces'] == '')
	$this->plugin_option['login_button_faces'] = 0;
if($this->plugin_option['login_button_logout_value'] == '')
	$this->plugin_option['login_button_logout_value'] = __('Logout',$this->plugin_text_domain);
if($this->plugin_option['login_button_image'] == '')
	$this->plugin_option['login_button_image'] = $this->plugin_url_images.'f-connect.png';
	
//****************************************************************************************
// comments
//****************************************************************************************
if($this->plugin_option['comments_url'] == '')
	$this->plugin_option['comments_url'] = get_bloginfo('url');
if($this->plugin_option['comments_colorscheme'] == '')
	$this->plugin_option['comments_colorscheme'] = 'light';
if($this->plugin_option['comments_width'] == '')
	$this->plugin_option['comments_width'] = 500;
if($this->plugin_option['comments_nb'] == '')
	$this->plugin_option['comments_nb'] = 10;


//****************************************************************************************
//  defaults values
//****************************************************************************************
//$this->Debug($this->plugin_option);
//set defaults values 
foreach($this->plugin_option as $option=>$value){
	$set_var='';
	if($value == '' && $value !='0'){
		switch($option){
			//title default
			case 'ogtags_frontpage_title':
			case 'ogtags_frontpage_site_name':
			case 'ogtags_categories_site_name':
			case 'ogtags_archives_site_name':
			case 'ogtags_page_site_name':
			case 'ogtags_post_site_name':
				$set_var = '%BLOG_TITLE%';
			break;
			case 'ogtags_page_disable':
			case 'ogtags_post_disable':
			case 'ogtags_archives_disable':
			case 'ogtags_frontpage_disable':
			case 'ogtags_taxonomies_category_disable':
			    $set_var = 1;
			break;

			//types default
			case 'ogtags_frontpage_type':
				$set_var = 'website';
			break;
			case 'ogtags_categories_type':
			case 'ogtags_archive_type':
			case 'ogtags_page_type':
			case 'ogtags_author_type':
				$set_var = 'blog';
			break;
			case 'ogtags_post_type':
				$set_var = 'article';
			break;
		
			//default site name
			case 'ogtags_frontpage_site_name':
			case 'ogtags_page_site_name':
			case 'ogtags_post_site_name':
			case 'ogtags_archive_site_name':
			case 'ogtags_author_site_name':
				$set_var = '%BLOG_TITLE%';
			break;
			
			case 'ogtags_taxonomies_category_title':
				$set_var = '%TERM_TITLE%';
			break;
			case 'ogtags_taxonomies_category_description':
				$set_var = '%TERM_DESCRIPTION%';
			break;
			
			case 'ogtags_page_title':
			case 'ogtags_post_title':
				$set_var = '%POST_TITLE%';
			break;
			case 'ogtags_archive_title':
				$set_var = '%ARCHIVE_TITLE%';
			break;
			
			case 'ogtags_author_title':
				$set_var = '%AUTHOR_TITLE%';
			break;
			case 'ogtags_author_image':
				$set_var = '%AUTHOR_IMAGE%';
			break;
			case 'ogtags_author_description':
				$set_var = '%AUTHOR_DESCRIPTION%';
			break;
			
			//description default
			case 'ogtags_frontpage_description':
			case 'ogtags_archive_description':
				$set_var = '%BLOG_DESCRIPTION%';
			break;
			
			case 'ogtags_post_description':
			case 'ogtags_page_description':
				$set_var = '%POST_EXCERPT%';
			break;
		}
		$this->plugin_option[$option] = $set_var;
	}
}

$fbadmin_uid = do_action("AWD_facebook_get_admin_fbuid");
	
if($this->plugin_option['admins'] == '')
    $this->plugin_option['admins'] = $fbadmin_uid;
//try here to set the comments notifications uid from 
if($this->plugin_option['comments_send_notification_uid']== '')
    $this->plugin_option['comments_send_notification_uid'] = $fbadmin_uid;
//****************************************************************************************

//****************************************************************************************
//  Langs
//****************************************************************************************
if(empty($this->plugin_option['locale']))
	if(defined('WPLANG'))
		if(WPLANG!=''){
			$this->plugin_option['locale'] = WPLANG;
		}
		

//****************************************************************************************
//  Desactive all xfbml
//****************************************************************************************
if($this->plugin_option['parse_xfbml'] == '' || $this->plugin_option['parse_xfbml'] == 0){
	$this->plugin_option['parse_xfbml'] = 0;
	$this->plugin_option['like_button_xfbml'] = 0;
	$this->plugin_option['like_button_send'] = 0;
	$this->plugin_option['like_box_xfbml'] = 0;
	$this->plugin_option['activity_xfbml'] = 0;
}
$array_perms = explode(",",$this->plugin_option['perms']);
if(!in_array('email',$array_perms))
	$this->plugin_option['perms'] = rtrim('email,'.$this->plugin_option['perms'],',');


//****************************************************************************************
// MUST GO IN INIT hook or before...

//****************************************************************************************


//define current user in this object
$this->current_user();
//do_action("AWD_facebook_current_user");
//call the api facebook init (php) if connect enable
if($this->plugin_option['connect_enable'] == 1 && $this->plugin_option['app_id'] !='' && $this->plugin_option['app_secret_key'] !=''){
	if(get_option('users_can_register') == 0){
		add_action('admin_notices',array(&$this,'message_register_disabled'));
	}
	//init OAuth SDK php
	//$this->sdk_init();
	add_filter('authenticate', array(&$this,'sdk_init'));
	//use this hook to set the redirect url after JS login.
	add_action("AWD_facebook_redirect_login",array(&$this,'js_redirect_after_login'));
	//add action to add the login button on the wp-login.php page...
	if($this->plugin_option['login_button_display_on_login_page'] == 1)
		add_action('login_form',array(&$this,'the_login_button_wp_login'));
	if($this->plugin_option['connect_fbavatar'] == 1)
		add_filter('get_avatar', array($this, 'fb_get_avatar'), 100, 5);//modify in last... 
	
	add_action('admin_print_footer_scripts',array(&$this,'connect_footer'));
	add_action('wp_footer',array(&$this,'connect_footer'));
}

//load some plugin if exists
do_action("AWD_facebook_plugins_init");
//filter hook for all options
$this->plugin_option = apply_filters('AWD_facebook_options', $this->plugin_option);
//Logout out listener, use that function to listen if we want to log out with the good way.
$this->logout_listener();
?>