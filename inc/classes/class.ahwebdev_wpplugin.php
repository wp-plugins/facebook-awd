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
		return $ip;
	}
	/**
	 * plugin version
	 */
	public function get_version(){
		if (!function_exists('get_plugins'))
	    	require_once(ABSPATH.'wp-admin/includes/plugin.php');
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
	public function catch_that_image() {
  		global $post, $posts;
  		$first_img = '';
  		ob_start();
  		ob_end_clean();
  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  		$first_img = $matches [1] [0];
  		if(empty($first_img)){ //Defines a default image
    		//$first_img = "/images/default.jpg";
  		}
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
	* Admin Infos
	*/
	public function infos_content(){
	    ?>
	    <p><fb:like href="http://www.ahwebdev.fr/plugins/facebook-awd.html" send="true" width="255" show_faces="false" font="lucida grande"></fb:like></p>
	    <p style="text-align:center; font-size:1.3em;"><?php _e('Support this plugin',$this->plugin_text_domain); ?>
	    <form style="width:153px;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="ZQ2VL33YXHJLC">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		</form>
		</p>

		<p style="text-align:center;font-size:1.3em;"><a href="http://wordpress.org/extend/plugins/facebook-awd/"><?php _e('Rate this plugin',$this->plugin_text_domain); ?></a></p>


	    <p style="text-align:center;">
	    <a href="http://www.ahwebdev.fr"><img src="http://www.ahwebdev.fr/wp-content/themes/ahwebdev/images/logos/logo-flat-ahwebdev.png" width="150" height="63" style="vertical-align:middle"/></a>
	    </p>
	    <p><a href="mailto:contact@ahwebdev.fr" title="Mail">Contact</a></p>
	    <p><?php printf(__('This version is under developpement, please report bug if you find it to help us. You can report bug %shere%s',$this->plugin_text_domain),'<a href="http://wordpress.org/tags/facebook-awd?forum_id=10#postform">','</a>'); ?></p>
	    <?php
	}
}
?>