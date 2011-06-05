<?php
/*
*
* Class AHWEBDEV_wpplugin
* All plugins can use this parent class
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/


class AHWEBDEV_wpplugin{
    /*
    * public
    * current_user
    */
    public $current_user = array();
    
    
    /*
	* Return IP
	*/
	public function get_ip(){
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else
			$ip = $_SERVER['REMOTE_ADDR'];        
		return $ip;
	}
	
	/*
	* Update Options from post
	*/
	public function update_options_from_post(){
	    return $this->update_options($_POST);
	}
	
	/*
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
	
	/*
	* Current User
	*/
	public function current_user(){
	    global $current_user;
		get_currentuserinfo();
		$this->current_user = $current_user;
	}
	/*
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
    /*
	* Admin Infos
	*/
	public function infos_content(){
	    ?>
	    <p><fb:like href="http://www.ahwebdev.fr" send="true" width="255" show_faces="false" font="lucida grande"></fb:like></p>
	    <p><a href="http://www.ahwebdev.fr"><?php _e('Developed by AH WEB DEV',$this->plugin_text_domain); ?></a></p>
	    <p><a href="mailto:contact@ahwebdev.fr" title="Mail">Contact</a></p>
	    <?php
	}
    
}
?>