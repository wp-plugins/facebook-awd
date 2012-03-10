<?php
/*
* Class AWD_facebook_options
* (C) 2011 AH WEB DEV
* contact@ahwebdev.fr
* Last modification : 7/01/2012
*/
class AWD_facebook_options
{
	/**
	 * Protected Option var
	 */
	protected $options;
	
	/**
	 * Protected Wpdb instance WP database
	 */
	protected $wpdb;
	
	/**
	 * Protected prefix
	 */
	protected $prefix;
	
	/**
	 * Protected filterName
	 */
	protected $filterName = "AWD_facebook_options";
	
	/**
	 * Construct
	 * @param   string   Prefix (recommend use $AWD_facebook->plugin_option_pref)
	 * @param   object   wpdb instance
	 * @return  void
	 */
	public function __construct($prefix,$wpdb){
		$this->wpdb = $wpdb;
		$this->prefix = $prefix;
		//call filter for undefined vars
		add_filter($this->filterName, array($this,'defaultOptions'), 10, 1);
		
		//TODO Must called this only one time on update plugin hook
		//$this->mergeOld();
		//$this->load();
	}
	
	
	
	/**
	 * Set the default option if empty
	 * @param string $options_name
	 * @param array|string $default_value
	 * @return array
	 */
	public function setDefaultValue($options_name, $default_value)
	{
	    if($this->options[$options_name] == '')
	        $this->options[$options_name] = $default_value;
	}
	
	/**
	 * defaultOptions Options
	 * @param   Array   list of Options
	 * @param   object   wpdb instance
	 * @return  void
	 */
    public function defaultOptions()
    {
		global $AWD_facebook;
		
		//langs
		if($this->options['locale']==''){
		    if(defined('WPLANG')){
		        if(WPLANG==''){
		            $this->setDefaultValue('locale', 'en_US');
		        }else{
		            $this->setDefaultValue('locale', WPLANG);
		        }
		    }
		}
		
		//Define Default Vars if not set
		$this->setDefaultValue('connect_enable', 0);
		$this->setDefaultValue('open_graph_enable', 1);
		$this->setDefaultValue('connect_fbavatar', 0);

		//like button
		$this->setDefaultValue('like_button_on_pages', 0);
		$this->setDefaultValue('like_button_place_on_pages', 'top');
		$this->setDefaultValue('like_button_on_posts', 0);
		$this->setDefaultValue('like_button_place_on_posts', 'top');
		$this->setDefaultValue('like_button_on_custom_post_types', 0);
		$this->setDefaultValue('like_button_place_on_custom_post_types', 'top');
		$this->setDefaultValue('like_button_colorscheme', 'light');
		$this->setDefaultValue('like_button_send', 0);
		$this->setDefaultValue('like_button_height', 35);
		$this->setDefaultValue('like_button_faces', 35);
		$this->setDefaultValue('like_button_type', 'iframe');
		$this->setDefaultValue('like_button_action', 'like');
		$this->setDefaultValue('like_button_layout', 'standard');
		$this->setDefaultValue('like_button_url', home_url('url'));
		
		//like box
		$this->setDefaultValue('like_box_colorscheme', 'light');
		$this->setDefaultValue('like_box_width', 292);
		$this->setDefaultValue('like_box_height', 427);
		$this->setDefaultValue('like_box_faces', 1);
		$this->setDefaultValue('like_box_stream', 1);
		$this->setDefaultValue('like_box_header', 1);
		$this->setDefaultValue('like_box_type', 'iframe');	

		//activity box
		$this->setDefaultValue('activity_colorscheme', 'light');
		$this->setDefaultValue('activity_width', 292);
		$this->setDefaultValue('activity_height', 427);
		$this->setDefaultValue('activity_recommendations', 0);
		$this->setDefaultValue('activity_header', 1);
		$this->setDefaultValue('activity_type', 'iframe');
		
		//login button
		$this->setDefaultValue('login_button_display_on_login_page', 0);
		$this->setDefaultValue('login_button_width', 200);
		$this->setDefaultValue('login_button_maxrow', 1);
		$this->setDefaultValue('login_button_faces', 0);
		$this->setDefaultValue('login_button_logout_value', __('Logout',$AWD_facebook->plugin_text_domain));
		$this->setDefaultValue('login_button_image', $AWD_facebook->plugin_url_images.'f-connect.png');
		$this->setDefaultValue('login_button_profile_picture', 0);

		//comments
		$this->setDefaultValue('comments_url', get_bloginfo('url'));
		$this->setDefaultValue('comments_colorscheme', 'light');
		$this->setDefaultValue('comments_width', 500);
		$this->setDefaultValue('comments_nb', 10);
		$this->setDefaultValue('comments_type', 'iframe');
		
		//OpenGraph
		$this->setDefaultValue('ogtags_frontpage_title', '%BLOG_TITLE%');
		$this->setDefaultValue('ogtags_frontpage_site_name', '%BLOG_TITLE%');
		$this->setDefaultValue('ogtags_categories_site_name', '%BLOG_TITLE%');
		$this->setDefaultValue('ogtags_archives_site_name', '%BLOG_TITLE%');
		$this->setDefaultValue('ogtags_page_site_name', '%BLOG_TITLE%');
		$this->setDefaultValue('ogtags_post_site_name', '%BLOG_TITLE%');
		$this->setDefaultValue('ogtags_page_disable', 1);
		$this->setDefaultValue('ogtags_post_disable', 1);
		$this->setDefaultValue('ogtags_archives_disable', 1);
		$this->setDefaultValue('ogtags_frontpage_disable', 1);
		$this->setDefaultValue('ogtags_taxonomies_category_disable', 1);
		$this->setDefaultValue('ogtags_frontpage_type', 'website');
		$this->setDefaultValue('ogtags_categories_type', 'blog');
		$this->setDefaultValue('ogtags_archive_type', 'blog');
		$this->setDefaultValue('ogtags_page_type', 'blog');
		$this->setDefaultValue('ogtags_author_type', 'blog');
		$this->setDefaultValue('ogtags_post_type', 'article');
		$this->setDefaultValue('ogtags_taxonomies_category_title', '%TERM_TITLE%');
		$this->setDefaultValue('ogtags_taxonomies_category_description', '%TERM_DESCRIPTION%');
		$this->setDefaultValue('ogtags_post_title', '%POST_TITLE%');
		$this->setDefaultValue('ogtags_post_type', '%POST_TITLE%');
		$this->setDefaultValue('ogtags_archive_title', '%ARCHIVE_TITLE%');
		$this->setDefaultValue('ogtags_author_title', '%POST_TITLE%');
		$this->setDefaultValue('ogtags_author_image', '%AUTHOR_IMAGE%');
		$this->setDefaultValue('ogtags_author_description', '%AUTHOR_DESCRIPTION%');
		$this->setDefaultValue('ogtags_frontpage_description', '%BLOG_DESCRIPTION%');
		$this->setDefaultValue('ogtags_archive_description', '%BLOG_DESCRIPTION%');
		$this->setDefaultValue('ogtags_post_description', '%POST_EXCERPT%');
		$this->setDefaultValue('ogtags_page_description', '%POST_EXCERPT%');
		$this->setDefaultValue('ogtags_frontpage_locale', $this->options['locale']);
		$this->setDefaultValue('ogtags_categories_locale', $this->options['locale']);
		$this->setDefaultValue('ogtags_archives_locale', $this->options['locale']);
		$this->setDefaultValue('ogtags_page_locale', $this->options['locale']);
		$this->setDefaultValue('ogtags_post_locale', $this->options['locale']);
		$this->setDefaultValue('timeout', 10);

		//Define the perms with always email
		$array_perms = explode(",",$this->options['perms']);
		if(!in_array('email',$array_perms))
			$this->options['perms'] = str_replace(" ", "", rtrim('email,'.$this->options['perms'],','));  
			
		//Define default options for admin users.
		if(current_user_can('manage_options'))
			if(!in_array('manage_pages',$array_perms))
				$this->options['perms_admin'] = str_replace(" ", "",rtrim('manage_pages,'.$this->options['perms'],','));

        return $this->options;
    }
	
	/**
	 * Getter
	 * Options
	 * @return Array list of Options
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * Setter
	 * Options
	 * @param Array list of Options
	 * @return void
	 */
	public function setOptions($options)
	{
		$this->options = $options;
	}
	
	/**
	 * Load
	 * Load Options From database and apply filter : apply_filters($this->filterName, get_option($this->filterName));
	 * @return void
	 */
	public function load()
	{
		$this->options = get_option($this->filterName);
		//set default options
		$this->defaultOptions();
	}
	
	/**
	 * Save
	 * Save options in options table wp
	 */
	public function save()
	{
		$old_options = get_option($this->filterName);
		//create new options
		$this->options = array_merge($old_options, $this->options);
		//verify default value

		$this->defaultOptions();
		update_option($this->filterName, $this->options);
	}
	
	/**
	 * Add option
	 * Save options in options table wp
	 */
	public function update_option($name,$value,$flush=false)
	{
		$this->options[$name] = $value;
		if($flush === true)
			$this->save();
	}
	
	/**
	 * reset
	 * reset all Options with a new empty array.
	 */
	public function reset()
	{
		update_option($this->filterName, array());
	}
	
	/**
	 * Merge old format of options 
	 * (Only when update for the first time.)
	 * 
	 */
	public function mergeOld()
	{
		$AWD_options = $this->wpdb->get_results("SELECT option_name,option_value FROM ".$this->wpdb->options." WHERE option_name LIKE '%".$this->prefix."%'",'OBJECT');
		$new_options = array();
		//if we got options here, we need to transfert it in a new array and store it with new way
		if(count($AWD_options) > 0){
			foreach($AWD_options as $options=>$object){
				$option_name = str_ireplace($this->prefix,"",$object->option_name);
				$new_options[$option_name] = $object->option_value;
				//remove all old options form the table options
				delete_option($object->option_name);
			}
			update_option($this->filterName,$new_options);
		}
	}
	
	/**
	 * Debug
	 */
	public function debug()
	{
		echo '<pre>';
		var_dump($this->options);
		echo '</pre>';
	}
	
}
?>