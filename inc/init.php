<?php
/*
*
* init AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
$this->wpdb = $wpdb;
//$this->plugin_url = plugins_url("",dirname(__FILE__));
$this->plugin_url = home_url().'/wp-content/plugins/facebook-awd';
$this->plugin_url_images = $this->plugin_url."/assets/css/images/";

//load text domain file
load_plugin_textdomain($this->plugin_text_domain,false,dirname( plugin_basename( __FILE__ ) ) . '/langs/');

add_filter("admin_footer_text", array($this,'admin_footer_text'),10,1);
//get the admin fbuid
add_action("AWD_facebook_get_admin_fbuid",array(&$this,'get_admin_fbuid'));
//add post thmubnial support for openGraph
add_action('after_setup_theme',array(&$this,'add_thumbnail_support'));
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
add_action('comment_form_after', array(&$this,'the_comments_form'));
//call the open tags in header
add_action('wp_head',array(&$this,'define_open_graph_tags_header'));

//add user profile field
add_action('edit_user_profile', array(&$this,'user_profile_edit'));
add_action('show_user_profile', array(&$this,'user_profile_edit'));
add_action( 'personal_options_update', array(&$this,'user_profile_save'));
add_action( 'edit_user_profile_update', array(&$this,'user_profile_save'));

add_action('wp_ajax_is_connect', array(&$this,'is_user_logged_in'));
add_action('wp_ajax_call_action_open_graph', array(&$this,'ajax_call_action_open_graph'));
add_action('wp_ajax_get_app_infos_content', array(&$this,'get_app_infos_content'));

//add shortcode 
add_shortcode('AWD_likebutton', array(&$this,'shortcode_like_button'));
add_shortcode('AWD_likebox', array(&$this,'shortcode_like_box'));
add_shortcode('AWD_activitybox', array(&$this,'shortcode_activity_box'));
add_shortcode('AWD_loginbutton', array(&$this,'shortcode_login_button'));
add_shortcode('AWD_comments', array(&$this,'shortcode_comments_box'));
add_shortcode('AWD_custom_action', array(&$this,'shortcode_custom_action'));

//add action to get current user object
add_action('AWD_facebook_oauth', array(&$this,'current_user'));
//when wp is loaded, where we do the login.
add_action('wp_loaded',array(&$this,'wp_init'));

//enqueue scripts in front
add_action('wp_enqueue_scripts',array(&$this,'front_enqueue_js'));

//Debug
if($this->debug_active)
	add_action('wp_footer',array(&$this,'debug_content'));


//Get options from bdd for first time here to use it in subplugins
$this->optionsManager = new AWD_facebook_options($this->plugin_option_pref,$this->wpdb);
//Merge options before version 0.9.9
$this->optionsManager->mergeOld();
//load from bdd.
$this->optionsManager->load();
$this->options = $this->optionsManager->getOptions();

/****************************************************
* load subplugins AWD
* save settings
* refresh options from bdd.
/****************************************************/
do_action("AWD_facebook_plugins_init");
//save from post options
do_action("AWD_facebook_save_settings");
//Get maj options from bdd
$this->optionsManager->load();
$this->options = $this->optionsManager->getOptions();
/****************************************************/


//init the sdk php
if(!empty($this->options['app_id'])  && !empty($this->options['app_secret_key'])){
	add_action('AWD_facebook_oauth', array(&$this,'sdk_init'));
}
//init the FB connect
if($this->options['connect_enable'] == 1 && $this->options['app_id'] !='' && $this->options['app_secret_key'] !=''){
    //use this hook to set the redirect url after JS login.
	add_action('AWD_facebook_redirect_login',array(&$this,'js_redirect_after_login'));
	//add action to add the login button on the wp-login.php page...
	if($this->options['login_button_display_on_login_page'] == 1)
		add_action('login_form',array(&$this,'the_login_button_wp_login'));
	if($this->options['connect_fbavatar'] == 1){
		add_filter('avatar_defaults', array($this, 'fb_addgravatar'),100, 1);
		add_filter('get_avatar', array($this, 'fb_get_avatar'), 100, 5);//modify in last... 
	}
	add_action('admin_print_footer_scripts',array(&$this,'connect_footer'));
	add_action('wp_footer',array(&$this,'connect_footer'));
}

?>