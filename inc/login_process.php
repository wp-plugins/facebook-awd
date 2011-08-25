<?php
/*
*
* login AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*/

/*
* Version for PHP SDK 3.0
*/
if($this->uid){
	//test if we get email, if not call WP die to prevent empty user.
	if($this->me['email'] ==''){
		return false;
		//wp_die(__('Fb connect need email permission to work. You should logout from facebook and add email permission in FB connect settings',$this-plugin_text_domain));
	}
	//if user is logged in, then we just need to associate FB account with WordPress account
	if(is_user_logged_in()){
		$fb_uid = get_user_meta($this->current_user->ID,'fb_uid', true);

		//if uid == current user do nothing
		if($fb_uid == $this->uid)
			$step = 'logged';
		elseif(!$fb_uid){
			update_user_meta($this->current_user->ID,'fb_uid',$this->uid);
			$step = 'logged';
		}	

	}else{	
		//check if user has account in the website. get id 
		$existing_user = $this->wpdb->get_var( 'SELECT DISTINCT `u`.`ID` FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $this->uid . '" ) OR user_email = "' . $this->me['email'] . '" OR (`m`.`meta_key` = "fb_email" AND `m`.`meta_value` = "' . $this->me['email'] . '" )  LIMIT 1 ');
		//if the user exists - set cookie, do wp_login, redirect and exit
		if($existing_user > 0){
			$step = 'sync';
		//if user don't exist - create one and do all the same stuff: cookie, wp_login, redirect, exit
		}else{
			//if registration not enable
			if(get_option('users_can_register') == 1)
				$step = 'register';
			else
				wp_die(__('Wordpress registration is disabled, contact the administrator',$this-plugin_text_domain));
		}	    	
	}


	
	switch($step){
		
		/*********************************************/
		// User logged in
		/*********************************************/
		case 'logged':
			$fb_email = get_user_meta($this->current_user->ID, 'fb_email', true);
			if($this->me['email'] != $fb_email)
				update_user_meta($this->current_user->ID,'fb_email',$this->me['email']);
			$this->debug_echo[] = "User connected";
			return true;
		break;
		
		
		/*********************************************/
		// User sync and logged in
		/*********************************************/
		case 'sync':
			$fb_uid = get_user_meta($existing_user, 'fb_uid', true);
			if(!$fb_uid)
				update_user_meta($existing_user, 'fb_uid', $this->uid );
			//get user infos
			$user_info = get_userdata($existing_user);
			//connect the user
			wp_set_auth_cookie($existing_user, true, false);
			do_action('wp_login', $user_info->user_login);
			
			$this->debug_echo[] = "User login";
			//if($this->plugin_option['login_button_login_url'] != "")
				//wp_redirect(str_ireplace("%BLOG_URL%",home_url(),$this->plugin_option['login_button_login_url']));
			//else
				wp_redirect($this->get_current_url());
			exit();
		break;
		
		
		/*********************************************/
		// User register
		/*********************************************/
		case 'register':
			//sanitize username
			$username = sanitize_user($this->me['first_name'], true);
			//check if username is taken
			//if so - add something in the end and check again 
			$i='';
			while(username_exists($username . $i)){
				$i=absint($i);
				$i++;
			}

			//this will be new user login name
			$username = $username.$i;

			//put everything in nice array
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
			//create new user
			$new_user = wp_insert_user($userdata);
			
			if($new_user->errors){
				wp_die($this->Debug($new_user->errors));
			}elseif(is_int($new_user)){
				//add user meta fb_uid
				update_user_meta( $new_user, 'fb_uid', $this->uid );
				$user_info = get_userdata($new_user);
				//send email new registration
				wp_new_user_notification($new_user, $userdata['user_pass']);
				//connnect the user
				wp_set_auth_cookie($new_user, true, false);
				do_action('wp_login', $user_info->user_login);
				$this->debug_echo[] = "User register and was logged in";
				
				//if($this->plugin_option['login_button_login_url'] != "")
				    //wp_redirect(str_ireplace("%BLOG_URL%",home_url(),$this->plugin_option['login_button_login_url']));
                //else
                    wp_redirect($this->get_current_url());
                exit();
			}
		break;
		default :
		break;
	}//end switch
}


?>