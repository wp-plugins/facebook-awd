<?php
/*
*
* abstract AWD_facebook_plugin_abstract AWD Facebook
* (C) 2012 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
require_once(dirname(__FILE__).'/class.AWD_facebook_plugin_interface.php');



abstract class AWD_facebook_plugin_abstract implements AWD_facebook_plugin_interface{

	//****************************************************************************************
	//	VARS
	//****************************************************************************************
	public $AWD_facebook;
	public $plugin_url;
	public $plugin_url_images;
	public $plugin_slug = 'awd_plugin_exemple';
	public $plugin_name = 'Configure me';
	public $plugin_text_domain = 'AWD_facebook_plugin_exemple';
	public $version_requiered = '1.0';
	public $deps = array('connect'=>0);
	public $file;

	//****************************************************************************************
	//	REQUIRED INIT
	//****************************************************************************************
	public function __construct($file,$AWD_facebook)
	{
		$this->file = $file;
		$this->AWD_facebook = $AWD_facebook;
		$AWD_facebook->plugins[$this->plugin_slug] = $this;
		require_once(ABSPATH.'wp-admin/includes/plugin.php');
		
		if(is_plugin_inactive('facebook-awd/AWD_facebook.php')){
			add_action('admin_notices',array(&$this,'missing_parent'));
			deactivate_plugins($this->file);
		}elseif($this->AWD_facebook->get_version() < $this->version_requiered){
			add_action('admin_notices',array(&$this,'old_parent'));
			deactivate_plugins($this->file);
			echo $this->deps['connect'];
		}else
			add_action('AWD_facebook_plugins_init',array(&$this,'initialisation'));
		
		add_action('AWD_facebook_register_widgets', array(&$this, 'register_widgets'));
	}
	
	
	public function init()
	{	
	
		if($this->AWD_facebook->options['connect_enable'] != 1 && $this->deps['connect'] == 1){
			add_action('admin_notices',array(&$this,'missing_facebook_connect'));
			deactivate_plugins($this->file);
		}
		
		$this->plugin_url = plugins_url(basename(dirname(dirname(dirname($this->file)))));
		$this->plugin_url_images = $this->plugin_url."/assets/css/images/";
		load_plugin_textdomain($this->plugin_text_domain,false,dirname(plugin_basename($this->file)).'/langs/');
		add_action('AWD_facebook_admin_menu', array(&$this,'admin_menu'));
		add_action('wp_enqueue_scripts',array(&$this,'front_enqueue_js'));
		add_action('wp_enqueue_scripts',array(&$this,'front_enqueue_css'));
	
		add_filter('AWD_facebook_options', array($this,'default_options'));
	}

	public function register_widgets()
	{
	}

	public function default_options($options){
		return $options;
	}

	
	public function get_version(){
	    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	    $plugin_folder = get_plugins();
	    return $plugin_folder[basename(dirname(dirname(dirname($this->file)))).'/'.str_replace('class.','',basename($this->file))]['Version'];
	}

	public function missing_facebook_connect()
	{
		echo '<div class="ui-state-error"><p>'.$this->plugin_name.' '.__("can not be activated: Facebook AWD All in One - Facebook Connect plugin must be activated",$this->plugin_text_domain).'</p></div>';
	}
	public function old_parent()
	{
		echo '<div class="ui-state-error"><p>'.$this->plugin_name.' '.__("can not be activated: Facebook AWD All in One plugin is out to date... You can download the last version or update it from the Wordpress plugin directory",$this->plugin_text_domain).'</p></div>';
	}
	public function missing_parent()
	{
		echo '<div class="ui-state-error"><p>'.$this->plugin_name.' '.__("can not be activated: Facebook AWD All in One plugin must be installed... you can download it from the Wordpress plugin directory",$this->plugin_text_domain).'</p></div>';
	}
	public function deactivation()
	{}
	public function activation()
	{}
	//****************************************************************************************
	//	LIB Facebook AWD
	//****************************************************************************************
	public function admin_init()
	{
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2));
		$screen = convert_to_screen(get_current_screen());
		$support = $this->AWD_facebook->support();
		$screen->add_help_tab( array(
			'id'      => 'AWD_facebook_contact_support',
			'title'   => __( 'WIKI & SUPPORT', $this->AWD_facebook->plugin_text_domain ),
			'content' => $support
		));
		$discover_content = $this->AWD_facebook->discover();
		$screen->add_help_tab( array(
			'id'      => 'AWD_facebook_contact_dev',
			'title'   => __( 'Get Top Freelance Web Developer & Pay Per Hour', $this->AWD_facebook->plugin_text_domain ),
			'content' => $discover_content
		));
	}
	public function admin_menu()
	{
		//Load the js lib AWD
		add_action('load-'.$this->plugin_admin_hook, array(&$this,'admin_init'));
		add_action('admin_print_styles-'.$this->plugin_admin_hook, array(&$this->AWD_facebook,'admin_enqueue_css'));
		add_action('admin_print_styles-'.$this->plugin_admin_hook, array(&$this,'admin_enqueue_css'));
		add_action('admin_print_scripts-'.$this->plugin_admin_hook, array(&$this->AWD_facebook,'admin_enqueue_js'));
		add_action('admin_print_scripts-'.$this->plugin_admin_hook, array(&$this,'admin_enqueue_js'));
		
		//Add action to create custom menu and custom form in plugin
		add_action('AWD_facebook_plugins_menu',array(&$this,'plugin_settings_menu'));
		add_action('AWD_facebook_plugins_form',array(&$this,'plugin_settings_form'));
	}
	public function admin_form()
	{}
	
	public function plugin_settings_menu()
	{}
	public function plugin_settings_form()
	{}
	
	public function front_enqueue_js()
	{	
	}
	public function admin_enqueue_js()
	{
	}
	public function front_enqueue_css()
	{	
	}
	public function admin_enqueue_css()
	{	
	}
	
}