<?php
/*
Plugin Name: Facebook AWD Comments Plus
Plugin URI: http://www.ahwebdev.fr
Description: This plugin merge Facebook Comments with native Wordpress Comments System. Need Facebook AWD All in One plugin v0.9.7.2 to work.
Version: 0.1
Author: AHWEBDEV
Author URI: http://www.ahwebdev.fr
License: Copywrite AHWEBDEV
Text Domain: AWD_facebook_comments_plus
Last modification: 15/07/2011
*/
Class AWD_facebook_comments_plus{

	//****************************************************************************************
	//	VARS
	//****************************************************************************************
    /***
    * public
    * Name of the plugin
    */
    public $plugin_name = 'Facebook AWD Comments Plus';
    /**
    * public
    * slug of the plugin
    */
    public $plugin_slug = 'awd_fcbk_comments_plus';
    /**
    * public
    * preffix blog option
    */
    public $plugin_text_domain = 'AWD_facebook_comments_plus';
    /**
    * public
    * Version required to work with Facebook AWD
    */
    public $version_requiered = '0.9.7.2';
	
	//****************************************************************************************
	//	INIT
	//****************************************************************************************
	/**
	 * plugin construct
	 */
	public function __construct(){
		add_action('init',array(&$this,'initial'));
	}
	/**
	 * plugin init
	 */
	public function initial(){
		global $AWD_facebook;
		$this->AWD_facebook = $AWD_facebook;
	    require_once(ABSPATH.'wp-admin/includes/plugin.php');
		if(is_plugin_inactive('facebook-awd/AWD_facebook.php')){
			add_action('admin_notices',array(&$this,'missing_parent'));
			deactivate_plugins(__FILE__);
		}elseif($this->AWD_facebook->get_version() < $this->version_requiered){
			add_action('admin_notices',array(&$this,'old_parent'));
			deactivate_plugins(__FILE__);
		}else
			add_action('AWD_facebook_plugins_init',array(&$this,'self_init'));
	}
	/**
	* Real init when AWD_facebook is init too.
	*/
	public function self_init(){
		//do here what we need to do with this plugin...
		//add plugin Menu and form for option
		add_action('AWD_facebook_plugins_menu',array(&$this,'plugin_menu'));
		add_action('AWD_facebook_plugins_form',array(&$this,'plugin_form'));
	}
	/**
	* Add a line for menu plugins
	*/
	public function plugin_menu(){
		?>
		<li><a href="#comments_plus_settings"><?php _e('Comments +',$this->plugin_text_domain); ?></a></li>
		<?php
	}
	/**
	* add content for content (managed by jQuey-ui.)
	*/
	public function plugin_form(){
		?>
		<div id="comments_plus_settings">
			<p><i><?php _e('Comments + for Facebook AWD',$this->plugin_text_domain); ?></i></p>
			<p><i><?php _e('This plugin is non free usage, you need to have a licence to use it.',$this->plugin_text_domain); ?></i></p>
			<div class="uiForm">
				<table class="AWD_form_table">
					<tr class="dataRow">
						<th class="label"><?php _e('Test',$this->plugin_text_domain); ?> <?php echo $this->AWD_facebook->get_the_help('activity_domain'); ?></th>
						<td class="data">
							<input type="text" class="uiText" id="<?php echo $this->plugin_option_pref; ?>activity_domain" name="<?php echo $this->plugin_option_pref; ?>activity_domain" value="<?php echo $this->plugin_option['activity_domain']; ?>" size="30"/>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php
	}
	/**
	* Add notice if Facebook AWD is not present and activated
	*/
	public function missing_parent(){
			echo '<div class="error"><p>'.$this->plugin_name.' '.__("can not be activated: Facebook AWD All in One plugin must be installed... you can download it from the Wordpress plugin directory",$this->plugin_text_domain).'</p></div>';
	}
	/**
	* Add notice if Facebook AWD is too old
	*/
	public function old_parent(){
			echo '<div class="error"><p>'.$this->plugin_name.' '.__("can not be activated: Facebook AWD All in One plugin is out to date... You can download the last version or update it from the Wordpress plugin directory",$this->plugin_text_domain).'</p></div>';
	}
}
$AWD_facebook_comments_plus = new AWD_facebook_comments_plus();
?>