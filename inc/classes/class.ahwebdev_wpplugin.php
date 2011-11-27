<?php
/*
* Class AHWEBDEV_wpplugin
* All plugins can use this parent class
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
* Last modification : 15/07/2011
*/
class AHWEBDEV_wpplugin{
    /**
    * public
    * current_user
    */
    public $current_user = array();
    /**
    * Name of the file of hte plugin
    */
    public $file_name = "AWD_facebook.php";
    /**
    *return current user in object.
    */
	public function current_user(){
	    global $current_user;
		get_currentuserinfo();
		$this->current_user = $current_user;
	}
    /**
	* Return IP
	*/
	public function get_ip(){
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];        
	}
	/**
	 * plugin version
	 */
	public function get_version($plugin_folder_var=array()){
		if (!function_exists('get_plugins'))
	    	require_once(ABSPATH.'wp-admin/includes/plugin.php');
	    if(count($plugin_folder_var)==0)
	        $plugin_folder = get_plugins('/'.plugin_basename( dirname(dirname(dirname( __FILE__ )))));
	    return $plugin_folder[$this->file_name]['Version'];
	}
	
	/**
	* Update Options from post
	*/
	public function update_options_from_post(){
	    return $this->update_options($_POST);
	}
	/**
	* Update Options from list of option
	* $options array.
	*/
	public function update_options($options){
	    if(is_array($options)){
            foreach($options as $option=>$value){
                update_option($option,$value);
            }
            return 1;
        }else{
            return 0;
        }
	}
	/**
	* Add / to end of a page
	* add_filter('user_trailingslashit', array(&$this,'add_page_slash'),100,2);
	*/
    public function add_page_slash($string, $type){
        global $wp_rewrite;
        if(ereg(".html",$string) && $wp_rewrite->use_trailing_slashes)
        	return untrailingslashit($string);
        else
        	return $string;
    }
	/**
	* function to catch firest image in html
	*/
	public function catch_that_image($post_content="") {
		global $post;
		if($post_content=="" && is_object($post))
			$post_content = $post->post_content;
  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $matches);
  		$first_img = $matches [1] [0];
  		return $first_img;
	}
	/*
	* Debug
	* $var
	* $detail 1 or 0
	* $core bool
	*/
	public function Debug($var,$detail=0){
			echo "<pre>";
			if($detail != 0)
				var_dump($var);
			else
				print_r($var);
			echo "</pre>";
	}
	/**
	* Get current URL
	*/
	public function get_current_url(){
	    return (empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	}
	/**
	* Admin Infos
	*/
	public function infos_content(){
	    ?>
	    <div style="text-align:center;">
			<div class="header_AWD_facebook_wrap">
				<h2 style="color:#627AAD;margin:0px;">
					<img style="vertical-align:middle;" src="<?php echo $this->plugin_url_images; ?>facebook.png" alt="facebook logo" class="AWD_button_media" width="35" height="35"/>Facebook AWD
					<sup style="color:#627AAD;font-size:0.6em;">v<?php echo $this->get_version(); ?></sup>
				</h2>
			</div>
			<a href="http://wordpress.org/extend/plugins/facebook-awd/" target="_blank" class="uiButton uiButtonNormal"><?php _e('Rate this plugin',$this->plugin_text_domain); ?></a>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" target="_blank" class="uiButton uiButtonNormal"><?php _e('Donate',$this->plugin_text_domain); ?></a>
			<a href="http://trac.ahwebdev.fr/projects/facebook-awd" target="_blank" class="uiButton uiButtonNormal">Support</a><br /><br />
			<?php echo do_shortcode('[AWD_likebutton url="http://www.ahwebdev.fr/plugins/facebook-awd.html" layout="standart" width="258" height="30" faces="0" xfbml="0"]'); ?><br />
			<?php echo do_shortcode('[AWD_likebox url="http://www.ahwebdev.fr" colorscheme="light" stream="0" xfbml="0" header="0" width="257" height="180" faces="1"]'); ?>
	    </div>
	    <p><?php printf(__('Please if you find Bug, report it to help us. You can report bug %shere%s',$this->plugin_text_domain),'<a href="http://trac.ahwebdev.fr/projects/facebook-awd">','</a>'); ?></p>
	    <?php
	}
}
?>