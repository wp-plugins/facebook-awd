<?php 
/*
*
* Interface AWD_facebook_plugin_interface AWD Facebook
* (C) 2012 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
interface AWD_facebook_plugin_interface{
	public function __construct($file,$AWD_facebook);
	public function init();
	public function get_version();
	public function deactivation();
	public function activation();
	public function old_parent();
	public function missing_parent();
	public function missing_facebook_connect();
	public function default_options($options);
	public function register_widgets();

	public function admin_init();
	public function admin_menu();
	public function admin_form();
	
	public function plugin_settings_menu();
	public function plugin_settings_form();
	
	public function front_enqueue_js();
	public function admin_enqueue_js();
	public function front_enqueue_css();
	public function admin_enqueue_css();
	
	
}
?>