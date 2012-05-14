<?php
/*
Plugin Name: Facebook AWD All in One
Plugin URI: http://www.ahwebdev.fr
Description: This plugin integrates Facebook open graph, Plugins from facebook, and FB connect, with SDK JS AND SDK PHP Facebook
Version: 1.2.1
Author: AHWEBDEV
Author URI: http://www.ahwebdev.fr
License: Copywrite AHWEBDEV
Text Domain: AWD_facebook
Last modification: 24/03/2012
*/


/**
 * @author Hermann Alexandre AHWEBDEV 2012
 *
 * http://www.ahwebdev.fr
 */

Class AWD_facebook
{
	//****************************************************************************************
	//	VARS
	//****************************************************************************************
    /***
     * public
     * Name of the plugin
     */
    public $plugin_name = 'Facebook AWD';
    
    /**
     * public
     * slug of the plugin
     */
    public $plugin_slug = 'awd_fcbk';
    
    /**
     * private
     * preffix blog option
     */
    public $plugin_option_pref = 'awd_fcbk_option_';
    
    /**
     * public
     * preffix blog option
     */
    public $plugin_page_admin_name = 'Facebook Admin';
    
    /**
     * public
     * preffix blog option
     */
    public $plugin_text_domain = 'AWD_facebook';
    
    /**
     * private
     * position of the menu in admin
     */
    public $blog_admin_hook_position;
    
    /**
     * private
     * hook admin
     */
    public $blog_admin_page_hook;
    
	/**
     * public
     * current_user
     */
    public $current_user = array();
    
    /**
     * public
     * Name of the file of the plugin
     */
    public $file_name = "AWD_facebook.php";
    
    /**

     * public

     * Options of the plugin

     */
    public $options = array();
    
    /**
    * global message admin
    */
    public $message;
    
    /**
    * me represent the facebook user datas
    */
    public $me = null;
    
	//****************************************************************************************
	//	GLOBALS FUNCTIONS
	//****************************************************************************************    
	/**
	 * Setter $this->current_user
	 * @return void
	 */
	public function get_current_user()
	{
	    global $current_user;
		get_currentuserinfo();
		$this->current_user = $current_user;
	}
	
    /**
     * Getter current user Ip
	 * @return $ip
	 */
	public function get_ip()
	{
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];  
		
		echo $ip;      
	}
	
	/**
	 * Getter Version
	 * @param array $plugin_folder_var
	 * @return array
	 */
	public function get_version($plugin_folder_var = array())
	{
	    if(count($plugin_folder_var)==0){
	    	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	        $plugin_folder = get_plugins();
	    }
	    return $plugin_folder['facebook-awd/AWD_facebook.php']['Version'];
	}

    /**
     * Remove a slash to pages with .html inside url
     * @param string $string
     * @param string $type (post, page, etc...)
     * @return string
     */
    public function add_page_slash($string, $type)
    {
        global $wp_rewrite;
        if(ereg(".html",$string) && $wp_rewrite->use_trailing_slashes){
        	return untrailingslashit($string);
        }
        return $string;
    }
  
    /**

     * Getter
     * the first image displayed in a post.

     * @param string $post_content
     * @return the image found.

     */                      
	public function catch_that_image($post_content="")
	{
		global $post;
		if($post_content=="" && is_object($post))
			$post_content = $post->post_content;
  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
  		$first_img = $matches [1] [0];
  		return $first_img;
	}
	
	
	/**
	 * Debug a var
	 * @param var $var
	 * @param boolean $detail default = false
	 * @return void
	 */
	public function Debug($var,$detail=0)
	{
		echo "<pre>";
		if($detail != 0){
			var_dump($var);
		}else{
			print_r($var);
		}
		echo "</pre>";
	}
	
	/**
	 * Get current URL
	 * @return string current url
	 */
	public function get_current_url()
	{
	    return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	
	public function get_plugins_model_path(){
		return realpath(dirname(__FILE__)).'/inc/classes/plugins/class.AWD_facebook_plugin_abstract.php';
	}
	
	//****************************************************************************************
	//	INIT
	//****************************************************************************************
	/**
	 * plugin construct
	 * @return void
	 */
	public function __construct()
	{		
		/* Class FCBK */
		if(!class_exists('Facebook'))
			require_once(dirname(__FILE__).'/inc/classes/facebook/facebook.php');
		
		//load the objects for open graph
		include_once(dirname(__FILE__).'/inc/opengraph_objects.php');
		//init the plugin and action
		add_action('plugins_loaded',array(&$this,'initial'));
		//like box widget register
		add_action('widgets_init',  array(&$this,'register_AWD_facebook_widgets'));
		
		$this->_login_url = get_option('permalink_structure') != '' ? home_url('facebook-awd/login') : home_url('?facebook_awd[action]=login');
		$this->_logout_url = get_option('permalink_structure') != '' ? home_url('facebook-awd/logout') : home_url('?facebook_awd[action]=logout');
		$this->_unsync_url = get_option('permalink_structure') != '' ? home_url('facebook-awd/unsync') : home_url('?facebook_awd[action]=unsync');

	}
	
	/**
	 * hook action added to init
	 * @return void
	 */
	public function wp_init()
	{		
		//add script and styles in the plugin and editos pages.
		wp_register_script($this->plugin_slug.'-js-cookie',$this->plugin_url.'/assets/js/jquery.cookie.js',array('jquery'));
		wp_register_script($this->plugin_slug.'-jquery-ui',$this->plugin_url.'/assets/js/jquery-ui-1.8.14.custom.min.js',array('jquery'));
		wp_register_script($this->plugin_slug.'-admin-js',$this->plugin_url.'/assets/js/facebook_awd.js',array('jquery'));
		wp_register_script($this->plugin_slug.'-js',$this->plugin_url.'/assets/js/facebook_awd_custom_actions.js',array('jquery'));
		wp_register_script($this->plugin_slug.'-ui-toolkit',$this->plugin_url.'/assets/js/ui-toolkit.js',array('jquery'));
		wp_register_style($this->plugin_slug.'-admin', $this->plugin_url.'/assets/css/admin_styles.css',array($this->plugin_slug.'-jquery-ui'));
		wp_register_style($this->plugin_slug.'-jquery-ui', $this->plugin_url.'/assets/css/jquery-ui-1.8.14.custom.css');
		wp_register_style($this->plugin_slug.'-ui-toolkit', $this->plugin_url.'/assets/css/ui-toolkit.css');
		
	}
	
	/**
	 * Getter
	 * the fbuid of the admin
	 * @return int UID Facebook
	 */
	public function get_admin_fbuid()
	{
        $admin_email = get_option('admin_email');
        $admin_user = get_user_by('email', $admin_email);
        $fbadmin_uid = get_user_meta($admin_user->ID,'fb_uid', true);
        return $fbadmin_uid;
	}
	
	/**
	 * plugin init
	 * @return void
	 */
	public function initial()
	{
		global $wpdb;
		include_once(dirname(__FILE__).'/inc/init.php');
	}
	
	/**
	 * add support for ogimage opengraph
	 * @return void
	 */
	public function add_theme_support()
	{
		//add fetured image menu to get FB image in open Graph set image 50x50
		if (function_exists('add_theme_support')) {
			add_theme_support('post-thumbnails');
			add_image_size('AWD_facebook_ogimage', 200, 200, true);
		}
		//add featured image + post excerpt in post type too.
		if(function_exists('add_post_type_support')) {
			$post_types = get_post_types();
			foreach($post_types as $type){
				add_post_type_support($type,array('thumbnails','excerpt'));
			}
		}
	}
	
	
	//****************************************************************************************
	//	MESSAGE ADMIN
	//****************************************************************************************
	/**
	 * missing config notices
	 * @return void
	 */
	public function missing_config()
	{
		//error for connect
		if($this->options['app_id'] =='' OR $this->options['app_secret_key'] =='' OR $this->options['admins'] ==''){
			?>
			<div class="ui-state-error">
				<p><?php printf( __('Facebook AWD is almost ready... Go to settings and set your FB app Id, youe FB Secret Key and your FB User ID (Notification from Facebook AWD)', $this->plugin_text_domain), admin_url( 'admin.php?page='.$this->plugin_slug)); ?></p>
			</div> 
			<?php	
		}
	}
	
	/**
	 * missing config notices
	 * @return void
	 */
	public function message_register_disabled()
	{
		echo'
		<div class="ui-state-error">
			<p>'.__('Users can not register, please enable registration account in blog settings before using FB Connect. (Notification from Facebook AWD)', $this->plugin_text_domain).'</p>
		</div>
		';
	}
	
	/**
	 * Getter
	 * Help in the plugin tooltip
	 * @param string $elem
	 * @param string $class
	 * @param string $image
	 * @return string a link to open lightbox with linked content
	 */
	public function get_the_help($elem,$class="help uiLightboxHTML",$image='info.png')
	{
		return '<a href="#" class="'.$class.'" id="help_'.$elem.'" data-backdrop="true"><img src="'.$this->plugin_url_images.$image.'" /></a>';
	}

	
	//****************************************************************************************
	//	ADMIN
	//****************************************************************************************
	
	/**
	 * Checks if we should add links to the bar.
	 * @return void
	 */
	public function admin_bar_init()
	{
		// Is the user sufficiently leveled, or has the bar been disabled?
		if (!is_super_admin() || !is_admin_bar_showing() )
			return;
	 
		// Good to go, lets do this!
		add_action('admin_bar_menu', array(&$this,'admin_bar_links'),500);
	}
	
	/**
	 * Add links to the Admin bar.
	 * @return void
	 */
	public function admin_bar_links()
	{
		global $wp_admin_bar;
		$links = array();
		
		if($this->me['link'] != ''){
			$links[] = array(__('My Profile',$this->plugin_text_domain), $this->me['link']);
		}
		$links[] = array(__('Settings',$this->plugin_text_domain),admin_url('admin.php?page='.$this->plugin_slug));
		$links[] = array(__('Wiki',$this->plugin_text_domain),'http://trac.ahwebdev.fr/projects/facebook-awd/Wiki');
		$links[] = array(__('Support',$this->plugin_text_domain),'http://trac.ahwebdev.fr/projects/facebook-awd');
		$links[] = array(__('Debugger',$this->plugin_text_domain),'https://developers.facebook.com/tools/debug/og/object?q='.urlencode($this->get_current_url()));

		if($this->is_user_logged_in_facebook()){
			$links[] = array(__('Refresh Facebook Data',$this->plugin_text_domain),  $this->_login_url);
			$links[] = array(__('Unsync FB Account',$this->plugin_text_domain), $this->_unsync_url);
		}

		$wp_admin_bar->add_menu( array(
			'title' => '<img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/> '.$this->plugin_name,
			'href' => false,
			'id' => $this->plugin_slug,
			'href' => false
		));
 
		foreach ($links as $link => $infos) {
			$wp_admin_bar->add_menu( array(
				'title' => $infos[0],
				'href' => $infos[1],
				'parent' => $this->plugin_slug,
				'meta' => array('target' => '_blank')
			));
		}
	}
	
	/**
	 * Save customs fields during post edition
	 * @param int $post_id
	 * @return void
	 */
	public function save_options_post_editor($post_id)
	{
		$fb_publish_to_pages = false;
		$fb_publish_to_user = false;
		if(!wp_is_post_revision( $post_id )){
			foreach($_POST as $__post=>$val){
				//should have ogtags in prefix present to be saved
				if(preg_match('@ogtags_@',$__post)){
					update_post_meta($post_id, $__post, $val);
				}
				if(preg_match('@'.$this->plugin_option_pref.'like_button@',$__post)){
					update_post_meta($post_id, $__post, $val);
				}				
			}
			//check if facebook user before to try to publish
			if($this->is_user_logged_in_facebook()){
				//Publish to Graph api
				$message = $_POST[$this->plugin_option_pref.'publish_message_text'];
				$read_more_text = $_POST[$this->plugin_option_pref.'publish_read_more_text'];
				//Check if we want to publish on facebook pages and profile
				if($_POST[$this->plugin_option_pref.'publish_to_pages'] == 1 && $this->current_facebook_user_can('publish_stream') && $this->current_facebook_user_can('manage_pages')){
					$fb_publish_to_pages = $this->get_pages_to_publish();
					if(count($fb_publish_to_pages)>0){
						$this->publish_post_to_facebook($message,$read_more_text,$fb_publish_to_pages,$post_id);
					}
				}
				//Check if we want to publish on facebook pages and profile
				if($_POST[$this->plugin_option_pref.'publish_to_profile'] == 1 && $this->current_facebook_user_can('publish_stream')){
					$this->publish_post_to_facebook($message,$read_more_text, $this->uid ,$post_id);
				}
			}		
		}
	}
	
	/**

	 * Add footer text ads Facebook AWD version

	 * @param string $footer_text
	 * @return string  the text to add in footer

	 */
	public function admin_footer_text($footer_text)
	{
	    return $footer_text."  ".__('| With:',$this->plugin_text_domain)." <a href='http://www.ahwebdev.fr/plugins/facebook-awd.html'>".$this->plugin_name." v".$this->get_version()."</a>";
	}
	
	/**
	 * Admin plugin init menu
	 * call form init.php
	 * @return void
	 */
	public function admin_menu()
	{
		add_action('save_post', array(&$this,'save_options_post_editor'));
		
		//admin hook
		$this->blog_admin_page_hook = add_menu_page($this->plugin_page_admin_name, __($this->plugin_name,$this->plugin_text_domain), 'administrator', $this->plugin_slug, array($this,'admin_content'), $this->plugin_url_images.'facebook-mini.png',$this->blog_admin_hook_position);
		$this->blog_admin_settings_hook = add_submenu_page($this->plugin_slug, __('Settings',$this->plugin_text_domain), '<img src="'.$this->plugin_url_images.'settings.png" /> '.__('Settings',$this->plugin_text_domain), 'administrator', $this->plugin_slug);
		$this->blog_admin_plugins_hook = add_submenu_page($this->plugin_slug, __('Plugins',$this->plugin_text_domain), '<img src="'.$this->plugin_url_images.'plugins.png" /> '.__('Plugins',$this->plugin_text_domain), 'administrator', $this->plugin_slug.'_plugins', array($this,'admin_content'));
		if($this->options['open_graph_enable'] == 1){
			$this->blog_admin_opengraph_hook = add_submenu_page($this->plugin_slug, __('Open Graph',$this->plugin_text_domain), '<img src="'.$this->plugin_url_images.'ogp-logo.png" /> '.__('Open Graph',$this->plugin_text_domain), 'administrator', $this->plugin_slug.'_open_graph', array($this,'admin_content'));
		}
		$this->blog_admin_support_hook = add_submenu_page($this->plugin_slug, __('Support',$this->plugin_text_domain), '<img src="'.$this->plugin_url_images.'info.png" /> '.__('Support',$this->plugin_text_domain), 'administrator', $this->plugin_slug.'_support', array($this,'admin_content'));

		add_action( "load-".$this->blog_admin_page_hook, array(&$this,'admin_initialisation'));
		add_action( "load-".$this->blog_admin_support_hook, array(&$this,'admin_initialisation'));
		add_action( "load-".$this->blog_admin_plugins_hook, array(&$this,'admin_initialisation'));
		add_action( "load-".$this->blog_admin_opengraph_hook, array(&$this,'admin_initialisation'));
		
		add_action( 'admin_print_styles-'.$this->blog_admin_page_hook, array(&$this,'admin_enqueue_css'));
		add_action( 'admin_print_styles-'.$this->blog_admin_support_hook, array(&$this,'admin_enqueue_css'));
		add_action( 'admin_print_styles-'.$this->blog_admin_plugins_hook, array(&$this,'admin_enqueue_css'));
		add_action( 'admin_print_styles-'.$this->blog_admin_opengraph_hook, array(&$this,'admin_enqueue_css'));
		add_action( 'admin_print_styles-post-new.php', array(&$this,'admin_enqueue_css'));
		add_action( 'admin_print_styles-post.php', array(&$this,'admin_enqueue_css'));
		
		add_action( 'admin_print_scripts-'.$this->blog_admin_page_hook, array(&$this,'admin_enqueue_js'));
		add_action( 'admin_print_scripts-'.$this->blog_admin_support_hook, array(&$this,'admin_enqueue_js'));
		add_action( 'admin_print_scripts-'.$this->blog_admin_plugins_hook, array(&$this,'admin_enqueue_js'));
		add_action( 'admin_print_scripts-'.$this->blog_admin_opengraph_hook, array(&$this,'admin_enqueue_js'));
		add_action( 'admin_print_scripts-post-new.php', array(&$this,'admin_enqueue_js'));
		add_action( 'admin_print_scripts-post.php', array(&$this,'admin_enqueue_js'));
		
		//enqueue here the library facebook connect
		$this->add_js_options();
		
		//Add meta box
		$this->add_meta_boxes();
	}
	
	/**
	* Admin initialisation
	* @return void
	*/
	public function admin_initialisation()
	{			
		add_screen_option('layout_columns', array('max' => 2, 'default' => 2));
		$screen = convert_to_screen(get_current_screen());
		$support = $this->support();
		$screen->add_help_tab( array(
			'id'      => 'AWD_facebook_contact_support',
			'title'   => __( 'WIKI & SUPPORT', $this->plugin_text_domain ),
			'content' => $support
		));
		$discover_content = $this->discover();
		$screen->add_help_tab( array(
			'id'      => 'AWD_facebook_contact_dev',
			'title'   => __( 'Get Top Freelance Web Developer & Pay Per Hour', $this->plugin_text_domain ),
			'content' => $discover_content
		));
	}
	
	/**
	 * Add meta boxes for admin
	 * @return void
	 */
	public function add_meta_boxes(){
		
		$icon = isset($icon) ? $icon : '';
	
		//sidebar boxes
		//Settings page
		add_meta_box($this->plugin_slug."_settings_metabox", __('Settings',$this->plugin_text_domain).' <img src="'.$this->plugin_url_images.'settings.png" />', array(&$this,'settings_content'), $this->blog_admin_page_hook , 'normal', 'core');
		add_meta_box($this->plugin_slug."_meta_metabox",  __('My Facebook',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'fcbk_content'),  $this->blog_admin_page_hook, 'side', 'core');
		add_meta_box($this->plugin_slug."_app_infos_metabox",  __('Application Infos', $this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$icon.'" alt=""/>', array(&$this,'app_infos_content'),  $this->blog_admin_page_hook, 'side', 'core');
		add_meta_box($this->plugin_slug."_info_metabox",  __('Informations',$this->plugin_text_domain), array(&$this,'general_content'),  $this->blog_admin_page_hook, 'side', 'core');
		add_meta_box($this->plugin_slug."_activity_metabox",  __('Activity on your site',$this->plugin_text_domain), array(&$this,'activity_content'),  $this->blog_admin_page_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_discover_metabox",  __('Facebook AWD Plugins',$this->plugin_text_domain), array(&$this,'discover_content'),  $this->blog_admin_page_hook , 'normal', 'core');

		//Plugins page
		add_meta_box($this->plugin_slug."_plugins_metabox", __('Plugins Settings',$this->plugin_text_domain).' <img src="'.$this->plugin_url_images.'plugins.png" />', array(&$this,'plugins_content'),  $this->blog_admin_plugins_hook , 'normal', 'core');
		add_meta_box($this->plugin_slug."_meta_metabox",  __('My Facebook',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'fcbk_content'),  $this->blog_admin_plugins_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_app_infos_metabox",  __('Application Infos', $this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$icon.'" alt=""/>', array(&$this,'app_infos_content'),  $this->blog_admin_plugins_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_info_metabox",  __('Informations',$this->plugin_text_domain), array(&$this,'general_content'),  $this->blog_admin_plugins_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_activity_metabox",  __('Activity on your site',$this->plugin_text_domain), array(&$this,'activity_content'),  $this->blog_admin_plugins_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_discover_metabox",  __('Facebook AWD Plugins',$this->plugin_text_domain), array(&$this,'discover_content'),  $this->blog_admin_plugins_hook , 'normal', 'core');
		
		
		//OpenGraph And post edito pages
		add_meta_box($this->plugin_slug."_open_graph_metabox", __('Open Graph',$this->plugin_text_domain).' <img src="'.$this->plugin_url_images.'ogp-logo.png" />', array(&$this,'open_graph_content'),  $this->blog_admin_opengraph_hook, 'normal', 'core');
		$post_types = get_post_types();
		foreach($post_types as $type){
			if($this->options['open_graph_enable'] == 1){
				add_meta_box($this->plugin_slug."_open_graph_post_metas_form", __('Open Graph Metas',$this->plugin_text_domain).' <img src="'.$this->plugin_url_images.'ogp-logo.png" />', array(&$this,'open_graph_post_metas_form'),  $type , 'normal', 'core',array("prefix"=>$this->plugin_option_pref.'ogtags_'));
			}
			//Like button manager on post page type
			add_meta_box($this->plugin_slug."_awd_mini_form_metabox", __('Facebook AWD Manager',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'post_manager_content'),  $type , 'side', 'core');
		}
		if($this->options['open_graph_enable'] == 1){			
			add_meta_box($this->plugin_slug."_meta_metabox",  __('My Facebook',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'fcbk_content'),  $this->blog_admin_opengraph_hook , 'side', 'core');
			add_meta_box($this->plugin_slug."_app_infos_metabox",  __('Application Infos', $this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$icon.'" alt=""/>', array(&$this,'app_infos_content'),  $this->blog_admin_opengraph_hook , 'side', 'core');
			add_meta_box($this->plugin_slug."_info_metabox",  __('Informations',$this->plugin_text_domain), array(&$this,'general_content'),  $this->blog_admin_opengraph_hook , 'side', 'core');
			add_meta_box($this->plugin_slug."_activity_metabox",  __('Activity on your site',$this->plugin_text_domain), array(&$this,'activity_content'),  $this->blog_admin_opengraph_hook , 'side', 'core');
			add_meta_box($this->plugin_slug."_discover_metabox",  __('Facebook AWD Plugins',$this->plugin_text_domain), array(&$this,'discover_content'),  $this->blog_admin_opengraph_hook , 'normal', 'core');
		}
		
		//Call the menu init to get page hook for each menu
		do_action('AWD_facebook_admin_menu');
		//For each page hook declared in plugins add side meta box
		$plugins = $this->plugins;
		if(is_array($plugins)){
			foreach($plugins as $plugin){
				$page_hook = $plugin->plugin_admin_hook;
				add_meta_box($this->plugin_slug."_meta_metabox",  __('My Facebook',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'fcbk_content'),  $page_hook , 'side', 'core');
				add_meta_box($this->plugin_slug."_app_infos_metabox",  __('Application Infos', $this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$icon.'" alt=""/>', array(&$this,'app_infos_content'),  $page_hook , 'side', 'core');
				add_meta_box($this->plugin_slug."_info_metabox",  __('Informations',$this->plugin_text_domain), array(&$this,'general_content'),  $page_hook , 'side', 'core');
				add_meta_box($this->plugin_slug."_activity_metabox",  __('Activity on your site',$this->plugin_text_domain), array(&$this,'activity_content'),  $page_hook , 'side', 'core');
				add_meta_box($this->plugin_slug."_discover_metabox",  __('Facebook AWD Plugins',$this->plugin_text_domain), array(&$this,'discover_content'),  $page_hook , 'normal', 'core');
			}
		}
		
		//Support page
		add_meta_box($this->plugin_slug."_support_metabox",  __('Support',$this->plugin_text_domain).' <img src="'.$this->plugin_url_images.'info.png" />', array(&$this,'support_content'),  $this->blog_admin_support_hook, 'normal', 'core');
		add_meta_box($this->plugin_slug."_meta_metabox",  __('My Facebook',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'fcbk_content'),  $this->blog_admin_support_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_app_infos_metabox",  __('Application Infos', $this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$icon.'" alt=""/>', array(&$this,'app_infos_content'),  $this->blog_admin_support_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_info_metabox",  __('Informations',$this->plugin_text_domain), array(&$this,'general_content'),  $this->blog_admin_support_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_activity_metabox",  __('Activity on your site',$this->plugin_text_domain), array(&$this,'activity_content'),  $this->blog_admin_support_hook , 'side', 'core');
		add_meta_box($this->plugin_slug."_discover_metabox",  __('Facebook AWD Plugins',$this->plugin_text_domain), array(&$this,'discover_content'),  $this->blog_admin_support_hook , 'normal', 'core');

	}
	
	/**
	 * Admin css enqueue Stylesheet
	 * @return void
	 */
	public function admin_enqueue_css()
	{
		wp_enqueue_style($this->plugin_slug.'-admin');
		wp_enqueue_style($this->plugin_slug.'-jquery-ui');
		wp_enqueue_style('thickbox');
	}
	
	/**
	 * Admin js enqueue Javascript
	 * @return void
	 */
	public function admin_enqueue_js()
	{
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('common');
		wp_enqueue_script('wp-list');
		wp_enqueue_script('postbox');
		wp_enqueue_script($this->plugin_slug.'-jquery-ui');
		wp_enqueue_script($this->plugin_slug.'-js-cookie');
		wp_enqueue_script($this->plugin_slug.'-admin-js');
		wp_enqueue_script($this->plugin_slug.'-ui-toolkit');
	}
	
	public function add_js_options()
	{
		wp_enqueue_script($this->plugin_slug.'-js');
		// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
		$AWD_facebook_vars = array(
			'ajaxurl' 	=> admin_url('admin-ajax.php'),
			'homeUrl' 	=> home_url(),
			'loginUrl' 	=> $this->_login_url,
			'logoutUrl' => $this->_logout_url,
			'scope' 	=> current_user_can("manage_options") ? $this->options["perms_admin"] : $this->options["perms"],
			'app_id'    => $this->options["app_id"],
			'FBEventHandler' => array('callbacks'=>array())
		);
		$AWD_facebook_vars = apply_filters('AWD_facebook_js_vars', $AWD_facebook_vars);
		wp_localize_script($this->plugin_slug.'-js', $this->plugin_slug, $AWD_facebook_vars);
	}

	/**
	 * Get the help Box
	 * @param string $type
	 * @return string the box in html format
	 */		                               
	public function get_the_help_box($type)
	{
		$html = '<p><u>'.__('You can use Pattern code in fields, paste it where you need:',$this->plugin_text_domain).'</u></p>';
		switch($type){
			case 'taxonomies':
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%TERM_TITLE%</b> - '.__('Use term name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%TERM_DESCRIPTION%</b> - '.__('Use term description',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
			break;
			case 'frontpage':
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
			break;
			case 'archive':
				$html .= '<div class="awd_pre">';
				 	$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%ARCHIVE_TITLE%</b> - '.__('Use archive name',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
			break;
			case 'author':
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%AUTHOR_TITLE%</b> - '.__('Use title of post',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%AUTHOR_IMAGE%</b> - '.__('Use excerpt',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%AUTHOR_DESCRIPTION%</b></p>';
				$html .= '</div>';
			break;
			case 'custom_post_types':
			case 'post':
			case 'page':
			default:
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%POST_TITLE%</b> - '.__('Use title of post',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%POST_EXCERPT%</b> - '.__('Use excerpt',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%POST_IMAGE%</b> - '.__('Use featured image (if activated)',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
		}
		return $html;
	}
	
	/**
	 * Return a formated error for display
	 * @param object $errors
	 * @return string
	 */
	public function return_error($errors){
		$html .='<div class="ui-state-error"><u><b>Facebook '.__('Message',$this->plugin_text_domain).'</b></u><br /><br />';
			if(is_array($errors) AND count($errors)){
				foreach($errors as $error){
					$html .= '<b>Type:</b> '.$error->getType().'<br />
					<b>Message:</b> '.$error->getMessage().'</p>';
				
				}
			}else if(is_object($errors)){
				$html .= '<b>Type:</b> '.$errors->getType().'<br />
				<b>Message:</b> '.$errors->getMessage().'</p>';
			}else if(is_string($errors)){
				$html .= '<b>Message:</b> '.$errors.'</p>';
			}
		$html .='</div>';
		return $html;
	}
	
	/**
	 * Admin Infos
	 * @return void
	 */
	public function general_content()
	{
	    ?>
	    <div style="text-align:center;">
			<div class="header_AWD_facebook_wrap">
				<h2 style="color:#04ADD1;margin:0px;">
					<img style="vertical-align:middle;" src="<?php echo $this->plugin_url_images; ?>facebook-mini.png" alt="facebook logo" style="vertical-align:middle;"/> Facebook AWD
					<sup style="color:#04ADD1;font-size:0.6em;">v<?php echo $this->get_version(); ?></sup>
				</h2>
			</div>
			<?php
			//List plugins
			echo '<h3 style="margin:0px;font-size:13px;text-align:left;">'.__('Plugins installed',$this->plugin_text_domain).'</h3>';
			if(is_array($this->plugins)){
				foreach($this->plugins as $plugin){
					echo'<p style="color:#04ADD1;margin:0px;font-size:12px; text-align:left;">
					- '.$plugin->plugin_name.'
					<sup style="color:#04ADD1;font-size:0.6em;">v'.$plugin->get_version().'</sup>
					</p>';
				}
			}else{
				echo'<p style="color:#04ADD1;margin:0px;font-size:12px; text-align:left;">
					'.__('- None',$this->plugin_text_domain).'
					</p>';
			}
			?>
			<h3 style="margin:5px 0px;font-size:13px;text-align:left;"><?php _e('Help Me',$this->plugin_text_domain); ?></h3>
			<a name='b_54c8ac3055ea012fbb7e000d60d4c902'></a><object type='application/x-shockwave-flash' data='https://giving.paypallabs.com/flash/badge.swf' width='205' height='350' id='badge54c8ac3055ea012fbb7e000d60d4c902' align='middle'>
			<param name='allowScriptAccess' value='always' />
			<param name='allowNetworking' value='all' />
			<param name='movie' value='https://giving.paypallabs.com/flash/badge.swf' />
			<param name='quality' value='high' />
			<param name='bgcolor' value='#FFFFFF' />
			<param name='wmode' value='transparent' />
			<param name='FlashVars' value='Id=54c8ac3055ea012fbb7e000d60d4c902'/>
			<embed src='https://giving.paypallabs.com/flash/badge.swf' FlashVars='Id=54c8ac3055ea012fbb7e000d60d4c902' quality='high' bgcolor='#FFFFFF' wmode='transparent' width='205' height='350' Id='badge54c8ac3055ea012fbb7e000d60d4c902' align='middle' allowScriptAccess='always' allowNetworking='all' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer'></embed>
			</object>
			
			<h3 style="margin:0px;font-size:13px;text-align:left;"><?php _e('Follow Me',$this->plugin_text_domain); ?></h3>
			<?php echo do_shortcode('[AWD_likebox url="https://www.facebook.com/pages/AHWEBDEV/207050892672485" colorscheme="light" stream="0" xfbml="0" header="0" width="257" height="333" faces="1"]'); ?>
	   	    <h2><a href="#tab-link-AWD_facebook_contact_support" onclick="jQuery('#contextual-help-link').trigger('click');"><?php _e('WIKI',$this->plugin_text_domain); ?></a></h2>
	    </div>
	    <?php
	}
	
	/**
	 * Get app infos content model
	 * @return void
	 */
	public function get_app_infos_content()
	{	
		echo $this->get_app_info();
		//call the app_content function
		echo $this->app_infos_content();
		exit();
	}
	
	/**
	 * Get App infos form api and store it in options
	 * @return string $errors
	 */
	public function get_app_info()
	{
		if(is_object($this->fcbk)){
			try{
				$app_info = $this->fcbk->api('/'.$this->options['app_id']);
				$this->optionsManager->update_option('app_infos', $app_info, true);
				$this->options = $this->optionsManager->getOptions();
			}catch(Exception $e){
				$this->optionsManager->update_option('app_infos', '', true);
				$this->options = $this->optionsManager->getOptions();
				$error = $this->return_error($e);
			}
		}
		return $error;
	}
	
	/**
	 * Application infos content
	 * @return void
	 */
	public function app_infos_content()
	{	
	
		$infos = $this->options['app_infos'];
		if(empty($infos)){
			?>
			<div class="ui-state-highlight"><?php _e('You must set a valid Application ID AND a Application secret Key in settings, then try to reload.',$this->plugin_text_domain); ?></div>
			<br />
			<a href="#" id="reload_app_infos" class="uiButton uiButtonNormal">Reload</a>
			<?php
		}else{
			?>
			<div id="awd_app">
				<table>
					<tr>
						<th><?php _e('Name' ,$this->plugin_text_domain); ?>:</th>
						<td><?php echo $infos['name']; ?></td>
					</tr>
					<tr>
						<th>ID:</th>
						<td><?php echo $infos['id']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Link' ,$this->plugin_text_domain); ?>:</th>
						<td><a href="<?php echo $infos['link']; ?>" target="_blank">View App</a></td>
					</tr>
					<tr>
						<th><?php _e('Namespace' ,$this->plugin_text_domain); ?>:</th>
						<td><?php echo $infos['namespace']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Daily active users' ,$this->plugin_text_domain); ?>:</th>
						<td class="app_active_users"><?php echo $infos['daily_active_users']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Weekly active users' ,$this->plugin_text_domain); ?>:</th>
						<td class="app_active_users"><?php echo $infos['weekly_active_users']; ?></td>
					</tr>
					<tr>
						<th><?php _e('Monthly active users' ,$this->plugin_text_domain); ?>:</th>
						<td class="app_active_users"><?php echo $infos['monthly_active_users']; ?></td>
					</tr>
					<tr>
						<th><img src="<?php echo $infos['logo_url']; ?>" class="awd_app_logo"/></th>
						<td><a href="#" id="reload_app_infos" class="uiButton uiButtonNormal"><?php _e('Test Settings',$this->plugin_text_domain); ?></a></td>
	
					</tr>
				</table>
			</div>
			<div class="center"></div>
			<?php
		}
	}
	
	/**
	 * Discover content Ads
	 * @return void
	 */
	public function discover_content()
	{
		echo $this->discover();
	}
	
	/**
	 * Discover content Ads
	 * @return void
	 */
	public function discover()
	{
		$html = '
		<div class="AWD_facebook_promo_plugin">
			<a href="http://wordpress.org/extend/plugins/facebook-awd-seo-comments/" target="_blank"><img src="'.$this->plugin_url_images.'facebook-awd-seo-comments-promo.jpg" alt="SEO Comments" border="0" /></a>
			<a href="http://wordpress.org/extend/plugins/facebook-awd-app-requests/" target="_blank"><img src="'.$this->plugin_url_images.'facebook-awd-app-request-promo.jpg" alt="APP Requests" border="0" /></a>
		</div>';
		return $html;
	}
	
	/**
	 * Admin content
	 * @return void
	 */
	public function admin_content()
	{
		include_once(dirname(__FILE__).'/inc/admin/admin.php');
	}
	
	/**
	 * Open graph admin content
	 * @return void
	 */
	public function open_graph_content()
	{
		include_once(dirname(__FILE__).'/inc/admin/admin_open_graph.php');
	}
	
	/**
	 * Support content
	 * @return void
	 */
	public function support_content()
	{
		echo $this->support();
	}
	
	/**
	 * reutrn the wiki support tracker
	 * @return string $html
	 */
	public function support()
	{
		$html='<h2>'.__("Bug Tracker",$this->plugin_text_domain).'</h2>
		<iframe src="http://trac.ahwebdev.fr/projects/facebook-awd/wiki" width="100%" height="600" scrolling="auto" frameborder="0"></iframe>';
		return $html;
	}

	/**
	 * Activity contents
	 * @return void
	 */
	public function activity_content()
	{
		$url = parse_url(home_url());
		echo do_shortcode('[AWD_activitybox domain='.$url['host'].'" width="258" height="200" header="false" font="lucida grande" border_color="#F9F9F9" recommendations="1" ref="Facebook AWD Plugin"]');
	}
	
	/**
	 * plugin Options
	 * @return void
	 */
	public function plugins_content()
	{
		include_once(dirname(__FILE__).'/inc/admin/admin_plugins.php');
		include_once(dirname(__FILE__).'/inc/help/help_plugins.php');
	}
	
	/**
	 * Settings Options
	 * @return void
	 */
	public function settings_content()
	{
		include_once(dirname(__FILE__).'/inc/admin/admin_settings.php');
		include_once(dirname(__FILE__).'/inc/help/help_settings.php');
	}
	
	/**
	 * Admin fcbk info content
	 * @return void
	 */
	public function fcbk_content()
	{
		$options = array();
		$options['login_button_width'] = 200;
		$options['login_button_profile_picture'] = 1;
		$options['login_button_faces'] = 'false';
		$options['login_button_maxrow'] = 1;
		$options['login_button_logout_value'] = __("Logout",$this->plugin_text_domain);
		echo $this->get_the_login_button($options)."<br />";
		if($this->uid)
			echo "<p>".sprintf(__("My Facebook ID: <strong>%s</strong>",$this->plugin_text_domain),$this->uid)."</p>";
	}
	
	//****************************************************************************************
	//	FRONT AND CONTENT
	//****************************************************************************************
	/**
	 * The Filter on the content to add like button
	 * @param string $content
	 * @return string $content
	 */
	public function the_content($content)
	{
		global $post;
		$exclude_post_type = explode(",",$this->options['like_button_exclude_post_type']);
		$exclude_post_page_id = explode(",",$this->options['like_button_exclude_post_id']);
		$exclude_terms_slug = explode(",",$this->options['like_button_exclude_terms_slug']);
		
		//get the all terms for the post
		$args = array();
		$taxonomies=get_taxonomies($args,'objects'); 
		$terms = array();
		if($taxonomies){
			foreach ($taxonomies  as $taxonomy) {
				$temp_terms = get_the_terms($post->ID, $taxonomy->name);
				if($temp_terms)
				foreach ($temp_terms  as $temp_term)
					if($temp_term){
						$terms[] = $temp_term->slug;
						$terms[] = $temp_term->term_id;
					}
			}
		}  
		//say if we need to exclude this post for terms
		$is_term_to_exclude = false;
		if($terms)
			foreach($terms as $term){
				if(in_array($term,$exclude_terms_slug))
					$is_term_to_exclude = true;
			}
		
		$custom = get_post_custom($post->ID);
	 	//enable by default lke button
	 	if($custom[$this->plugin_option_pref.'like_button_redefine'][0] == 1){
	 		$like_button = $this->get_the_like_button($post);
	 		if($custom[$this->plugin_option_pref.'like_button_enabled'][0] == 1){
	 			if($custom[$this->plugin_option_pref.'like_button_place'][0] == 'bottom')
					return $content.$like_button;
				elseif($custom[$this->plugin_option_pref.'like_button_place'][0] == 'both')
					return $like_button.$content.$like_button;
				elseif($custom[$this->plugin_option_pref.'like_button_place'][0] == 'top')
				    return $like_button.$content;
				    
				echo $custom[$this->plugin_option_pref.'like_button_place'][0];
			}else{
				return $content;
			}
		}elseif(!in_array($post->post_type,$exclude_post_type) && !in_array($post->ID,$exclude_post_page_id) && !$is_term_to_exclude && $custom[$this->plugin_option_pref.'like_button_enabled'][0] == 1 OR $custom[$this->plugin_option_pref.'like_button_enabled'][0] == ''){
			$like_button = $this->get_the_like_button($post);
			if($post->post_type == 'page' && $this->options['like_button_on_pages']){
				if($this->options['like_button_place_on_pages'] == 'bottom')
					return $content.$like_button;
				elseif($this->options['like_button_place_on_pages'] == 'both')
					return $like_button.$content.$like_button;
				elseif($this->options['like_button_place_on_pages'] == 'top')
				    return $like_button.$content;
	        }elseif($post->post_type == 'post' && $this->options['like_button_on_posts']){
			    if($this->options['like_button_place_on_posts'] == 'bottom')
					return $content.$like_button;
				elseif($this->options['like_button_place_on_posts'] == 'both')
					return $like_button.$content.$like_button;
				elseif($this->options['like_button_place_on_posts'] == 'top')
				    return $like_button.$content;
			}elseif($post->post_type != '' && $this->options['like_button_on_custom_post_types']){
				//for other custom post type
				if($this->options['like_button_place_on_custom_post_types'] == 'bottom')
					return $content.$like_button;
				elseif($this->options['like_button_place_on_custom_post_types'] == 'both')
					return $like_button.$content.$like_button;
				elseif($this->options['like_button_place_on_custom_post_types'] == 'top')
				    return $like_button.$content;
			}
		}
		return $content;
		
	}
	
	/**
	 * Add JS to front
	 * @return void
	 */
	public function front_enqueue_js()
	{
		wp_register_script($this->plugin_slug.'-js', $this->plugin_url.'/assets/js/facebook_awd_custom_actions.js',array('jquery'));
		$this->add_js_options();
	}
	
	//****************************************************************************************
	//	PUBLISH TO FACEBOOK
	//****************************************************************************************
	/**
	 * All pages the user authorize to publish on.
	 * @return array All Facebook pages linked by user
	 */
	public function get_pages_to_publish()
	{
		//construct the array
		$publish_to_pages = array();
		foreach($this->me['pages'] as $fb_page){
			//if pages are in the array of option to publish on,
			if($this->options['fb_publish_to_pages'][$fb_page['id']] == 1){
				$new_page = array();
				$new_page['id'] = $fb_page['id'];
				$new_page['access_token'] = $fb_page['access_token'];
				$publish_to_pages[] = $new_page;
			}
		}
		return $publish_to_pages;
	}
	
	/**
	 * Publish the WP_Post to facebook
	 * @param string $message
	 * @param string $read_more_text
	 * @param array $to_pages
	 * @param int $post_id
	 * @return string The result of the query
	 */
	public function publish_post_to_facebook($message=null,$read_more_text=null,$to_pages,$post_id)
	{	
		$fb_queries = array();
		$permalink = get_permalink($post_id);
		if(is_array($to_pages) && count($to_pages) > 0){
			foreach($to_pages as $fbpage){				
				$feed_dir = '/'.$fbpage['id'].'/feed/';
				$params = array(
					'access_token' => $fbpage['access_token'],
					'message' => stripcslashes($message),
					'link' => $permalink,
					'actions' => array(array(
						'name' => stripcslashes($read_more_text),
						'link' => $permalink
					))
				);
				try{
					//try to post batch request to publish on all pages asked + profile at one time
					$post_id = $this->fcbk->api($feed_dir, 'POST', $params);
				}catch (FacebookApiException $e) { 
				    error_log("Facebook AWD Publish to Facebook Error:  ".$e->getMessage());
					$this->options['admins_errors'][] = $this->return_error($e);
					$this->optionsManager->setOptions($this->options);
					$this->optionsManager->save();
				}
			}
		}else if(is_int(absint($to_pages))){
			$feed_dir = '/'.$to_pages.'/feed/';
			$params = array(
				'message' => $message,
				'link' => $permalink,
				'actions' => array(array(
					'name' => $read_more_text,
					'link' => $permalink
				))
			);
			try{
				//try to post batch request to publish on all pages asked + profile at one time
				$post_id = $this->fcbk->api($feed_dir, 'POST', $params);
			}catch (FacebookApiException $e) { 
				error_log("Facebook AWD Publish to Facebook Error:  ".$e->getMessage());
				$this->options['admins_errors'][] = $this->return_error($e);
				$this->optionsManager->setOptions($this->options);
				$this->optionsManager->save();
			}
		}
		return $result;
	}

	/**
	 * Update options when settings are updated.
	 * @return boolean
	 */
	public function update_options_from_post()
	{
	    if($_POST){
            foreach($_POST as $option=>$value){
            	$option_name = str_ireplace($this->plugin_option_pref,"",$option);
                $new_options[$option_name] = $value;
            }
            
            $this->optionsManager->setOptions($new_options);
            $this->optionsManager->save();
            return true;
        }else{
            return false;
        }
	}
	
	/**
	 * Event
	 * Called when the options are updated in plugins.
	 * @return void
	 */
	public function hook_post_from_plugin_options()
	{
		if(isset($_POST[$this->plugin_option_pref.'_nonce_options_update_field']) && wp_verify_nonce($_POST[$this->plugin_option_pref.'_nonce_options_update_field'],$this->plugin_slug.'_update_options')){
			//do custom action for sub plugins or other exec.
			do_action('AWD_facebook_save_custom_settings');
			//unset submit to not be stored
			unset($_POST[$this->plugin_option_pref.'submit']);
			unset($_POST[$this->plugin_option_pref.'_nonce_options_update_field']);
			unset($_POST['_wp_http_referer']);
			if($this->update_options_from_post()){
				$this->get_facebook_user_data();
				$this->get_app_info();
				$this->save_facebook_user_data($this->current_user->ID);
				$this->message = '<div class="ui-state-highlight fadeOnload"><p>'.__('Options updated',$this->plugin_text_domain).'</p></div>';
			}else
				$this->message = '<div class="ui-state-error"><p>'.__('Options not updated there is an error...',$this->plugin_text_domain).'</p></div>';
		
		}else if(isset($_POST[$this->plugin_option_pref.'_nonce_reset_options']) && wp_verify_nonce($_POST[$this->plugin_option_pref.'_nonce_reset_options'],$this->plugin_slug.'_reset_options')){
			$this->optionsManager->reset();
			$this->message = '<div id="message" class="ui-state-highlight fadeOnload"><p>'.__('Options were reseted',$this->plugin_text_domain).'</p></div>';
		}
	}
	
	//****************************************************************************************
	//	USER PROFILE
	//****************************************************************************************
	
	/**
	 * The action to add special field in user profile
	 * @param object $WP_User
	 * @return string $content
	 */
	public function user_profile_edit($user)
	{
		
		if(current_user_can('read')): ?>
		<h3><?php _e('Facebook infos',$this->plugin_text_domain); ?></h3>
		<table class="form-table">
		<tr>
			<th><label for="fb_email"><?php _e('Facebook Email',$this->plugin_text_domain); ?></label></th>
			<td>
				<input type="text" name="fb_email" id="fb_email" value="<?php echo esc_attr( get_user_meta($user->ID , 'fb_email', true) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter your Facebook Email',$this->plugin_text_domain); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="fb_uid"><?php _e('Facebook ID',$this->plugin_text_domain); ?></label></th>
			<td>
				<input type="text" name="fb_uid" id="fb_uid" value="<?php echo esc_attr( get_user_meta($user->ID , 'fb_uid', true) ); ?>" class="regular-text" /><br />
				<span class="description"><?php _e('Enter your Facebook ID',$this->plugin_text_domain); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="fb_reset"><?php _e('Unsync Facebook Account ?',$this->plugin_text_domain); ?></label></th>
			<td>
				<input type="checkbox" name="fb_reset" id="fb_reset" value="1" /><br />
				<span class="description"><?php _e('Note: This will clear all your facebook data linked with this account, you could login with WP account.',$this->plugin_text_domain); ?></span>
			</td>
		</tr>
		</table>
		<?php endif;
	}
	
	/**
	 * The action to save special field in user profile
	 * @param int $WP_User ID
	 */
	public function user_profile_save($user_id)
	{
		if (!current_user_can('read', $user_id))
			return false;
		if($_POST['fb_reset']){
			wp_redirect($this->_unsync_url);
			exit();
		}
		if($_POST['fb_email'] != ''){
			update_user_meta( $user_id, 'fb_email', $_POST['fb_email'] );
		}
		if($_POST['fb_uid'] != ''){
			update_user_meta( $user_id, 'fb_uid', $_POST['fb_uid'] );
		}
	}
	
	//****************************************************************************************
	//	Facebook CONNECT
	//****************************************************************************************
	/**
	 * Getter
	 * WP User infos form FB uid
	 * @param int $fb_uid
	 * @return array|boolean
	 */
	public function get_user_from_fbuid($fb_uid)
	{
		$existing_user = $this->wpdb->get_var( 'SELECT DISTINCT `u`.`ID` FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $fb_uid . '" )  LIMIT 1 ');
		if($existing_user){
			$user = get_userdata($existing_user);
			return $user;
		}else{
			return false;
		}
	}
	
	/**
	 * Load the javascript sdk Facebook
	 * @return void
	 */
	public function load_sdj_js()
	{
		?>
		<div id="fb-root"></div>
		<script type="text/javascript">
		(function() {
                var e = document.createElement('script');
                e.src = document.location.protocol + '//connect.facebook.net/<?php echo $this->options["locale"]; ?>/all.js#xfbml=1';
                <?php 
                //Add xfbml support if it was not called in the connect.
                if($this->options['connect_enable'] != 1): ?>
                e.src += '#xfbml=1';
                <?php endif; ?>
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
              }());
		</script>
		<?php
	}
	
	/**
	 * Add avatar Facebook As Default
	 * @param array $avatar_defaults
	 * @return string
	 */
	public function fb_addgravatar( $avatar_defaults ) {
		$avatar_defaults[$this->plugin_slug] = 'Facebook Profile Picture';
		return $avatar_defaults;
	}	
	
	/**
	 * Get avatar from facebook
	 * Replace it where we need it.
	 * @param string $avatar
	 * @param object $comments_objects
	 * @param int $size
	 * @param string $default
	 * @param string $alt
	 * @return string
	 */
	public function fb_get_avatar($avatar, $comments_objects, $size, $default, $alt)
	{
		$default_avatar = get_option('avatar_default');
		if($default_avatar == $this->plugin_slug){
			//$avatar format includes the tag <img>
			if(is_object($comments_objects)){
				$fbuid = get_user_meta($comments_objects->user_id,'fb_uid', true);
				//hack for avatar AWD comments_ plus
				if($fbuid==''){
					$fbuid = $comments_objects->user_id;//try if we directly get fbuid
				}
			}elseif(is_numeric($comments_objects)){
				$fbuid = get_user_meta($comments_objects,'fb_uid', true);
			}elseif($comments_objects !=''){
				if($default == 'awd_fcbk'){
					$user = get_user_by('email', $comments_objects);
					$fbuid = get_user_meta($user->ID,'fb_uid', true);
				}
			}
			if($fbuid !=''){
                if( $size <= 64 ){
			        $type = 'square';
			    }else if($size > 64){
			        $type = 'normal';
			    }else{
			        $type = 'large';
			    }
				$fb_avatar_url = 'http://graph.facebook.com/'.$fbuid.'/picture'.($type != '' ? '?type='.$type : '');
				$my_avatar = "<img src='".$fb_avatar_url."' class='avatar AWD_fbavatar' alt='".$alt."' height='".$size."' />";
				return $my_avatar;
			}
		}
		return $avatar;
	}
	
	
	/**
	 * Return true if the user has this perm.
	 */
	public function current_facebook_user_can($perm)
	{
		if($this->is_user_logged_in_facebook()){
			if(isset($this->me['permissions']) && is_array($this->me['permissions'])){
				if(isset($this->me['permissions'][$perm]) && $this->me['permissions'][$perm] == 1)
					return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Get all facebook Data only when. Then store them.
	 * @throws FacebookApiException
	 * @return string
	 */
	public function get_facebook_user_data()
	{
		if($this->is_user_logged_in_facebook()){
			//Try batch request on user
			$fb_queries = array(array('method' => 'GET', 'relative_url' => '/me'));
			$fb_queries[] = array('method' => 'GET', 'relative_url' => '/me/permissions');
			$fb_queries[] = array('method' => 'GET', 'relative_url' => '/me/accounts');
			$me = array();
			//Catch error for new batch request error.
			try{
				$batchResponse = $this->fcbk->api('?batch='.urlencode(json_encode($fb_queries)),'POST');
				$me = json_decode($batchResponse[0]['body'], true);
			}catch(FacebookApiException $e){
				$me['error'] = $e->getMessage();
			}
			//Try to find if the batch return error. IF yes, the user acces token is no more good.
			if(!isset($me['error'])){
				// Proceed knowing you have a logged in user who's authenticated.
				$me['AWD_access_token'] = $this->fcbk->getAccessToken();
				$fb_perms = json_decode($batchResponse[1]['body'], true);
				$me['permissions'] = $fb_perms['data'][0];
				$fb_pages = json_decode($batchResponse[2]['body'], true);
				if(isset($fb_pages['data'])){
					foreach($fb_pages['data'] as $fb_page){
						$me['pages'][$fb_page['id']] = $fb_page;
					}
				}
				$this->me = $me;
			}else{
				$result = array();
				$result['error_description'] = $me['error']['message'];
				$result['error_code'] = $me['error']['code'];
				//manually trow error, since errors are not catched in batch request.
				wp_die(new FacebookApiException($result));
			}
		}
	}
	
	/**
	 * Set all facebook Data
	 * @return void
	 */
	public function init_facebook_user_data($user_id){
		$this->me = get_user_meta($user_id, 'fb_user_infos', true);
	}
	public function save_facebook_user_data($user_id){
		update_user_meta($user_id, 'fb_email', $this->me['email']);
		update_user_meta($user_id,'fb_user_infos',$this->me);
		update_user_meta($user_id,'fb_uid',$this->uid);
	}
	
	public function clear_facebook_user_data($user_id){
		delete_user_meta($user_id, 'fb_email');
		delete_user_meta($user_id,'fb_user_infos');
		delete_user_meta($user_id,'fb_uid');
	}
	
	
	/**
	 * Get the WP_User ID from current Facebook User
	 * @return int
	 */
	public function get_existing_user_from_facebook(){
		require_once(ABSPATH . WPINC . '/registration.php');
	    $existing_user = email_exists($this->me['email']);
	    //if not email, verify in metas.
	    if(!$existing_user) {
	    	$existing_user = $this->wpdb->get_var(
				'SELECT DISTINCT `u`.`ID` FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`
				WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $this->uid . '" )
				OR (`m`.`meta_key` = "fb_email" AND `m`.`meta_value` = "' . $this->me['email'] . '" )  LIMIT 1 '
	        );
	        if(empty($existing_user))
	        	$existing_user = false;
	    }
	    return $existing_user;
	}
	
	/**
	 * Know if a user is logged in facebook.
	 * @return boolean
	 */
	public function is_user_logged_in_facebook()
	{
	    if($this->uid != 0)
	        return true;
	    
	    return false;
	}
	
	/**
	* INIT PHP SDK 3.1.1 version Modified to Change TimeOut
	* Connect the user here
	* @return void
	*/
	public function php_sdk_init()
	{
		$this->fcbk = new Facebook(array(
			'appId'  => $this->options['app_id'],
			'secret' => $this->options['app_secret_key'],
			'timeOut_AWD' => $this->options['timeout']
		));
		try{
			$this->uid = $this->fcbk->getUser();
		}catch(FacebookApiException $e){
			$this->uid = null;
		}
		//Set the current WP user data
		$this->get_current_user();
		$this->init_facebook_user_data($this->current_user->ID);
		$login_options = array(
			'scope' => current_user_can("manage_options") ? $this->options["perms_admin"] : $this->options["perms"],
			'redirect_uri' => $this->_login_url.(get_option('permalink_structure') != '' ? '?' : '&').'redirect_to='.$this->get_current_url()
		);
		$this->_oauth_url = $this->fcbk->getLoginUrl($login_options);
	}
	
	/**
	 * Add Js init fcbk to footer  ADMIN AND FRONT 
	 * Print debug if active here
	 * @return void
	 */
	public function js_sdk_init()
	{
		$html = '';
		if($this->options['connect_enable'] == 1){
			$html = "\n".'<script type="text/javascript">window.fbAsyncInit = function(){ FB.init({ appId : awd_fcbk.app_id, cookie : true, xfbml : true, oauth : true }); AWD_facebook.FBEventHandler(); };</script>'."\n"; 
		}
		echo $html;
	}
	
	/**
	 * Core connect the user to wordpress.
	 * @param WP_User $user_object
	 * @return void
	 */
	public function connect_the_user($user_id)
	{
		$is_secure_cookie = is_ssl();
		wp_set_current_user($user_id);
		wp_set_auth_cookie($user_id, true, $is_secure_cookie);
	}
	
	/**
	 * Change logout url for users connected with Facebook
	 * @param string $url
	 * @return string
	 */
	public function logout_url($url)
	{
		if($this->is_user_logged_in_facebook()){
			$parsing = parse_url($url);
			$redirect_url = str_ireplace('action=logout&amp;','', $this->_logout_url.'?'.$parsing['query']);
			return $this->fcbk->getLogoutUrl(array('next' =>$redirect_url));
		}
		return $url;
	}
	
	public function get_facebook_page_url()
	{			
		$facebook_page_url = null;
		if(is_object($this->fcbk)){
			$signedrequest = $this->fcbk->getSignedRequest();
			if( is_array($signedrequest) && array_key_exists("page", $signedrequest) ){
				$facebook_page_url = json_decode(file_get_contents("https://graph.facebook.com/" . $signedrequest['page']['id']))->{"link"} . "?sk=app_" . $this->fcbk->getAppId();
			}
		}
		return $facebook_page_url;
	}
	
	public function register_user()
	{
		$username = sanitize_user($this->me['first_name'], true);
		$i='';
		while(username_exists($username . $i)){
			$i = absint($i);
			$i++;
		}
		$username = $username.$i;
		$userdata = array(
			'user_pass'		=>	wp_generate_password(),
			'user_login'	=>	$username,
			'user_nicename'	=>	$username,
			'user_email'	=>	$this->me['email'],
			'display_name'	=>	$this->me['name'],
			'nickname'		=>	$username,
			'first_name'	=>	$this->me['first_name'],
			'last_name'		=>	$this->me['last_name'],
			'role'			=>	get_option('default_role')
		);
		$new_user = wp_insert_user($userdata);
		//Test the creation							
		if($new_user->errors){
			wp_die($this->Debug($new_user->errors));
		}
		if(is_int($new_user)){
			//send email new registration
			wp_new_user_notification($new_user, $userdata['user_pass']);
			//call action user_register for other plugins and wordpress core
			do_action('user_register', $new_user);
			return $new_user;
		}
		
		return false;
	}
	
	
	public function login_required()
	{
		if(!$this->is_user_logged_in_facebook() && !is_user_logged_in())
		{
			wp_redirect($this->_oauth_url);
			exit();
		}
	}
	
	public function login_listener($redirect_url)
	{
		if($this->is_user_logged_in_facebook() && !is_user_logged_in())
		{
			$this->login($redirect_url);
			exit();
		}
	}
	
	
	public function login($redirect_url)
	{
		$referer = wp_get_referer();
		if($this->is_user_logged_in_facebook()) {
			$this->get_facebook_user_data();
			//Found existing user in WP
			$user_id = $this->get_existing_user_from_facebook();
			//No user was found we create a new one	
			if($user_id === false){
				$user_id = $this->register_user();
			}
			$this->save_facebook_user_data($user_id);
			$this->init_facebook_user_data($user_id);
			$this->connect_the_user($user_id);
		}else{
			wp_redirect(home_url('?awd_fcbk_error=403'));
			exit();
		}
		//if we are in an iframe or a canvas page, redirect to
		if(!empty($this->facebook_page_url)){
			wp_redirect($this->facebook_page_url);
		}elseif($redirect_url){
			wp_redirect($redirect_url);
		}elseif($referer){
			wp_redirect($referer);
		}else{
			wp_redirect(home_url());
		}
		exit();
	}
	
	public function logout($redirect_url)
	{
		$referer = wp_get_referer();
		$this->fcbk->destroySession();
		wp_logout();
		do_action('wp_logout');
		//if we are in an iframe or a canvas page, redirect to
		if(!empty($this->facebook_page_url)){
			wp_redirect($this->facebook_page_url);
		}elseif($redirect_url){
			wp_redirect($redirect_url);
		}elseif($referer){
			wp_redirect($referer);
		}else{
			wp_redirect(home_url());
		}
		exit();
	}
	
	public function parse_request(){
		global $wp_query;
		$this->facebook_page_url = $this->get_facebook_page_url();
		$query = get_query_var('facebook_awd');
		
		//Parse the query for internal process
		if(isset($query)){
			$action = $query['action'];
			$redirect_url = $_REQUEST['redirect_to'];
			switch($action){
				//LOGIN
				case 'login':
					$this->login($redirect_url);
				break;
				
				//LOGOUT
				case 'logout':
					$this->logout($redirect_url);
				break;
				
				//UNSYNC
				case 'unsync':
					$this->clear_facebook_user_data($this->current_user->ID);
					$this->logout($redirect_url);
				break;
				
				//LISTENERS	
				default:
					//if we want to force the login for the entire website.
					if($this->options['login_required_enable'] == 1)
						$this->login_required($redirect_url);
					//listen for any session that is create by facebook and redirected here.
					//exemple for featured dialogs and force login (php redirect)
					$this->login_listener($redirect_url);
				break;
			}
		}
	}
	
	/**
	* Flush rules WP
	* @return void
	*/
	public function flush_rules(){
		$rules = get_option( 'rewrite_rules' );
		if ( ! isset( $rules['facebook-awd/(login|logout|unsync)$'] ) ) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}
	}
	
	/**
	* insert rules WP
	* @return void
	*/
	public function insert_rewrite_rules( $rules )
	{
		$newrules = array();
		$newrules['facebook-awd/(login|logout|unsync)$'] = 'index.php?facebook_awd[action]=$matches[1]';
		return $newrules + $rules;
	}
	
	/**
	* Isert query vars
	* @return $vars
	*/
	public function insert_query_vars($vars)
	{
		$vars[] = 'facebook_awd';
		return $vars;
	}
	
	//****************************************************************************************
	//	ACTIONS OPENGRAPH OBJECT (BETA)
	//****************************************************************************************
	/**
	 * Return the custom button action for OpenGraph
	 * do_shortcode('[AWD_custom_action html="div" class="AWD_test" action="test" object="plugin" event="click" url="http://test.com" response_text="testoun"]Here the text to use[/AWD_custom_action]');  
	 * @param array $atts   
	 * @param string $content
	 * @param string $code
	 * @return string
	 */
	public function shortcode_custom_action($atts=array(),$content,$code)
	{
		$new_atts = array();
		if(is_array($atts)){
			extract(shortcode_atts(array("init"=>"init", "html"=>"div"), $atts )); 
			foreach($atts as $att=>$value){
				$new_atts[$att] = $value;
			}
		}
		//create the container with data attached to.
		$html = '<'.$new_atts['html'].' class="'.$new_atts['class'].' AWD_facebook_custom_action" data-type-event="'.$new_atts['event'].'" data-action="'.$new_atts['action'].'" data-object="'.$new_atts['object'].'" data-url="'.$new_atts['url'].'" data-responsetext="'.$new_atts['response_text'].'" data-callbackjs="'.$new_atts['callback_js'].'">';
		$html .= $content;	
		$html .= '</'.$new_atts['html'].'>';
		
		return $html;
	}
	
	/**
	 * Alias for call_action_openGraph but for ajax hook
	 * @return void
	 */
	public function ajax_call_action_open_graph()
	{
		$request = array(
			'namespace'=> $this->options['app_infos']['namespace'],
			'action' => $_POST['awd_action'],
			'object' => $_POST['awd_object'],
			'url' => $_POST['awd_url'],
			'responseText' => $_POST['awd_responsetext'],
			'callbackJs' => $_POST['awd_callbackjs']
		);
		//Call filters to allow the user to parse and mofify the request before to send it.
		$request = apply_filters('AWD_custom_actions_request',$request);
		//Call the graph api
		$response = $this->call_action_open_graph($request['namespace'],$request['action'],$request['object'],$request['url']);
		$response['htmlResponse'] = $request['responseText'];
		$response['callbackJs'] = $request['callbackJs'];
		$response['debug'] = true;
		//Call filters to allow the user to customize htmlresponse
		$response = apply_filters('AWD_custom_actions_response', $response);
		echo json_encode($response);
		exit();
	}
	
	/**
	 * Call custom action to openGraph object
	 * @param string $namespace
	 * @param string $action
	 * @param string $object
	 * @param string $url
	 * @return array
	 */
	public function call_action_open_graph($namespace,$action,$object,$url)
	{
	 	$response = array();
		if($this->is_user_logged_in_facebook()){
			try{
				$response['id'] = $this->fcbk->api('/me/'.$namespace.':'.$action.'?'.$object.'='.$url,'post');
				$response['success'] = true;
				return $response;
			}catch(Exception $e){
				$response['message'] = "Error: ".$e->getMessage();
			}
		}else{
			$response['message'] = "Error: You must be logged in to facebook";
		}
		$response['success'] = false;
		return $response;
	}
	
	
	//****************************************************************************************
	//	OPENGRAPH
	//****************************************************************************************
	/**
	 * Generate the open graph tags
	 * @param array $options
	 * @return string
	 */
	public function get_the_open_graph_tags($options=array())
	{
		$html = '';
		if(!empty($options)){
			foreach($options as $tag=>$tag_value){
				//custom for video TYPE
				$tag = str_replace(array(":mp4","_mp4",":html","_html",'_custom'),array(""),$tag);
				$html .= '<meta property="'.$tag.'" content="'.stripcslashes($tag_value).'"/>'."\n";
			}
		}else{
			$html .= '<!-- '.__('Error No tags...',$this->plugin_text_domain).' -->'."\n";
		}
		return $html;
	}
	
	/**
	 * Constructo the openGraph array
	 * @param string $prefix_option
	 * @param array $array_pattern
	 * @param array $array_replace
	 * @param array $custom_post
	 * @return array
	 */
	public function construct_open_graph_tags($prefix_option,$array_pattern,$array_replace,$custom_post=array())
	{
		$options = array();
		$og_tags = $this->og_tags;
		//define all tags we need to display
		foreach($this->og_attachement_field as $type=>$tag_fields){
			foreach($tag_fields as $tag=>$tag_name){
				$tag_attachment_fields[$tag] = $tag_name;
			}
		}
		//add attachment fields to global fields for display
		$og_tags_final = array_merge($og_tags,$tag_attachment_fields);
		//if tags are empty because not set in plugin for retro actif on post and page
		if(empty($custom_post[$this->plugin_option_pref.'ogtags_disable'][0]))
			$custom_post[$this->plugin_option_pref.'ogtags_disable'][0] = 0;
		
		//if disabled from post settings, disable all
		$disabled_general = $this->options[$prefix_option.'disable'] == 1 ? true : false;
		$disabled_from_post = $custom_post[$this->plugin_option_pref.'ogtags_disable'][0] == 1 ? true : false;
		
		if(!$disabled_general AND !$disabled_from_post){
			//foreach tags, set value
			foreach($og_tags_final as $tag=>$tag_name){
				$option_value = '';
				//if choose to redefine from post
				if(isset($custom_post[$this->plugin_option_pref.'ogtags_redefine'][0]) && $custom_post[$this->plugin_option_pref.'ogtags_redefine'][0] == 1){
					$option_value = $custom_post[$this->plugin_option_pref.'ogtags_'.$tag][0];
					$audio = $custom_post[$this->plugin_option_pref.'ogtags_audio'][0];
					$video = $custom_post[$this->plugin_option_pref.'ogtags_video'][0];
					$video_mp4 = $custom_post[$this->plugin_option_pref.'ogtags_video:video:mp4'][0];
					$video_html = $custom_post[$this->plugin_option_pref.'ogtags_video:video:html'][0];
					$image = $custom_post[$this->plugin_option_pref.'ogtags_image'][0];
					$custom_type = $custom_post[$this->plugin_option_pref.'ogtags_type_custom'][0];
				//else use general settings
				}else{
					$option_value = isset($this->options[$prefix_option.$tag]) ? $this->options[$prefix_option.$tag] : '';
					$custom_type = isset($this->options[$prefix_option.'type_custom']) ? $this->options[$prefix_option.'type_custom'] : '';
					$audio =  isset($this->options[$prefix_option.'audio'] ) ? $this->options[$prefix_option.'audio'] : '';
					$video =  isset($this->options[$prefix_option.'video']) ? $this->options[$prefix_option.'video'] : '';
					$video_mp4 = isset($this->options[$prefix_option.'video:mp4']) ? $this->options[$prefix_option.'video:mp4'] : '';
					$video_html = isset($this->options[$prefix_option.'video:html']) ? $this->options[$prefix_option.'video:html'] : '';
					$image = isset($this->options[$prefix_option.'image']) ?  $this->options[$prefix_option.'image'] : '';
				}
				
				//set url with a pattern
				if($tag == 'url')
					$option_value = '%CURRENT_URL%';
				if($tag == 'type' && $option_value == 'custom' )
					$option_value = $custom_type;
					
				//add content type for each field video format (static value)
				if($tag == 'video:type')
					$option_value = 'application/x-shockwave-flash';		
				if($tag == 'video:type_mp4')
					$option_value = 'video/mp4';		
				if($tag == 'video:type_html')
					$option_value = 'text/html';
				
				//proces the patern replace
				$option_value = str_ireplace($array_pattern,$array_replace,$option_value);
				//clean the \r\n value and replace by space
				$option_value = str_replace("\n"," ",$option_value);
				$option_value = str_replace("\r","",$option_value);
				$option_value = str_replace("\t","",$option_value);
				
				
				
				//if image still empty, and if we get one for app infos... push it inside open Graph as default
				if(($tag == 'image' && $option_value == '%POST_IMAGE%') OR ($tag == 'image' && $option_value == '' && !empty($this->options['app_infos'])) ){
					$image = $option_value = $this->options['app_infos']['logo_url'];
				}
				
				//for video	and audio
				//if video src or audio src is null so don't display tags
				if(preg_match('@audio@',$tag) && $audio =='')
					continue;
				elseif( (preg_match('@video:mp4@',$tag) || preg_match('@type_mp4@',$tag)) && $video_mp4 =='')
					continue;
				elseif((preg_match('@video:html@',$tag) || preg_match('@type_html@',$tag)) && $video_html =='')
					continue;
				elseif(preg_match('@video@',$tag) && $video =='')
					continue;
				//need image for video to work
				elseif(preg_match('@video@',$tag) && $image =='')
					continue;
				elseif(($tag == 'app_id' || $tag == 'admins' || $tag == 'page_id') && $option_value!='')
					$options['fb:'.$tag] = $option_value;
				elseif($option_value !='')
					$options['og:'.$tag] = $option_value;
			}
		}
		return $options;
	}
	
	/**
	* Display the openGraph for the page
	* @return void
	*/
	public function define_open_graph_tags_header()
	{
		$current_post_type = get_post_type();
		$options = array();
		$blog_name = get_bloginfo('name');
		$blog_description = str_replace(array("\n","\r"),"",get_bloginfo('description'));
		$home_url = home_url();
		switch(1){
			//for posts
			case is_front_page():
			case is_home():
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%",'%CURRENT_URL%');
				$array_replace = array($blog_name,$blog_description,$home_url,$home_url);
				$options = $this->construct_open_graph_tags('ogtags_frontpage_',$array_pattern,$array_replace);
			break;
			//for all type of post
			case is_page():
			case is_single():
				global $post;
				$custom_post = get_post_custom($post->ID);
				$postypes_media = get_post_types(array('label'=>'Media'),'objects');
				$postypes = get_post_types(array('show_ui'=>true),'objects');
				//if find attachement type
				if(is_object($postypes_media['attachment']))
					$postypes['attachment'] = $postypes_media['attachment'];				
				//post types
				//change name of prefix for post type and post page
				if($current_post_type == 'post') $prefix_option = 'ogtags_post_';
				elseif($current_post_type == 'page') $prefix_option = 'ogtags_page_';
				else
					foreach($postypes as $postypes_name=>$type_values){
						if($current_post_type == $postypes_name){
						 	$prefix_option = 'ogtags_custom_post_types_'.$postypes_name.'_';						 	
							$type = $type_values->label;
						}
					}
				global $wpzoom_cf_use;
				//take from post thumbnail
				if(current_theme_supports('post-thumbnails')){
					if(has_post_thumbnail($post->ID)){
						$img = $this->catch_that_image(get_the_post_thumbnail($post->ID, 'AWD_facebook_ogimage'));
					}
				}
				//if no post thumbnail	
				if($img == ""){
                    if($wpzoom_cf_use == 'Yes')
                    	$img = get_post_meta($post->ID, $wpzoom_cf_photo, true);
                    	if(!$img)
                    		$img = $this->catch_that_image($post->post_content);
                }
                //take default if no image found.
                if($img==""){
                	is_single() ? $img = $this->options['ogtags_page_image'] : "";
                	is_page() ? $img = $this->options['ogtags_post_image'] : "";
                }
                
                //try to create a nice description
                if(!empty($post->post_excerpt)){
                	$description = esc_attr(str_replace("\r\n",' ',substr(strip_tags(strip_shortcodes($post->post_excerpt)), 0, 160)));
                }else{
					$description = esc_attr(str_replace("\r\n",' ',substr(strip_tags(strip_shortcodes($post->post_content)), 0, 160)));
                }
                
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%POST_TITLE%","%POST_EXCERPT%","%POST_IMAGE%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,$post->post_title,$description,$img,get_permalink($post->ID));
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace,$custom_post);
			break;
			//for tag archives
			case is_author():
				global $wp_query;
				$author_slug = $wp_query->query_vars['author_name'];
				$current_author = get_user_by('slug',$author_slug);
				$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$type =  'Authors';
				//get avatar for replace in pattern
				$avatar = get_avatar($current_author->ID, '50');
				//get the url of avatar
				if($avatar)
				    $gravatar_attributes = simplexml_load_string($avatar);
				if(!empty($gravatar_attributes['src']))
					$gravatar_url = $gravatar_attributes['src'];
				$prefix_option = 'ogtags_author_';
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%AUTHOR_TITLE%","%AUTHOR_IMAGE%","%AUTHOR_DESCRIPTION%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),$gravatar_url,$current_author->description,$current_archive_url);
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
			break;
			case is_tag():
			case is_date():
				$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$type =  'Archives';
				$prefix_option = 'ogtags_archive_';
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%ARCHIVE_TITLE%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),$current_archive_url);
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
			break;
			//for taxonomies register public
			case is_tax():
				global $wp_query;
				$taxonomy_slug = $wp_query->query_vars['taxonomy'];
				$taxonomy_name = get_term_by('slug',$value,$taxonomy_slug);
				$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$type =  'Taxonomies';
				$prefix_option = 'ogtags_taxonomies_'.$taxonomy_slug.'_';
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%TERM_TITLE%","%TERM_DESCRIPTION%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),term_description(),$current_archive_url);
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
				$type = 'TAX';
			break;
			//for categories
			case is_category():
					$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
					$type =  'Categories';
					$prefix_option = 'ogtags_taxonomies_category_';
					$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%TERM_TITLE%","%TERM_DESCRIPTION%","%CURRENT_URL%");
					$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),category_description(),$current_archive_url);
					$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
			break;
		}
		//if no options, no tags
		if(!empty($options)){
			echo "\n".'<!-- '.$this->plugin_name.' [v'.$this->get_version().'] START Open Graph Tags -->'."\n";
			echo $this->get_the_open_graph_tags($options);
			if(empty($options['og:image']))
				echo '<!-- '.__("WARNING Image is emtpy", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['og:title']))
				echo '<!-- '.__("WARNING Title is empty", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['og:site_name']))
				echo '<!-- '.__("WARNING Site Name is empty", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['og:description']))
				echo '<!-- '.__("WARNING Description is empty", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['fb:admins']) AND empty($options['fb:app_id']))
				echo '<!-- '.__("WARNING Admins id or app ID are empty", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['og:locale']) AND empty($options['og:locale']))
				echo '<!-- '.__("WARNING og:locale is empty, you should define this option in openGraph settings.", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			echo '<!-- '.$this->plugin_name.' END Open Graph Tags -->'."\n";
		}
	}
	
	/**
	 * Open Graph meta form in post and custom post type
	 * used both in open graph settings
	 * @param WP_Post object $post
	 * @param array $metabox
	 * @return void
	 */
	public function open_graph_post_metas_form($post=null,$metabox=array())
	{
		//prefix defined from args,
		//custom take value from custom args if set...
		$prefix = $this->plugin_option_pref.'ogtags_';
		if(is_array($metabox)){
			if(is_array($metabox['args'])){
				$prefix = $metabox['args']['prefix'];
				//custom is the name of the array of option
				$customTemp = $metabox['args']['custom'];
				$custom = $this->options[$customTemp];
				//reconstruct the arry to be compatible with this function and args metabox
				if($customTemp){
					foreach($this->options as $option=>$value)
						if(preg_match('@'.$customTemp.'@',$option))
							$custom[str_ireplace($customTemp.'_',"",$prefix).$option][0] = $value;
				}
				//use h4 or other
				$custom_header = $metabox['args']['header'];
				$custom_help = $metabox['args']['help'];
			}
		}
		
		if($custom_header =='')
			$custom_header ='h4';
		//if post get custom from post
		//else get custom from $vars
		if(is_object($post))
			$custom = get_post_custom($post->ID);
		elseif(!$custom)
			$custom = array();
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				var icons = {
					header: "ui-icon-circle-arrow-e",
					headerSelected: "ui-icon-circle-arrow-s"
				};
				jQuery(".ui_ogtags_form").accordion({
					header: "h4",
					autoHeight: false,
					icons:icons,
					collapsible: true,
					active: false
				});
			
				jQuery("#<?php echo $prefix.'upload_image'; ?>").click(function() {
					var formfield = jQuery("#<?php echo $prefix.'image'; ?>").attr('name');
					tb_show("<?php echo __('Image',$this->plugin_text_domain).' '.$this->plugin_name; ?>", 'media-upload.php?type=image&amp;TB_iframe=true');
					
					window.send_to_editor = function(html) {
						var imgurl = jQuery('img',html).attr('src');
						jQuery("#<?php echo $prefix.'image'; ?>").val(imgurl);
						tb_remove();
					}
					return false;
				});
				
				//audio  
				jQuery("#<?php echo $prefix.'upload_mp3';?>").click(function() {
					var formfield = jQuery("#<?php echo $prefix.'audio'; ?>").attr('name');
					tb_show("<?php echo __('Mp3 song',$this->plugin_text_domain).' '.$this->plugin_name; ?>", 'media-upload.php?type=audio&amp;TB_iframe=true');
					
					window.send_to_editor = function(html) {
						var src = jQuery(html).attr('href');
						var title = jQuery(html).html();
						jQuery("#<?php echo $prefix.'audio'; ?>").val(src);
						jQuery("#<?php echo $prefix.'audio_title'; ?>").val(title);
						tb_remove();
					}
					return false;
				});
				
				//onload verify state of message video if empty image
				<?php echo str_replace("-","_",$prefix); ?>set_the_message_video();
				//display error to say that we nedd image if image field is empty
				//on click every where in body
				jQuery('body').click(function(){
					<?php echo str_replace("-","_",$prefix); ?>set_the_message_video();
				});
				//video swf  
				jQuery("#<?php echo $prefix.'upload_video';?>").click(function() {
					var formfield = jQuery("#<?php echo $prefix.'video'; ?>").attr('name');
					tb_show("<?php echo __('Video',$this->plugin_text_domain).' '.$this->plugin_name; ?>", 'media-upload.php?post_id=<?php echo $post->ID; ?>&amp;type=video&amp;TB_iframe=true');
					
					window.send_to_editor = function(html) {
						var src = jQuery(html).attr('href');
						jQuery("#<?php echo $prefix.'video'; ?>").val(src);
						tb_remove();
					}
					return false;
				});
				//active default open graph checkbox status
				<?php echo str_replace("-","_",$prefix); ?>update_custom_type();
  				jQuery("#<?php echo $prefix.'type';?>").change(function(){
  					<?php echo str_replace("-","_",$prefix); ?>update_custom_type();
  				});
				//active default open graph checkbox status
  				jQuery("#<?php echo $prefix.'disable_off';?>").click(function(){
  					jQuery(".ui_ogtags_allform<?php echo $customTemp;?>").slideDown();
  				});
  				jQuery("#<?php echo $prefix.'disable_on';?>").click(function(){
  					jQuery(".ui_ogtags_allform<?php echo $customTemp;?>").slideUp();
  				});
  				jQuery("#<?php echo $prefix.'redefine_on';?>").click(function(){
  					jQuery(".ui_ogtags_form<?php echo $customTemp;?>").slideDown();
  				});
  				jQuery("#<?php echo $prefix.'redefine_off';?>").click(function(){
  					jQuery(".ui_ogtags_form<?php echo $customTemp;?>").slideUp();
  				});
			});
			function <?php echo str_replace("-","_",$prefix); ?>set_the_message_video(){
				if(jQuery("#<?php echo $prefix.'image';?>").val() ==''){
					<?php 
					//display message only if no app image as default
					if(empty($this->options['app_infos']['logo_url'])): ?>
					jQuery("#<?php echo $prefix.'message_video';?>").show();
					<?php endif; ?>
				}else{
					jQuery("#<?php echo $prefix.'message_video';?>").slideUp();
				}
			
			}
			function <?php echo str_replace("-","_",$prefix); ?>update_custom_type(){
				if(jQuery("#<?php echo $prefix.'type';?>").val() == 'custom'){
  					jQuery("#<?php echo $prefix.'type_custom';?>").slideDown();
					jQuery("#<?php echo $prefix.'type_custom';?>").attr('disabled',false);
				}else{
					jQuery("#<?php echo $prefix.'type_custom';?>").slideUp();
					jQuery("#<?php echo $prefix.'type_custom';?>").attr('disabled',true);
				}
			}
		</script>
		<p>
		    <?php 
		    //if post or global form
		    if(is_object($post)){ ?>
			    <label class="up_label"><?php _e('Disable Tags for this page ?',$this->plugin_text_domain); ?></label>
				<?php 
			}else{
				?>
			    <label class="up_label"><?php _e('Disable Tags for this type ? ',$this->plugin_text_domain); ?> <i><?php _e('You can override settings on each page individually',$this->plugin_text_domain); ?></i></label>
				<?php
			}
			?>
			<input type="radio" name="<?php echo $prefix.'disable';?>" <?php if($custom[$prefix.'disable'][0] == 1 OR ($custom[$prefix.'disable'][0] == '' && !is_object($post))){echo 'checked="checked"';} ?> id="<?php echo $prefix.'disable_on';?>" value="1"/> <?php _e('Yes',$this->plugin_text_domain); ?>
			<input type="radio" name="<?php echo $prefix.'disable';?>" <?php if($custom[$prefix.'disable'][0] == "0" OR (is_object($post) && $custom[$prefix.'disable'][0]=='')){echo 'checked="checked"';} ?> id="<?php echo $prefix.'disable_off';?>" value="0"/> <?php _e('No',$this->plugin_text_domain); ?>
		</p>
		<div class="ui_ogtags_allform<?php echo $customTemp; ?> <?php if($custom[$prefix.'disable'][0] == 1 OR ($custom[$prefix.'disable'][0] == '' && !is_object($post))){echo 'hidden';} ?>">
		<?php 
	    //if post or global form
        if(is_object($post)){ ?>	
		<p>
			<label class="up_label"><?php _e('Redefine Tags for this page ?',$this->plugin_text_domain); ?></label>
			<input type="radio" name="<?php echo $prefix.'redefine';?>" <?php if($custom[$prefix.'redefine'][0] == 1){echo 'checked="checked"';} ?> id="<?php echo $prefix.'redefine_on';?>" value="1"/> <?php _e('Yes',$this->plugin_text_domain); ?>
			<input type="radio" name="<?php echo $prefix.'redefine';?>" <?php if($custom[$prefix.'redefine'][0] == 0){echo 'checked="checked"';} ?> id="<?php echo $prefix.'redefine_off';?>" value="0"/> <?php _e('No',$this->plugin_text_domain); ?>
		</p>
		<?php }	?>
		<div class="ui_ogtags_form ui_ogtags_form<?php echo $customTemp; ?> <?php if($custom[$prefix.'redefine'][0]!= 1 && is_object($post)){echo 'hidden';} ?>">
			<?php echo $this->get_the_help_box($custom_help); ?>
			<<?php echo $custom_header; ?>><a href="#"><?php _e('Tags',$this->plugin_text_domain); ?></a></<?php echo $custom_header; ?>>
			<div>
			<div class="uiForm">
				<table class="AWD_form_table">
				<?php
				foreach($this->og_tags as $tag=>$tag_name){
					$prefixtag = $prefix.$tag;
					$custom_value = stripslashes($custom[$prefixtag][0]);
					switch($tag){
						case 'url':
							$input ='';
							$tag_name = '';//'<br /><input class="widefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : get_permalink($post->ID)).'" />';
						break;
						case 'title':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : $post->post_title).'" />';
						break;
						case 'site_name':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : get_bloginfo('name')).'" />';
						break;
						case 'type':
							$input ='<select name="'.$prefixtag.'" id="'.$prefixtag.'">';
							foreach($this->og_types as $globaltype=>$types){
								$input .='<optgroup label="'.strtoupper($globaltype).'">';
								foreach($types as $type=>$type_name)
									$input .='<option '.($custom_value == $type ? 'selected="selected"':'').' value="'.$type.'">'.$type_name.'</option>';
								$input .='</optgroup>';
							}
							$input .= '</select>';
							$input .= '<input class="hidden" disabled="disabled" id="'.$prefixtag.'_custom" name="'.$prefixtag.'_custom" type="text" value="'.($custom[$prefixtag.'_custom'][0] != '' ? $custom[$prefixtag.'_custom'][0] : 'Custom value').'" />';
						break;
						case 'description':
							$input = '<textarea class="widefat" id="'.$prefixtag.'" name="'.$prefixtag.'">'.($custom_value != '' ? $custom_value : $post->excerpt).'</textarea>';
						break;
						case 'app_id':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : $this->options['app_id']).'" />';
						break;
						case 'admins':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : $this->options['admins']).'" />';
						break;
						case 'locale':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : $this->options['locale']).'" />';
						break;
						case 'page_id':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : $this->options['admins_page_id']).'" />';
						break;
						case 'image':
							$input = '<input class="ogwidefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /><img id="'.$prefix.'upload_image" src="'.$this->plugin_url_images.'upload_image.png" alt="'.__('Upload',$this->plugin_text_domain).'" class="AWD_button_media"/>';
						break;
						default:
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.$custom_value.'" />';
					}
					if($tag_name){
						?>
						<tr class="dataRow">
							<th class="label"><?php echo $tag_name; ?></th>
							<td class="data">
								<?php echo $input; ?>
							</td>
						</tr>
						<?php
					}
				}
				?>
				</table>
			</div>
			</div>
			<?php
			foreach($this->og_attachement_field as $type=>$tag_fields){
				switch($type){
					//video form
					case 'video':
						echo '<'.$custom_header.'><a href="#">'.__('Video Attachement',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '
						<div>
						<i>'.__('Facebook supports embedding video in SWF format only. File ith extension ".swf"',$this->plugin_text_domain).'</i>
						<div class="uiForm">
							<div id="'.$prefix.'message_video" class="ui-state-highlight hidden">'.__('You must include a valid Image for your video in Tags section to be displayed in the news feed.',$this->plugin_text_domain).'</div>
							<table class="AWD_form_table">';
							foreach($tag_fields as $tag=>$tag_name){
								$prefixtag = $prefix.$tag;
								$custom_value = $custom[$prefixtag][0];
								switch($tag){
									case 'video':
										$input = '<input class="ogwidefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /><img id="'.$prefix.'upload_'.$tag.'" src="'.$this->plugin_url_images.'upload_image.png" alt="'.__('Upload',$this->plugin_text_domain).'" class="AWD_button_media"/>';
									break;
									case 'video:type':
										$input = '';//<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" readonly="readonly" value="'.($custom_value != '' ? $custom_value : 'application/x-shockwave-flash').'" />';
									break;
									case 'video:type_mp4':
										$input = '';//<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" readonly="readonly" value="'.($custom_value != '' ? $custom_value : 'video/mp4').'" />';
									break;
									case 'video:type_html':
										$input = '';//<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" readonly="readonly" value="'.($custom_value != '' ? $custom_value : 'text/html').'" />';
									break;
									default:
										$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
								}
								if($tag != 'video:type' && $tag != 'video:type_html' && $tag != 'video:type_mp4'):
								?>
								<tr class="dataRow">
									<th class="label"><?php echo $tag_name; ?></th>
									<td class="data">
										<?php echo $input; ?>
									</td>
								</tr>
								<?php
								endif;
							}
						echo '</table>
						</div>
						</div>';//fin toogle
					break;
					//audio form
					case 'audio':
						echo '<'.$custom_header.'><a href="#">'.__('Audio Attachement',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '
						<div>
							<i>'.__('In a similar fashion to Video you can add an audio file to your markup',$this->plugin_text_domain).'</i>
							<div class="uiForm">
								<table class="AWD_form_table">';
								foreach($tag_fields as $tag=>$tag_name){
									$prefixtag = $prefix.$tag;
									$custom_value = $custom[$prefixtag][0];
									switch($tag){
										case 'audio':
											$input = '<input class="ogwidefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /><img id="'.$prefix.'upload_mp3" src="'.$this->plugin_url_images.'upload_image.png" alt="'.__('Upload',$this->plugin_text_domain).'" class="AWD_button_media"/>';
										break;
										case 'audio:type':
											$input = '';//<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" readonly="readonly" value="'.($custom_value != '' ? $custom_value : 'application/mp3').'" />';
										break;
										default:
											$input = '<input  id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
									}
									if($tag != 'audio:type'):
									?>
									<tr class="dataRow">
										<th class="label"><?php echo $tag_name; ?></th>
										<td class="data">
											<?php echo $input; ?>
										</td>
									</tr>
									<?php
									endif;
								}
						echo '</table>
						</div>
						</div>';//fin toogle
					break;
					//isbn and upc code
					case 'isbn':
					case 'upc':
						foreach($tag_fields as $tag=>$tag_name){
							$prefixtag = $prefix.$tag;
							$custom_value = $custom[$prefixtag][0];
							echo '<'.$custom_header.'><a href="#">'.strtoupper($type).' '.__('code',$this->plugin_text_domain).'</a></'.$custom_header.'>';
							echo '
							<div>
							<div class="uiForm">
								<table class="AWD_form_table">
									<tr class="dataRow">
										<th class="label">'.__('For products which have a UPC code or ISBN number',$this->plugin_text_domain).'</th>
										<td class="data"><input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /></td>
									</tr>
								</table>
							</div>
							</div>';
						}
					break;
					//contact form
					case 'contact':
						echo '<'.$custom_header.'><a href="#">'.__('Contact infos',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '<div>';
							echo '<i>'.__('Consider including contact information if your page is about an entity that can be contacted.',$this->plugin_text_domain).'</i>
							<div class="uiForm">
								<table class="AWD_form_table">';
								foreach($tag_fields as $tag=>$tag_name){
									$prefixtag = $prefix.$tag;
									$custom_value = $custom[$prefixtag][0];
									switch($tag){
										default:
											$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
									}
									?>
									<tr class="dataRow">
										<th class="label"><?php echo $tag_name; ?></th>
										<td class="data">
											<?php echo $input; ?>
										</td>
									</tr>
									<?php
								}
						echo '</table>
						</div>
						</div>';//fin toogle
					break;
					//location form
					case 'location':
						echo '<'.$custom_header.'><a href="#">'.__('Location infos',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '<div>';
							echo '<i>'.__('This is useful if your pages is a business profile or about anything else with a real-world location. You can specify location via latitude and longitude, a full address, or both.',$this->plugin_text_domain).'</i>
							<div class="uiForm">
								<table class="AWD_form_table">';
								foreach($tag_fields as $tag=>$tag_name){
									$prefixtag = $prefix.$tag;
									$custom_value = $custom[$prefixtag][0];
									switch($tag){
										default:
											$input = '<input size="25" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
									}
									?>
									<tr class="dataRow">
										<th class="label"><?php echo $tag_name; ?></th>
										<td class="data">
											<?php echo $input; ?>
										</td>
									</tr>
									<?php
								}
						echo '</table>
						</div>
						</div>';//fin toogle
					break;
				}
			}
			?>
			</div>
		</div>
		<?php //fin start fucntion div
	}
	
	
	//****************************************************************************************
	//	LOGIN BUTTON
	//****************************************************************************************
	/**
	 * Return the loggin button  shortcode
	 * @param array $atts
	 * @return string
	 */
	public function shortcode_login_button($atts=array())
	{
		$new_atts = array();
		if(is_array($atts)){	
			extract(shortcode_atts(array("init"=>"init"), $atts )); 
			foreach($atts as $att=>$value){
				$new_atts['login_button_'.$att] = $value;
			}
		}
		return $this->get_the_login_button($new_atts);
	}
	
	/**
	 * Return the html for login button
	 * @param array $options
	 * @return string
	 */
	public function get_the_login_button($options=array())
	{
		$width = ($options['login_button_width'] == '' ? $this->options['login_button_width'] : $options['login_button_width']);
		$show_profile_picture = ($options['login_button_profile_picture'] == '' ? $this->options['login_button_profile_picture'] : $options['login_button_profile_picture']);
		$show_faces = (($options['login_button_faces'] == '' ? $this->options['login_button_faces'] : $options['login_button_faces']) == 1 ? 'true' : 'false');
		$maxrow = ($options['login_button_maxrow'] == '' ? $this->options['login_button_maxrow'] : $options['login_button_maxrow']);
		$logout_value = ($options['login_button_logout_value'] == '' ? $this->options['login_button_logout_value'] : $options['login_button_logout_value']);
		$logout_redirect_url = ($options['login_button_logout_url'] == '' ? $this->options['login_button_logout_url'] : $options['login_button_logout_url']);
		$logout_redirect_url = str_ireplace("%BLOG_URL%",home_url(),$logout_redirect_url);
		$login_redirect_url = ($options['login_button_login_url'] == '' ? $this->options['login_button_login_url'] : $options['login_button_login_url']);
		$login_redirect_url = str_replace("%BLOG_URL%",home_url(),$login_redirect_url);
		$login_button_image = ($options['login_button_image'] == '' ? $this->options['login_button_image'] : $options['login_button_image']);
		//we set faces options to false, if user not connected
		//old perms perms="'.$this->options['perms'].'"
		$login_button = '<fb:login-button show-faces="'.($this->me ? $show_faces : 'false').'" width="'.$width.'" max-rows="'.$maxrow.'" size="medium" ></fb:login-button>';
		
		//if some options defined
		if(empty($options['case'])){
			if($this->is_user_logged_in_facebook() && $this->options['connect_enable'] == 1 && is_user_logged_in())
				$case = 'profile';
			else if($this->options['connect_enable'] == 1)
				$case = 'login';
			else 
				$case = 'message_connect_disabled';
		}else{
			$case = $options['case'];
		}
		switch($case){
			case 'profile':
				$html = '';
				$html .= '<div class="AWD_profile '.$options['profile_css_classes'].'">'."\n";
				if($show_profile_picture == 1 && $show_faces == 'false'){
					$html .= '<div class="AWD_profile_image"><a href="'.$this->me['link'].'" target="_blank"> '.get_avatar($this->current_user->ID,'50').'</a></div>'."\n";
				}
				$html .='<div class="AWD_right">'."\n";
					if($show_faces == 'true'){
						$html .='<div class="AWD_faces">'.$login_button.'</div>'."\n";
					}else{
						$html .='<div class="AWD_name"><a href="'.$this->me['link'].'" target="_blank">'.$this->me['name'].'</a></div>'."\n";
					}
					//display logout button only if we are not in facebook tab.
					if($this->facebook_page_url == ''){
						$html .='<div class="AWD_logout"><a href="'.wp_logout_url($logout_redirect_url).'">'.$logout_value.'</a></div>'."\n";
					}
				$html .='</div>'."\n";
				$html .='<div class="clear"></div>'."\n";
				$html .='</div>'."\n";
				return $html;
			break;	
			
			case 'login':
				return '
				<div class="AWD_facebook_login '.$options['login_button_css_classes'].'">
					<a href="'.$this->login_url.'" onclick="AWD_facebook.connect(\''.urlencode($login_redirect_url).'\'); return false;"><img src="'.$login_button_image.'" border="0" /></a>
				</div>'."\n";
			break;
		
			case 'message_connect_disabled':
				if(is_admin())
				return '<div class="ui-state-highlight">'.sprintf(__('You should enable FB connect in %sApp settings%s',$this->plugin_text_domain),'<a href="admin.php?page='.$this->plugin_slug.'">','</a>').'</div>';
			break;
		}
	}
	
	/**
	 * Print the login button for the wp-login.php page
	 * @return void
	 */
	public function the_login_button_wp_login()
	{
		?>
		<div class="AWD_facebook_connect_wplogin">
			<label><?php _e('Connect with Facebook',$this->plugin_text_domain); ?></label>
			<?php echo $this->get_the_login_button(); ?>
		</div>
		<br />
		<?php
		$this->add_js_options();
		$this->load_sdj_js();
		$this->js_sdk_init();
	}
	
	//****************************************************************************************
	//	LIKE BUTTON
	//****************************************************************************************
	/**
	 * Return the like button shortcode
	 * @return string
	 */
	public function shortcode_like_button($atts=array())
	{
		$new_atts = array();
		if(is_array($atts)){
			extract(shortcode_atts(array("init"=>"init"), $atts )); 
			foreach($atts as $att=>$value){
				$new_atts['like_button_'.$att] = $value;
			}
		}
		//check if we want to use post in this shortcode or different url
		if($new_atts['like_button_url'] == '')
			global $post;
		return $this->get_the_like_button($post,$new_atts);
	}
	
	/**
	 * Return the like button
	 * @return string
	 */
	public function get_the_like_button($post="",$options=array())
	{
		$href = get_permalink($post->ID);
		if(is_object($post))
			$href = get_permalink($post->ID);
		else    
			$href =($options['like_button_url'] == '' ? $this->options['like_button_url'] : $options['like_button_url']);
		
		$send = (($options['like_button_send'] == '' ? $this->options['like_button_send'] : $options['like_button_send']) == 1 ? 'true' : 'false');
		$width = ($options['like_button_width'] == '' ? $this->options['like_button_width'] : $options['like_button_width']);
		$colorscheme = ($options['like_button_colorscheme'] == '' ? $this->options['like_button_colorscheme'] : $options['like_button_colorscheme']);
		$show_faces = (($options['like_button_faces'] == '' ? $this->options['like_button_faces'] : $options['like_button_faces']) == 1 ? 'true' : 'false');
		$font = ($options['like_button_font'] == '' ? $this->options['like_button_font'] : $options['like_button_font']);
		$action = ($options['like_button_action'] == '' ? $this->options['like_button_action'] : $options['like_button_action']);
		$layout = ($options['like_button_layout'] == '' ? $this->options['like_button_layout'] : $options['like_button_layout']);
		$height = ($options['like_button_height'] == '' ? $this->options['like_button_height'] : $options['like_button_height']);
		$template = ($options['like_button_type'] == '' ? $this->options['like_button_type'] : $options['like_button_type']);
		$content = ($options['like_button_content'] == '' ? $this->options['like_button_content'] : $options['like_button_content']);
		if($height == ''){
			if($layout == 'box_count') $height = '90';
			elseif($layout == 'button_count') $height = '21';
			else $height = '35';
		}
		if($content !=''){
			return $content;
		}else{
			try {
				$AWD_facebook_likebutton = new AWD_facebook_likebutton($href,$send,$layout,$show_faces,$width,$height,$action,$font,$colorscheme,$ref,$template);
				return '<div class="AWD_facebook_likebutton '.$options['like_button_css_classes'].'">'.$AWD_facebook_likebutton->get().'</div>';
			} catch (Exception $e){
				return '<div class="ui-state-highlight">'.__("There is an error, please verify the settings for the like button url",$this->plugin_text_domain).'</div>';
			}
		}
	}
	
	/**
	 * Add manager to post editor
	 * @param WP_Post object $post
	 * @return void
	 */
	 public function post_manager_content($post){
	 	$custom = get_post_custom($post->ID);
	 	//disabled  redefine by default like button
	 	if($custom[$this->plugin_option_pref.'like_button_redefine'][0] == '')
	 		$custom[$this->plugin_option_pref.'like_button_redefine'][0] == 0;
	 	//enable by default like button
	 	if($custom[$this->plugin_option_pref.'like_button_enabled'][0] == '')
	 		$custom[$this->plugin_option_pref.'like_button_enabled'][0] = 1;
	 	?>
	 	<div class="misc-pub-section">
			<?php 
			if(is_array($this->options['admins_errors'])){
				echo implode('<br />',$this->options['admins_errors']).'<br />';
				$this->options['admins_errors'] = array();
				$this->optionsManager->setOptions($this->options);
				$this->optionsManager->save();
			}
			?>
	 		<?php echo do_shortcode('[AWD_likebutton width="250" href="'.get_permalink($post->ID).'"]'); ?>
	 	</div>
	 	<div class="uiForm">
	 		<h3 class="center"><?php _e('Like Button',$this->plugin_text_domain); ?></h3>
			<span class="label"><?php _e('Redefine globals settings?',$this->plugin_text_domain); ?></span>
			<br />
			<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_redefine_on" name="<?php echo $this->plugin_option_pref; ?>like_button_redefine" value="1" <?php if($custom[$this->plugin_option_pref.'like_button_redefine'][0] == 1) echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_redefine_on"><?php echo __('On',$this->plugin_text_domain); ?></label>
			<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_redefine_off" name="<?php echo $this->plugin_option_pref; ?>like_button_redefine" value="0" <?php if($custom[$this->plugin_option_pref.'like_button_redefine'][0] == 0) echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_redefine_off"><?php echo __('Off',$this->plugin_text_domain); ?></label>
			<div class="AWD_likebutton_enable <?php if($custom[$this->plugin_option_pref.'like_button_redefine'][0] == 0){ echo 'hidden'; } ?>">
				<span class="label"><?php _e('Activate ?',$this->plugin_text_domain); ?></span>
				<br />
				<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_enabled_on" name="<?php echo $this->plugin_option_pref; ?>like_button_enabled" value="1" <?php if($custom[$this->plugin_option_pref.'like_button_enabled'][0] == 1) echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_enabled_on"><?php echo __('On',$this->plugin_text_domain); ?></label>
				<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_enabled_off" name="<?php echo $this->plugin_option_pref; ?>like_button_enabled" value="0" <?php if($custom[$this->plugin_option_pref.'like_button_enabled'][0] == 0) echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_enabled_off"><?php echo __('Off',$this->plugin_text_domain); ?></label>
				<br />
				<div class="AWD_likebutton_positionning <?php if($custom[$this->plugin_option_pref.'like_button_enabled'][0] == 0){ echo 'hidden'; } ?>">
					<span class="label"><?php _e('Where ?',$this->plugin_text_domain); ?></span>
					<br />
					<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_top" name="<?php echo $this->plugin_option_pref; ?>like_button_place" value="top" <?php if($custom[$this->plugin_option_pref.'like_button_place'][0] == 'top') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place"><?php echo __('Top',$this->plugin_text_domain); ?></label>
					<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_bottom" name="<?php echo $this->plugin_option_pref; ?>like_button_place" value="bottom" <?php if($custom[$this->plugin_option_pref.'like_button_place'][0] == 'bottom') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place"><?php _e('Bottom',$this->plugin_text_domain); ?></label>
					<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_both" name="<?php echo $this->plugin_option_pref; ?>like_button_place" value="both" <?php if($custom[$this->plugin_option_pref.'like_button_place'][0] == 'both') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place"><?php _e('Both',$this->plugin_text_domain); ?></label>
				</div>
			</div>
				<br />
				<h3 class="center"><?php _e('Publish',$this->plugin_text_domain); ?><?php echo $this->get_the_help('awd_publish_pages','help'); ?></h3>
				<?php if($this->is_user_logged_in_facebook()): ?>
					<?php if($this->current_facebook_user_can('publish_stream')): ?>
						<?php if($this->current_facebook_user_can('manage_pages')): ?>
							<div class="AWD_button_succes help_awd_publish_pages hidden">
							<?php echo __('You can publish this post to facebook when you save it, It is recommended to use OpenGraph. You can set the linked FB pages in settings. If you selected a lot of pages, the loading may be long.',$this->plugin_text_domain); ?>
							</div>
							<br />
							<input type="checkbox" class="uiCheckbox" id="<?php echo $this->plugin_option_pref; ?>publish_to_pages" name="<?php echo $this->plugin_option_pref; ?>publish_to_pages" value="1" <?php if($this->options['publish_to_pages'] == 1) echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>publish_to_pages"><?php echo __('Publish to Facebook pages ?',$this->plugin_text_domain); ?></label>
							<br />
							<input type="checkbox" class="uiCheckbox" id="<?php echo $this->plugin_option_pref; ?>publish_to_profile" name="<?php echo $this->plugin_option_pref; ?>publish_to_profile" value="1" <?php if($this->options['publish_to_profile'] == 1) echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>publish_to_profile"><?php echo __('Publish to your Facebook profile ?',$this->plugin_text_domain); ?></label>
							<br />
							<label for="<?php echo $this->plugin_option_pref; ?>publish_message_text"><?php echo __('Add a message to the post ?',$this->plugin_text_domain); ?></label><br />
							<textarea class="uiTextarea" id="<?php echo $this->plugin_option_pref; ?>publish_message_text" name="<?php echo $this->plugin_option_pref; ?>publish_message_text"></textarea> 
							<br />
							<label for="<?php echo $this->plugin_option_pref; ?>publish_read_more_text"><?php echo __('Custom Action Label',$this->plugin_text_domain); ?></label><br />
							<input type="text" class="uiTextarea" value="<?php echo $this->options['publish_read_more_text']; ?>" id="<?php echo $this->plugin_option_pref; ?>publish_read_more_text" name="<?php echo $this->plugin_option_pref; ?>publish_read_more_text" maxlengh="25"/>
						<?php 
						else:
							echo $this->return_error(__('You must authorize manage_pages permission in the settings of the plugin', $this->plugin_text_domain));
						endif;
					else: 
						echo $this->return_error(__('You must authorize publish_stream permission in the settings of the plugin', $this->plugin_text_domain));
					endif;
				else:
					echo '<p>'.do_shortcode('[AWD_loginbutton]').'</p>';
				endif;
		 	?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#<?php echo $this->plugin_option_pref; ?>like_button_enabled_on').click(function(){
					$('.AWD_likebutton_positionning').slideDown();
				});
				$('#<?php echo $this->plugin_option_pref; ?>like_button_enabled_off').click(function(){
					$('.AWD_likebutton_positionning').slideUp();
				});
				$('#<?php echo $this->plugin_option_pref; ?>like_button_redefine_on').click(function(){
					$('.AWD_likebutton_enable').slideDown();
				});
				$('#<?php echo $this->plugin_option_pref; ?>like_button_redefine_off').click(function(){
					$('.AWD_likebutton_enable').slideUp();
				});
				//special toogle for help in the manager
				$('#help_awd_publish_pages').click(function(e){
					e.preventDefault();
					$('.help_awd_publish_pages').slideToggle();
				});
			});
		</script>						
	 	<?php
	 }
	
	
	//****************************************************************************************
	//	COMMENT BOX
	//****************************************************************************************
	/**
	 * Return the like button shortcode
	 * @param array $atts
	 * @return string
	 */
	public function shortcode_comments_box($atts=array())
	{
		$new_atts = array();
		if(is_array($atts)){
			extract(shortcode_atts(array("init"=>"init"), $atts )); 
			foreach($atts as $att=>$value){
				$new_atts['comments_'.$att] = $value;
			}
		}
		//check if we want to use post in this shortcode or different url
		if($new_atts['comments_url'] == '')
			global $post;
		return $this->get_the_comments_box($post,$new_atts);
	}
	
	/**
	 * Return the like button
	 * @param WP_Post object $post
	 * @param array $options
	 * @return string
	 */
	public function get_the_comments_box($post=null,$options=array())
	{
		$href = get_permalink($post->ID);
		if(is_object($post))
		    $href = get_permalink($post->ID);
		else    
            $href =($options['comments_url'] == '' ? $this->options['comments_url'] : $options['comments_url']);
        
		$nb = ($options['comments_nb'] == '' ? $this->options['comments_nb'] : $options['comments_nb']);
		$width = ($options['comments_width'] == '' ? $this->options['comments_width'] : $options['comments_width']);
		$colorscheme = ($options['comments_colorscheme'] == '' ? $this->options['comments_colorscheme'] : $options['comments_colorscheme']);
		$template = ($options['comments_type'] == '' ? $this->options['comments_type'] : $options['comments_type']);
		$mobile = (($options['comments_mobile'] == '' ? $this->options['comments_mobile'] : $options['comments_mobile']) == 1 ? 'true' : 'false');

		if($this->options['comments_content'] !='')
			return '<div class="ui-state-highlight">'.$this->options['comments_content'].'</div>';
		if($href!=''){
			try {
				$AWD_facebook_comments = new AWD_facebook_comments($href,$width,$colorscheme,$nb,$mobile,$template);
				return '<div class="AWD_facebook_comments '.$options['comments_css_classes'].'">'.$AWD_facebook_comments->get().'</div>';
			} catch (Exception $e){
				return '<div class="AWD_facebook_comments '.$options['comments_css_classes'].'" style="color:red;">'.__("There is an error, please verify the settings for the Comments box url",$this->plugin_text_domain).'</div>';
			}
		}else if($href==''){
			return '<div class="ui-state-highlight">'.__("There is an error, please verify the settings for the Comments box url",$this->plugin_text_domain).'</div>';
		}
	}
	
	/**
	 * Filter the comment form to add fbcomments
	 * @return void
	 */
	public function the_comments_form()
	{
		global $post;
		$exclude_post_page_id = explode(",",$this->options['comments_exclude_post_id']);
		if(!in_array($post->ID,$exclude_post_page_id)){
			if($post->post_type == 'page' && $this->options['comments_on_pages']){
				echo '<br />'.$this->get_the_comments_box($post);
	        }elseif($post->post_type == 'post' && $this->options['comments_on_posts']){
			    echo '<br />'.$this->get_the_comments_box($post);
			}elseif($post->post_type != '' && $this->options['comments_on_custom_post_types']){
				echo '<br />'.$this->get_the_comments_box($post);
			}
		}
	}
	
	
	//****************************************************************************************
	//	LIKE BOX 
	//****************************************************************************************
	/**
	 * Return the like box shortcode
	 * @param array $atts
	 * @return string
	 */
	public function shortcode_like_box($atts=array())
	{
		$new_atts = array();
		if(is_array($atts)){
			extract(shortcode_atts(array("init"=>"init"), $atts )); 
			foreach($atts as $att=>$value){
				$new_atts['like_box_'.$att] = $value;
			}
		}
		return $this->get_the_like_box($new_atts);
	}
	
	/**
	 * Return the Like Box
	 * @param array $options
	 * @return string
	 */
	public function get_the_like_box($options=array())
	{
		$href = ($options['like_box_url'] == '' ? $this->options['like_box_url'] : $options['like_box_url']);
		$width = ($options['like_box_width'] == '' ? $this->options['like_box_width'] : $options['like_box_width']);
		$colorscheme = ($options['like_box_colorscheme'] == '' ? $this->options['like_box_colorscheme'] : $options['like_box_colorscheme']);
		$show_faces = (($options['like_box_faces'] == '' ? $this->options['like_box_faces'] : $options['like_box_faces']) == 1 ? 'true' : 'false');
		$stream = (($options['like_box_stream'] == '' ? $this->options['like_box_stream'] : $options['like_box_stream']) == 1 ? 'true' : 'false');
		$header = (($options['like_box_header'] == '' ? $this->options['like_box_header'] : $options['like_box_header']) == 1 ? 'true' : 'false');
		$height = ($options['like_box_height'] == '' ? $this->options['like_box_height'] : $options['like_box_height']);
		$template = ($options['like_box_type'] == '' ? $this->options['like_box_type'] : $options['like_box_type']);
		$border_color = ($options['like_box_border_color'] == '' ? $this->options['like_box_border_color'] : $options['like_box_border_color']);
		$force_wall = (($options['like_box_force_wall'] == '' ? $this->options['like_box_force_wall'] : $options['like_box_force_wall']) == 1 ? true : false);
		
		if($height == ''){
			if($show_stream == 'true' AND $show_faces == 'true')
				$height = '600';
			else if($show_stream == 'true')
				$height = '427';
			else
				$height = '62';
		}
		
		if($this->options['like_box_url'] == '' && $href == '')
			return '<div class="ui-state-highlight">'.__("There is an error, please verify the settings for the Like Box URL",$this->plugin_text_domain).'</div>';
		else{
			try {
				$AWD_facebook_likebox = new AWD_facebook_likebox($href,$width,$height,$colorscheme,$show_faces,$stream,$header,$border_color,$force_wall,$template);
				return '<div class="AWD_facebook_likebox '.$options['like_box_css_classes'].'">'.$AWD_facebook_likebox->get().'</div>';
			} catch (Exception $e){
				return '<div class="ui-state-highlight">'.__("There is an error, please verify the settings for the Like Box URL",$this->plugin_text_domain).'</div>';
			}
		}
	}
	
	
	//****************************************************************************************
	//	ACTIVITY BOX 
	//****************************************************************************************
	/**
	 * Return the Activity Box shortcode
	 * @param array $atts
	 * @return string
	 */
	public function shortcode_activity_box($atts=array())
	{
        $new_atts = array();
        if(is_array($atts)){
			extract(shortcode_atts(array("init"=>"init"), $atts )); 
            foreach($atts as $att=>$value){
                $new_atts['activity_'.$att] = $value;
            }
        }
        return $this->get_the_activity_box($new_atts);
    }
	
	/**
	 * Return the Activity Button
	 * @param array $options
	 * @return string
	 */
	public function get_the_activity_box($options=array())
	{
		$site = ($options['activity_domain'] == '' ? $this->options['activity_domain'] : $options['activity_domain']);
		$width = ($options['activity_width'] == '' ? $this->options['activity_width'] : $options['activity_width']);
		$height = ($options['activity_height'] == '' ? $this->options['activity_height'] : $options['activity_height']);
		$header = (($options['activity_header'] == '' ? $this->options['activity_header'] : $options['activity_header']) == 1 ? 'true' : 'false');
		$colorscheme = ($options['activity_colorscheme'] == '' ? $this->options['activity_colorscheme'] : $options['activity_colorscheme']);
		$font = ($options['activity_font'] == '' ? $this->options['activity_font'] : $options['activity_font']);
		$border_color = ($options['activity_border_color'] == '' ? $this->options['activity_border_color'] : $options['activity_border_color']);
		$recommendations = (($options['activity_recommendations'] == '' ? $this->options['activity_recommendations'] : $options['activity_recommendations']) == 1 ? 'true' : 'false');
		$template = ($options['activity_type'] == '' ? $this->options['activity_type'] : $options['activity_type']);
		$filter = ($options['activity_filter'] == '' ? $this->options['activity_filter'] : $options['activity_filter']);
		$linktarget = ($options['activity_linktarget'] == '' ? $this->options['activity_linktarget'] : $options['activity_linktarget']);
		$max_age = ($options['activity_max_age'] == '' ? $this->options['activity_max_age'] : $options['activity_max_age']);
		$ref = ($options['activity_ref'] == '' ? $this->options['activity_ref'] : $options['activity_ref']);

		if($this->options['activity_domain'] == '' && $site == '')
			return '<div class="ui-state-highlight">'.__("There is an error, please verify the settings for the Acivity Box DOMAIN",$this->plugin_text_domain).'</div>';
		else{
			try {
				$AWD_facebook_activity = new AWD_facebook_activity($site,$width,$height,$header,$colorscheme,$font,$border_color,$recommendations,$filter,$linktarget,$ref,$max_age,$template);
				return '<div class="AWD_facebook_activity '.$options['activity_css_classes'].'">'.$AWD_facebook_activity->get().'</div>';
			} catch (Exception $e){
				return '<div class="ui-state-highlight">'.__("There is an error, please verify the settings for the Acivity Box DOMAIN",$this->plugin_text_domain).'</div>';
			}
		}
	}
	
	
	//****************************************************************************************
	//	REGISTER WIDGET
	//****************************************************************************************
	/**
	 * Like box register widgets
	 * @return void
	 */
	public function register_AWD_facebook_widgets()
	{
		 register_widget("AWD_facebook_widget_likebutton");
		 register_widget("AWD_facebook_widget_likebox");
		 register_widget("AWD_facebook_widget_loginbutton");
		 register_widget("AWD_facebook_widget_activity");
		 register_widget("AWD_facebook_widget_comments");
		 
		 do_action('AWD_facebook_register_widgets');
	}

	//****************************************************************************************
	//	DEBUG AND DEV
	//****************************************************************************************
	/**
	 * Debug
	 * @return void
	 */
	public function debug_content()
	{		
		if($this->options['debug_enable'] == 1){
			$_this = clone $this;
			$_this = (array) $_this;
			unset($_this['current_user']);
			unset($_this['wpdb']);
			unset($_this['optionsManager']);
			?>
			<div class="facebook_awd_debug">
				<h2><?php _e('Facebook AWD API',$this->plugin_text_domain); ?></h2><?php
				$this->Debug($_this['fcbk']);		
		
				?><h2><?php _e('Facebook AWD APPLICATIONS INFOS',$this->plugin_text_domain); ?></h2><?php
				$this->Debug($_this['options']['app_infos']);		
			
				?><h2><?php _e('Facebook AWD CURRENT USER',$this->plugin_text_domain); ?></h2><?php
				$this->Debug($_this['me']);	
				
				?><h2><?php _e('Facebook AWD Options',$this->plugin_text_domain); ?></h2><?php
				$this->Debug($_this['options']);		
				
				?><h2><?php _e('Facebook AWD FULL',$this->plugin_text_domain); ?></h2><?php
				$this->Debug($_this);
				?>
			</div>
			<script>
				jQuery(document).ready(function($){
					$('.facebook_awd_debug h2').each(function(){
						$(this).next().hide();
						$(this).css('fontSize', '20px');
						$(this).css('fontWeight', 'bold');
						$(this).css('borderBottom', '1px solid #000');
						$(this).css('cursor', 'pointer');
						$(this).click(function(){
							$(this).next().slideToggle();
						});
					});
				});
			</script>
			<?php
		}
	}

}

//****************************************************************************************
//	LIBRARY FACEBOOK AWD
//****************************************************************************************
require_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_options.php');
require_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_likebutton.php');
require_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_activity.php');
require_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_likebox.php');
require_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_comments.php');

//Object Plugin.
$AWD_facebook = new AWD_facebook();

//****************************************************************************************
//	WIDGET LIKE BOX include
//****************************************************************************************
include_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_widget_likebox.php');
include_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_widget_loginbutton.php');
include_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_widget_likebutton.php');
include_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_widget_activity.php');
include_once(dirname(__FILE__).'/inc/classes/class.AWD_facebook_widget_comments.php');
?>