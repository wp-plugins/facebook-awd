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

//Get options from bdd
$AWD_options = $this->wpdb->get_results("SELECT option_name,option_value FROM ".$this->wpdb->options." WHERE option_name LIKE '%".$this->plugin_option_pref."%'",'OBJECT');
foreach($AWD_options as $options=>$object){
	$this->plugin_option[str_ireplace($this->plugin_option_pref,"",$object->option_name)] = $object->option_value;
}
//load text domain file
load_plugin_textdomain($this->plugin_text_domain,false,dirname( plugin_basename( __FILE__ ) ) . '/langs/');
//call filter for undefined vars
add_filter('AWD_facebook_options',array($this,'define_options'),10,1);
//check post and save
add_action("AWD_facebook_save_settings",array(&$this,'hook_post_from_plugin_options'));
//add notice in admin if error found
add_action('admin_notices',array(&$this,'missing_config'));
//load sdk js in footer
add_action('admin_print_footer_scripts',array(&$this,'load_sdj_js'));
add_action('wp_footer',array(&$this,'load_sdj_js'));
//init admin
add_action('admin_menu', array(&$this,'admin_menu'));
add_action('admin_init', array(&$this,'admin_initialisation'));
//filter for content
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


//CALL ACTION
//define current user in this object (SOON)
do_action("AWD_facebook_current_user");//it's called to soon we must identifier the first action is used that then we must call this action just before, and after he can be set....
//load some plugin of FACEBOOK AWD if exists
do_action("AWD_facebook_plugins_init");
//apply filter hook for all options
$this->plugin_option = apply_filters('AWD_facebook_options', $this->plugin_option);

//init the FB connect
if($this->plugin_option['connect_enable'] == 1 && $this->plugin_option['app_id'] !='' && $this->plugin_option['app_secret_key'] !=''){
	if(get_option('users_can_register') == 0){
		add_action('admin_notices',array(&$this,'message_register_disabled'));
	}
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
//should be call after the user was logged in.
$this->logout_listener();
?>